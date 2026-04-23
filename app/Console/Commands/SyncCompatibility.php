<?php

namespace App\Console\Commands;

use App\Models\CompatibilityDb;
use App\Models\CompatibilityList;
use App\Models\ErrorList;
use Carbon\CarbonImmutable;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Throwable;

#[Signature('compatibility:sync')]
#[Description('Sync the shadPS4 game compatibility list (GitHub issues) and cover images (Sony TMDB).')]
class SyncCompatibility extends Command
{
    private const string CODE_PATTERN = '/[a-zA-Z]{4}[0-9]{5}/';

    private const string IMAGE_DIR = 'images/compatibility/CUSA';

    private const string TMDB_USER_AGENT = 'Mozilla/5.0 (PlayStation; PlayStation 4/11.00) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/15.4 Safari/605.1.15';

    public function handle(): int
    {
        if (CompatibilityList::query()->exists()) {
            $since = CompatibilityList::query()->max('updated_at');
            $this->info('Delta sync since '.$since);
            $this->deltaSync(CarbonImmutable::parse($since));
        } else {
            $this->info('No records found - full sync');
            $this->fullSync();
        }

        $this->info('Syncing images + metadata');
        $this->syncImagesAndMetadata();

        $this->info('Done');

        return self::SUCCESS;
    }

    private function fullSync(): void
    {
        $repo = config('services.github.compatibility_repo');
        $meta = $this->github()->get("https://api.github.com/repos/{$repo}")->json();
        $total = (int) ($meta['open_issues_count'] ?? 0);
        $pages = max(1, (int) ceil($total / 100));
        $processed = 0;

        for ($page = 1; $page <= $pages; $page++) {
            $issues = $this->github()->get("https://api.github.com/repos/{$repo}/issues", [
                'page' => $page,
                'per_page' => 100,
                'state' => 'open',
                'direction' => 'asc',
            ])->json() ?? [];

            foreach ($issues as $issue) {
                $parsed = $this->parseIssue($issue);
                if ($parsed === null) {
                    continue;
                }
                CompatibilityList::query()->updateOrCreate(['id' => $parsed['id']], $parsed);
                $processed++;
            }
        }

        $this->info("Processed {$processed} issues of {$total}.");
    }

    private function deltaSync(CarbonImmutable $since): void
    {
        $repo = config('services.github.compatibility_repo');
        $sinceIso = $since->toIso8601ZuluString();

        ErrorList::query()->delete();

        $closed = $this->github()->get("https://api.github.com/repos/{$repo}/issues", [
            'state' => 'closed',
            'per_page' => 100,
            'since' => $sinceIso,
        ])->json() ?? [];

        foreach ($closed as $issue) {
            $id = filter_var($issue['number'] ?? null, FILTER_VALIDATE_INT);
            if ($id !== false && $id !== null) {
                CompatibilityList::query()->whereKey($id)->delete();
            }
        }

        $changed = $this->github()->get("https://api.github.com/repos/{$repo}/issues", [
            'per_page' => 100,
            'since' => $sinceIso,
        ])->json() ?? [];

        $processed = 0;
        foreach ($changed as $issue) {
            $parsed = $this->parseIssue($issue);
            if ($parsed === null) {
                continue;
            }
            CompatibilityList::query()->updateOrCreate(['id' => $parsed['id']], $parsed);
            $processed++;
        }

        $this->info('Deleted '.(is_array($closed) ? count($closed) : 0)." closed, upserted {$processed} changed.");
    }

    private function parseIssue(array $issue): ?array
    {
        $id = filter_var($issue['number'] ?? null, FILTER_VALIDATE_INT);
        $title = htmlspecialchars((string) ($issue['title'] ?? ''));
        $tags = array_column($issue['labels'] ?? [], 'name');
        $milestone = htmlspecialchars(trim((string) ($issue['milestone']['title'] ?? ''), 'v'));

        $status = '';
        $os = '';
        foreach ($tags as $tag) {
            if (str_starts_with($tag, 'status-')) {
                $status = ucfirst(str_ireplace('status-', '', $tag));
            }
            if (str_starts_with($tag, 'os-')) {
                $os = ucfirst(str_ireplace('os-', '', $tag));
            }
        }

        if ($milestone === '') {
            return $this->logError($id, "entry {$id} title {$title} dont have milestone");
        }

        if (! preg_match(self::CODE_PATTERN, $title, $matches)) {
            return $this->logError($id, "entry {$id} title {$title} not supported");
        }

        $code = str_starts_with($matches[0], 'CUSA') ? $matches[0] : '';
        $type = $code !== '' ? 'PS4game' : '';
        $cleanTitle = ltrim(str_replace(['- '.$matches[0], '-'.$matches[0], $matches[0]], '', $title), ' -');

        if ($code === '') {
            return $this->logError($id, "entry {$id} title {$title} code is empty");
        }
        if ($os === '') {
            return $this->logError($id, "entry {$id} title {$title} os is empty");
        }
        if ($status === '') {
            return $this->logError($id, "entry {$id} title {$title} status is empty");
        }

        return [
            'id' => $id,
            'code' => $code,
            'title' => $cleanTitle,
            'created_at' => CarbonImmutable::parse($issue['created_at']),
            'updated_at' => CarbonImmutable::parse($issue['updated_at']),
            'version' => $milestone,
            'type' => $type,
            'status' => $status,
            'os' => $os,
        ];
    }

    private function logError(?int $id, string $reason): null
    {
        ErrorList::query()->updateOrCreate(
            ['id' => $id],
            ['reason' => $reason],
        );
        $this->warn($reason);

        return null;
    }

    private function syncImagesAndMetadata(): void
    {
        $dir = public_path(self::IMAGE_DIR);
        if (! is_dir($dir) && ! mkdir($dir, 0755, true) && ! is_dir($dir)) {
            $this->error("Image dir not writable: {$dir}");

            return;
        }

        $hmacKey = config('services.tmdb.hmac_key');
        if (empty($hmacKey)) {
            $this->warn('TMDB_HMAC_KEY not set — skipping image sync');

            return;
        }

        $rows = CompatibilityList::query()->orderByDesc('updated_at')->get(['code']);
        foreach ($rows as $row) {
            $code = $row->code;
            $path = "{$dir}/{$code}.png";
            if (file_exists($path)) {
                continue;
            }

            try {
                $hash = strtoupper(hash_hmac('sha1', "{$code}_00", hex2bin($hmacKey)));
                $meta = Http::withUserAgent(self::TMDB_USER_AGENT)
                    ->get("https://tmdb.np.dl.playstation.net/tmdb2/{$code}_00_{$hash}/{$code}_00.json")
                    ->json();

                if (empty($meta['icons'][0]['icon'])) {
                    $this->warn("No icon for {$code}");

                    continue;
                }

                usleep(random_int(200_000, 500_000));

                $iconUrl = str_replace('http://', 'https://', $meta['icons'][0]['icon']);
                $imageData = Http::withUserAgent(self::TMDB_USER_AGENT)->get($iconUrl)->body();

                if ($this->saveThumbnail($imageData, $path)) {
                    $this->info("Image saved: {$code}");
                }

                CompatibilityDb::query()->updateOrCreate(
                    ['codedb' => $code],
                    [
                        'titledb' => $meta['names'][0]['name'] ?? '',
                        'parentalLevel' => $meta['parentalLevel'] ?? 0,
                        'contentId' => $meta['contentId'] ?? '',
                        'category' => $meta['category'] ?? '',
                        'psVr' => (bool) ($meta['psVr'] ?? false),
                        'neoEnable' => (bool) ($meta['neoEnable'] ?? false),
                    ],
                );
            } catch (Throwable $e) {
                $this->error("Failed {$code}: ".$e->getMessage());
            }
        }
    }

    private function saveThumbnail(string $imageData, string $path): bool
    {
        $src = @imagecreatefromstring($imageData);
        if ($src === false) {
            return false;
        }

        $thumb = imagecreatetruecolor(256, 256);
        imagecopyresized($thumb, $src, 0, 0, 0, 0, 256, 256, imagesx($src), imagesy($src));
        $ok = imagepng($thumb, $path, 2);
        imagedestroy($thumb);
        imagedestroy($src);

        return $ok;
    }

    private function github(): PendingRequest
    {
        return Http::withToken(config('services.github.token'))
            ->withHeaders(['Accept' => 'application/vnd.github+json'])
            ->withUserAgent('shadps4.net')
            ->acceptJson();
    }
}
