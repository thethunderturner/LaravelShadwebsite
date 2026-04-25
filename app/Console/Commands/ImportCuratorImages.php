<?php

namespace App\Console\Commands;

use App\Models\Media;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

#[Signature('curator:import-images {--disk=public_images} {--directory=}')]
#[Description('Import every image already sitting in the configured disk into the curator table.')]
class ImportCuratorImages extends Command
{
    private const array ALLOWED_EXTS = ['jpg', 'jpeg', 'png', 'webp', 'gif', 'avif', 'svg'];

    public function handle(): int
    {
        $diskName = (string) $this->option('disk');
        $directory = (string) ($this->option('directory') ?? '');

        $disk = Storage::disk($diskName);
        $files = collect($disk->allFiles($directory));

        $imported = 0;
        $skipped = 0;

        foreach ($files as $path) {
            $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
            if (! in_array($ext, self::ALLOWED_EXTS, true)) {
                continue;
            }

            if (Media::query()->where('disk', $diskName)->where('path', $path)->exists()) {
                $skipped++;

                continue;
            }

            $fullPath = $disk->path($path);
            $size = File::size($fullPath);
            $name = pathinfo($path, PATHINFO_FILENAME);
            $subDir = pathinfo($path, PATHINFO_DIRNAME);
            $subDir = in_array($subDir, ['', '.'], true) ? null : $subDir;
            [$width, $height] = $this->dimensions($fullPath, $ext);

            Media::query()->create([
                'disk' => $diskName,
                'directory' => $subDir,
                'visibility' => 'public',
                'name' => $name,
                'path' => $path,
                'width' => $width,
                'height' => $height,
                'size' => $size,
                'type' => File::mimeType($fullPath) ?: 'application/octet-stream',
                'ext' => $ext,
                'alt' => null,
                'title' => Str::headline($name),
                'pretty_name' => Str::headline($name),
            ]);

            $imported++;
            $this->info("imported: {$path}");
        }

        $this->info("Done. Imported {$imported}, skipped {$skipped} (already present).");

        return self::SUCCESS;
    }

    /**
     * @return array{0: ?int, 1: ?int}
     */
    private function dimensions(string $fullPath, string $ext): array
    {
        if ($ext === 'svg') {
            return [null, null];
        }

        $info = @getimagesize($fullPath);

        return $info === false ? [null, null] : [(int) $info[0], (int) $info[1]];
    }
}
