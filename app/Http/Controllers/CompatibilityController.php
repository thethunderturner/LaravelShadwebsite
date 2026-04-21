<?php

namespace App\Http\Controllers;

use App\Models\CompatibilityList;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;

class CompatibilityController extends Controller
{
    private const array TAGS = ['Playable', 'Ingame', 'Menus', 'Boots', 'Nothing'];

    private const array OS_LIST = ['Windows', 'Linux', 'MacOS'];

    public function __invoke(): View
    {
        $grouped = CompatibilityList::query()
            ->select('os', 'status', DB::raw('COUNT(*) as count'))
            ->whereIn('os', self::OS_LIST)
            ->groupBy('os', 'status')
            ->get()
            ->groupBy('os');

        $stats = collect(self::OS_LIST)->mapWithKeys(function (string $os) use ($grouped): array {
            $rows = $grouped->get($os, collect());
            $counts = $rows->pluck('count', 'status');
            $total = (int) $counts->sum();

            $tagStats = collect(self::TAGS)->map(fn (string $tag): array => [
                'tag' => $tag,
                'count' => (int) $counts->get($tag, 0),
                'total' => $total,
                'percent' => $total > 0 ? round(($counts->get($tag, 0) / $total) * 100, 2) : 0.0,
            ])->all();

            return [$os => $tagStats];
        })->all();

        return view('compatibility', ['stats' => $stats]);
    }
}
