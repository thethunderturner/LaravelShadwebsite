@props(['post'])

<article class="group mx-auto flex h-full w-full max-w-xl min-w-0 flex-col overflow-hidden">
    <a class="w-full overflow-hidden rounded-lg" href="{{ route('blog.show', $post) }}">
        <img
            src="{{ $post->image ? asset('images/'.$post->image) : asset('images/default-hero-image.jpg') }}"
            alt="{{ $post->title }}"
            class="aspect-video w-full object-cover transition duration-300 ease-in-out group-hover:scale-105"
        >
    </a>

    <div class="flex flex-1 flex-col pt-4">
        <div class="mb-2 flex h-6 items-center gap-x-1 overflow-hidden text-xs">
            <time class="whitespace-nowrap text-zinc-700 dark:text-zinc-400">
                {{ $post->pubDate->format('M j, Y') }}
            </time>

            @if ($post->category)
                <span class="text-zinc-600">|</span>
                <span class="font-bold whitespace-nowrap text-blue-600 dark:text-blue-500">{{ $post->category }}</span>
            @endif

            @if (! empty($post->tags))
                <span class="text-zinc-600">|</span>
                <div class="no-scrollbar flex flex-1 items-center gap-x-1 overflow-x-auto py-0.5">
                    @foreach ($post->tags as $tag)
                        <span class="border-border bg-card text-text shrink-0 rounded border px-1.5 py-0.5 font-medium whitespace-nowrap">
                            {{ $tag }}
                        </span>
                    @endforeach
                </div>
            @endif
        </div>

        <h3 class="text-xl leading-tight font-bold text-zinc-900 dark:text-zinc-100">
            <a href="{{ route('blog.show', $post) }}" class="line-clamp-2 truncate wrap-break-word" title="{{ $post->title }}">
                {{ $post->title }}
            </a>
        </h3>

        <p class="mt-2 line-clamp-1 text-sm leading-relaxed text-zinc-600 dark:text-zinc-400">{{ $post->description }}</p>
    </div>
</article>
