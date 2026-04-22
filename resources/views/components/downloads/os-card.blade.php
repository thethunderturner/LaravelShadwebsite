@props([
    'name',
    'icon',
    'description',
    'download' => null,
    'buttonColor' => 'blue',
])

@php
    $colorClasses = [
        'blue' => 'bg-blue-600 hover:bg-blue-500',
        'green' => 'bg-green-600 hover:bg-green-500',
        'red' => 'bg-red-600 hover:bg-red-500',
    ][$buttonColor] ?? 'bg-blue-600 hover:bg-blue-500';
    $available = $download !== null;
@endphp

<div class="bg-root border-border flex flex-col rounded-lg border p-4">
    <div class="flex items-center gap-x-3">
        <img src="{{ asset($icon) }}" alt="{{ $name }} logo" class="size-10 shrink-0">
        <h3 class="text-text text-lg font-semibold">{{ $name }}</h3>
    </div>

    <p class="text-text/70 mt-3 text-sm">{{ $description }}</p>

    <div class="mt-auto flex items-center justify-between pt-6">
        <span class="text-text/60 text-xs tabular-nums">
            @if ($available)
                {{ number_format((int) $download->count) }} downloads
            @else
                Unavailable
            @endif
        </span>

        @if ($available)
            <a
                href="{{ route('downloads.go', $download) }}"
                class="{{ $colorClasses }} rounded-md px-4 py-2 text-sm font-semibold text-white transition"
            >
                Download
            </a>
        @else
            <button
                type="button"
                disabled
                class="cursor-not-allowed rounded-md bg-gray-600 px-4 py-2 text-sm font-semibold text-white/60"
            >
                Not available
            </button>
        @endif
    </div>
</div>
