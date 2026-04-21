@props(['name', 'cusa', 'players'])

@php
    $imagePath = "images/compatibility/CUSA/{$cusa}.png";
    $imageExists = file_exists(public_path($imagePath));
@endphp

<article class="mx-auto w-full max-w-xl">
    <div class="aspect-5/2 w-full rounded-lg border p-4 bg-header border-border">
        <div class="flex h-full items-start gap-x-4">
            @if ($imageExists)
                <img
                    src="{{ asset($imagePath) }}"
                    alt="{{ $name }}"
                    class="aspect-square h-full shrink-0 rounded-lg object-cover">
            @else
                <div
                    class="aspect-square h-full shrink-0 rounded-lg bg-zinc-300 dark:bg-zinc-700 items-center justify-center flex">
                    <x-heroicon-c-question-mark-circle class="text-text size-20"/>
                </div>
            @endif

            <div class="flex min-w-0 flex-col">
                <h2 class="truncate text-2xl leading-tight font-bold text-zinc-900 dark:text-zinc-100">{{ $name }}</h2>
                <span class="text-text font-bold pt-2">
                    CUSA: <span class="text-zinc-600 dark:text-zinc-400">{{ $cusa }}</span>
                </span>
                <span class="text-text font-bold">
                    Active Players: <span class="text-zinc-600 dark:text-zinc-400">{{ $players }}</span>
                </span>
            </div>
        </div>
    </div>
</article>
