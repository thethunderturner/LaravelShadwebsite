@php
    use App\Support\Markdown;
    $heroImage = $post->image ? asset('images/'.$post->image) : null;
    ['html' => $contentHtml, 'toc' => $toc] = Markdown::renderWithToc($post->content);
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
                        <span class="mt-2 inline-block rounded-md bg-blue-600/10 px-2.5 py-1 text-sm font-semibold text-blue-400">
                            {{ $post->category }}
                        </span>
                    </div>
                @endif

                @if (! empty($post->tags))
                    <div>
                        <h3 class="text-text/50 text-xs font-bold tracking-wider uppercase">Tags</h3>
                        <div class="mt-2 flex flex-wrap gap-2">
                            @foreach ($post->tags as $tag)
                                <span class="border-border bg-card text-text rounded-md border px-2 py-1 text-xs font-medium">
                                    {{ $tag }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if (count($toc) >= 2)
                    <nav>
                        <h3 class="text-text/50 text-xs font-bold tracking-wider uppercase">Contents</h3>
                        <ol class="mt-2 flex flex-col gap-1 text-sm">
                            @foreach ($toc as $item)
                                <li style="padding-left: {{ ($item['level'] - 2) * 12 }}px">
                                    <a
                                        href="#{{ $item['id'] }}"
                                        class="text-text/70 hover:text-text block truncate transition"
                                        title="{{ $item['text'] }}"
                                    >
                                        {{ $item['text'] }}
                                    </a>
                                </li>
                            @endforeach
                        </ol>
                    </nav>
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

                <div class="text-text/90 mt-8
                    [&_p]:mt-4 [&_p]:leading-relaxed
                    [&_h1]:mt-8 [&_h1]:scroll-mt-24 [&_h1]:text-3xl [&_h1]:font-bold
                    [&_h2]:mt-6 [&_h2]:scroll-mt-24 [&_h2]:text-2xl [&_h2]:font-bold
                    [&_h3]:mt-5 [&_h3]:scroll-mt-24 [&_h3]:text-xl [&_h3]:font-bold
                    [&_h4]:mt-4 [&_h4]:scroll-mt-24 [&_h4]:text-lg [&_h4]:font-bold
                    [&_ul]:mt-4 [&_ul]:list-disc [&_ul]:pl-6
                    [&_ol]:mt-4 [&_ol]:list-decimal [&_ol]:pl-6
                    [&_li]:mt-1
                    [&_a]:text-blue-400 [&_a]:underline
                    [&_code]:bg-card [&_code]:rounded [&_code]:px-1.5 [&_code]:py-0.5 [&_code]:text-sm
                    [&_pre]:mt-4 [&_pre]:overflow-x-auto [&_pre]:rounded-lg [&_pre]:bg-card [&_pre]:p-4
                    [&_blockquote]:border-border [&_blockquote]:mt-4 [&_blockquote]:border-l-4 [&_blockquote]:pl-4 [&_blockquote]:italic
                    [&_img]:mt-4 [&_img]:rounded-lg">
                    {!! $contentHtml !!}
                </div>
            </div>
        </div>
    </article>
</x-layout>
