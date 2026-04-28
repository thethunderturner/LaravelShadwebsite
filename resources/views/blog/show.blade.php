@php
    use App\Support\Markdown;
    $heroImage = $post->image ? asset('images/'.$post->image) : null;
@endphp

<x-layout :title="$post->title">
    <article class="mx-auto max-w-6xl">
        @if ($heroImage)
            <div class="mb-8 overflow-hidden rounded-2xl">
                <img
                    src="{{ $heroImage }}"
                    alt="{{ $post->title }}"
                    class="aspect-21/9 w-full object-cover"
                    loading="eager"
                >
            </div>
        @endif

        <div class="mx-auto flex max-w-2xl gap-x-10 lg:max-w-5xl">
            {{--Content--}}
            <div class="w-full flex-1">
                <div class="prose">
                    <time class="text-text/60 text-sm tabular-nums">
                        {{ $post->pubDate->format('F j, Y') }}
                    </time>

                    <h1 class="text-text mt-2 text-4xl leading-tight font-bold sm:text-5xl">
                        {{ $post->title }}
                    </h1>

                    @if ($post->description)
                        <p class="text-text/80 mt-4 text-lg leading-relaxed">
                            {{ $post->description }}
                        </p>
                    @endif
                    {{ \Filament\Forms\Components\RichEditor\RichContentRenderer::make($post->content)->customBlocks([\App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks\YoutubeBlock::class]) }}
                </div>
            </div>
            {{-- Info and TOC --}}
            <div class="w-66 lg:block">
                @if ($post->category)
                    <div>
                        <h3 class="text-text/50 text-xs font-bold tracking-wider uppercase">Category</h3>
                        <div class="mt-2 flex flex-wrap gap-2">
                            <x-filament::badge color="info">
                                {{ $post->category }}
                            </x-filament::badge>
                        </div>
                    </div>
                @endif

                <div class="sticky top-16">
                    <div class="text-sm/6 font-semibold text-gray-950 dark:text-white">
                        On this page
                    </div>
                    {{--TOC--}}
                </div>
            </div>
        </div>
    </article>
</x-layout>
