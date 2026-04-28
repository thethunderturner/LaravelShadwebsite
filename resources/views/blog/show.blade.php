@php
    use App\Filament\Forms\Components\RichEditor\RichContentCustomBlocks\YoutubeBlock;
    use App\Support\Markdown;
    use Filament\Forms\Components\RichEditor\RichContentRenderer;

    $heroImage = $post->image ? asset('images/'.$post->image) : null;

    $renderedHtml = RichContentRenderer::make($post->content)
        ->customBlocks([YoutubeBlock::class])
        ->toHtml();

    ['html' => $contentHtml, 'toc' => $toc] = Markdown::extractToc($renderedHtml);
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

                    <div class="dark:prose-invert scroll-mt-24">
                        {!! $contentHtml !!}
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

                    @if (! empty($toc))
                        <nav
                            aria-label="Table of contents"
                            x-data="{
                                activeId: null,
                                init() {
                                    const headings = Array.from(document.querySelectorAll('article h2[id], article h3[id], article h4[id]'));
                                    if (headings.length === 0) return;

                                    const update = () => {
                                        const offset = 100;
                                        let current = headings[0].id;
                                        for (const h of headings) {
                                            if (h.getBoundingClientRect().top <= offset) {
                                                current = h.id;
                                            } else {
                                                break;
                                            }
                                        }
                                        this.activeId = current;
                                    };

                                    update();
                                    window.addEventListener('scroll', update, { passive: true });
                                },
                            }"
                        >
                            <h3 class="text-text/50 text-xs font-bold tracking-wider uppercase">On this page</h3>
                            <ul class="border-border mt-2 flex flex-col gap-y-1.5 border-l">
                                @foreach ($toc as $item)
                                    <li @class([
                                        'pl-3' => $item['level'] === 2,
                                        'pl-6' => $item['level'] === 3,
                                        'pl-9' => $item['level'] === 4,
                                    ])>
                                        <a
                                            href="#{{ $item['id'] }}"
                                            class="block text-sm leading-snug transition"
                                            :class="activeId === '{{ $item['id'] }}' ? 'font-bold text-white' : 'text-text/70 hover:text-text'"
                                        >
                                            {{ $item['text'] }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </nav>
                    @endif
                </div>
            </aside>
        </div>
    </article>
</x-layout>
