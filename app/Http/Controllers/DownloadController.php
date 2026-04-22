<?php

namespace App\Http\Controllers;

use App\Models\Download;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class DownloadController extends Controller
{
    private const array OS_LIST = ['windows', 'linux', 'macos'];

    private const string QT_RELEASES_URL = 'https://api.github.com/repos/shadps4-emu/shadps4-qtlauncher/releases';

    public function __invoke(Request $request): View
    {
        $qt = $this->latestQtLauncher();

        $cliVersions = $this->availableCliVersions();
        $selectedVersion = $request->query('version') ?: $cliVersions->first();
        $selectedCli = $selectedVersion ? $this->cliByOs($selectedVersion) : collect();

        return view('downloads', [
            'qt' => $qt,
            'qtReleaseDate' => $qt['release_date'] ?? null,
            'cliVersions' => $cliVersions,
            'selectedVersion' => $selectedVersion,
            'selectedCli' => $selectedCli,
            'cliReleaseDate' => $selectedCli->values()->first()?->release_date,
        ]);
    }

    private function latestQtLauncher(): array
    {
        $raw = Cache::remember('qt-launcher-latest', now()->addMinutes(15), function (): array {
            $response = Http::acceptJson()->get(self::QT_RELEASES_URL);

            if (! $response->successful()) {
                return ['published_at' => null, 'windows' => null, 'linux' => null, 'macos' => null];
            }

            $release = $response->json('0');

            if (! $release) {
                return ['published_at' => null, 'windows' => null, 'linux' => null, 'macos' => null];
            }

            $assets = collect($release['assets'] ?? []);

            return [
                'published_at' => $release['published_at'] ?? null,
                'windows' => $this->pickAsset($assets, 'win64'),
                'linux' => $this->pickAsset($assets, 'linux'),
                'macos' => $this->pickAsset($assets, 'macos'),
            ];
        });

        return [
            'release_date' => $raw['published_at'] ? Carbon::parse($raw['published_at']) : null,
            'windows' => $raw['windows'],
            'linux' => $raw['linux'],
            'macos' => $raw['macos'],
        ];
    }

    private function pickAsset(Collection $assets, string $needle): ?array
    {
        $match = $assets->first(fn (array $asset): bool => str_contains(strtolower($asset['name'] ?? ''), $needle));

        return $match ? [
            'url' => $match['browser_download_url'],
            'count' => (int) ($match['download_count'] ?? 0),
        ] : null;
    }

    private function availableCliVersions(): Collection
    {
        return Download::query()
            ->where('type', 'cli')
            ->orderByDesc('release_date')
            ->distinct()
            ->pluck('version')
            ->values();
    }

    private function cliByOs(string $version): Collection
    {
        return Download::query()
            ->where('type', 'cli')
            ->where('version', $version)
            ->get()
            ->keyBy('os');
    }
}
