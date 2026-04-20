@php
    $relativePath = "images/compatibility/CUSA/{$getRecord()->code}.png";
    $exists = file_exists(public_path($relativePath));
@endphp

@if ($exists)
    <img
        src="{{ asset($relativePath) }}"
        alt="{{ $getRecord()->title }}"
        class="aspect-square size-20 rounded-md object-cover my-2"
    >
@else
    <div class="flex aspect-square size-20 items-center justify-center rounded-md bg-gray-300 dark:bg-gray-700 my-2">
        <x-filament::icon
            icon="heroicon-o-question-mark-circle"
            class="text-text size-8"
        />
    </div>
@endif
