@php
    use App\Support\Markdown;
    $heroImage = $post->image ? asset('images/'.$post->image) : null;
@endphp

<x-layout>
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

        <div class="flex flex-col gap-10 lg:flex-row lg:gap-x-12">
            {{--Content--}}
            <div class="min-w-0 flex-1">
                <div class="prose dark:prose-invert max-w-none flex flex-col gap-y-0.5">
                    <time class="text-text/60 text-sm tabular-nums">
                        {{ $post->pubDate->format('F j, Y') }}
                    </time>

                    <span class="text-text text-4xl font-bold sm:text-5xl">
                        {{ $post->title }}
                    </span>

                    @if ($post->description)
                        <span class="text-gray-300/80 text-lg">
                            {{ $post->description }}
                        </span>
                    @endif

                    <div class="dark:prose-invert">
                        {{ \Filament\Forms\Components\RichEditor\RichContentRenderer::make($post->content)->customBlocks([\App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks\YoutubeBlock::class]) }}
                    </div>
                </div>
            </div>

            {{-- Info and TOC --}}
            <aside class="order-first lg:order-last lg:w-64 lg:shrink-0">
                <div class="flex flex-col gap-y-6 lg:sticky lg:top-16">
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

                    @if (! empty($post->tags))
                        <div>
                            <h3 class="text-text/50 text-xs font-bold tracking-wider uppercase">Tags</h3>
                            <div class="mt-2 flex flex-wrap gap-2">
                                @foreach ($post->tags as $tag)
                                    <x-filament::badge color="gray">
                                        {{ $tag }}
                                    </x-filament::badge>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div class="hidden lg:block">
                        <h3 class="text-text/50 text-xs font-bold tracking-wider uppercase">On this page</h3>
                        {{--TOC--}}
                    </div>
                </div>
            </aside>
        </div>
    </article>
</x-layout>
