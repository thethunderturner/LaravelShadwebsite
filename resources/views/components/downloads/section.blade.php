@props([
    'title',
    'info' => null,
    'releaseDate' => null,
])

<section class="bg-card border-border rounded-lg border p-6">
    <div class="flex flex-wrap items-start justify-between gap-4 border-b border-border pb-4">
        <div class="flex flex-col">
            <h2 class="text-text text-2xl font-bold">{{ $title }}</h2>
            @if ($releaseDate)
                <span class="text-text/70 text-sm">Released {{ $releaseDate->format('M j, Y') }}</span>
            @endif
        </div>

        @isset ($headerAction)
            <div>{{ $headerAction }}</div>
        @endisset
    </div>

    @if ($info)
        <p class="text-text/80 mt-4 text-sm leading-relaxed">{{ $info }}</p>
    @endif

    <div class="mt-6 grid grid-cols-1 gap-4 md:grid-cols-3">
        {{ $slot }}
    </div>
</section>
