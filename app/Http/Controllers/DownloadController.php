<?php

namespace App\Http\Controllers;

use App\Models\Download;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class DownloadController extends Controller
{
    private const array OS_LIST = ['windows', 'linux', 'macos'];

    public function __invoke(Request $request): View
    {
        $latestQt = $this->latestPerOs('qt');
        $cliVersions = $this->availableVersions('cli');
        $selectedVersion = $request->query('version') ?: $cliVersions->first();
        $selectedCli = $selectedVersion ? $this->byVersionPerOs('cli', $selectedVersion) : collect();

        return view('downloads', [
            'latestQt' => $latestQt,
            'qtReleaseDate' => $latestQt->values()->first()?->release_date,
            'cliVersions' => $cliVersions,
            'selectedVersion' => $selectedVersion,
            'selectedCli' => $selectedCli,
            'cliReleaseDate' => $selectedCli->values()->first()?->release_date,
        ]);
    }

    /**
     * @return Collection<string, Download>
     */
    private function latestPerOs(string $type): Collection
    {
        return collect(self::OS_LIST)->mapWithKeys(fn (string $os): array => [
            $os => Download::query()
                ->where('type', $type)
                ->where('os', $os)
                ->orderByDesc('release_date')
                ->first(),
        ])->filter();
    }

    /**
     * @return Collection<int, string>
     */
    private function availableVersions(string $type): Collection
    {
        return Download::query()
            ->where('type', $type)
            ->orderByDesc('release_date')
            ->distinct()
            ->pluck('version')
            ->values();
    }

    /**
     * @return Collection<string, Download>
     */
    private function byVersionPerOs(string $type, string $version): Collection
    {
        return Download::query()
            ->where('type', $type)
            ->where('version', $version)
            ->get()
            ->keyBy('os');
    }
}
