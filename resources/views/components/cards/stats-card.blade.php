@props(['name', 'icon', 'stats'])

@php
    $barColors = [
        'Playable' => 'bg-status-playable',
        'Ingame' => 'bg-status-ingame',
        'Menus' => 'bg-status-menus',
        'Boots' => 'bg-status-boots',
        'Nothing' => 'bg-status-nothing',
    ];
    $total = $stats[0]['total'] ?? 0;
@endphp

<div class="bg-card border-border flex max-h-full w-full flex-col rounded-lg border p-4 lg:w-110">
    <div class="border-border flex flex-row gap-x-4 border-b pb-4">
        <img src="{{ asset($icon) }}" alt="{{ $name }} logo" class="size-12">
        <div class="flex flex-col">
            <span class="text-text text-xl font-normal">{{ $name }}</span>
            <span class="text-text text-sm font-normal">Tested games: {{ $total }}</span>
        </div>
    </div>

    <div class="mt-4 flex flex-col gap-3 overflow-y-auto pr-1">
        @foreach ($stats as $row)
            @php
                $widthPct = $row['total'] === 0 ? 0 : ($row['count'] / $row['total']) * 100;
                $barColor = $barColors[$row['tag']] ?? 'bg-gray-500';
            @endphp

            <div class="flex flex-col gap-1">
                <div class="flex items-baseline justify-between">
                    <span class="text-text text-sm">{{ $row['tag'] }}</span>
                    <span class="text-text text-xs tabular-nums">
                        {{ $row['count'] }} - {{ number_format($row['percent'], 2) }}%
                    </span>
                </div>

                <div
                    class="h-3 w-full overflow-hidden rounded bg-gray-200/70 dark:bg-white/10"
                    role="progressbar"
                    aria-label="{{ $row['tag'] }} games"
                    aria-valuemin="0"
                    aria-valuenow="{{ (int) round($widthPct) }}"
                    aria-valuemax="100"
                >
                    <div class="{{ $barColor }} h-full rounded" style="width: {{ $widthPct }}%"></div>
                </div>
            </div>
        @endforeach
    </div>
</div>
