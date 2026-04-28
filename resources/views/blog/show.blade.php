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

        <div class="grid grid-cols-1 gap-10 lg:grid-cols-[240px_1fr]">
            {{-- Sidebar --}}
            <aside class="flex flex-col gap-y-6 lg:sticky lg:top-24 lg:self-start">
                <a
                    href="/blog"
                    class="text-text/70 hover:text-text text-sm font-semibold transition"
                >
                    ← All posts
                </a>

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
            </aside>

            {{-- Main content --}}
            <div class="min-w-0">
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

                <div class="prose dark:prose-invert mt-8 max-w-none">
                    {{ \Filament\Forms\Components\RichEditor\RichContentRenderer::make($post->content)->customBlocks([\App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks\YoutubeBlock::class]) }}
                </div>
            </div>
        </div>
    </article>
</x-layout>
