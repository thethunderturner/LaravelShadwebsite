@php
    $videoUrl = \App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks\YoutubeBlock::getVideoUrl($url);
@endphp

@if(!empty($videoUrl))
    <div class="w-full h-full">
        <iframe
            class="w-full aspect-video"
            src="{{ $videoUrl }}"
            title="Video Player"
            frameborder="0"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
            referrerpolicy="strict-origin-when-cross-origin"
            allowfullscreen>
        </iframe>
    </div>
@else
    <div class="relative mx-auto h-96 flex items-center justify-center bg-gray-100 dark:bg-gray-800">
        <p class="text-gray-500 dark:text-gray-400">Video URL not available or invalid: {{ $videoUrl }}</p>
    </div>
@endif
