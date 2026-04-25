@props(['post', 'linkable' => true])

{{--added $linkable prop (default true) that toggles the inner <a> wrappers on the image and title. --}}
{{--Had to do this because Filament's recordUrl wraps the whole row in a link, and nested <a> tags are invalid HTML and intercept the outer click.--}}
<article class="group mx-auto flex h-full w-full max-w-xl min-w-0 flex-col overflow-hidden">
    @if ($linkable)
        <a class="w-full overflow-hidden rounded-lg" href="{{ route('blog.show', $post) }}">
            <img
                src="{{ $post->image ? asset('images/'.$post->image) : asset('images/default-hero-image.jpg') }}"
                alt="{{ $post->title }}"
                class="aspect-video w-full object-cover transition duration-300 ease-in-out group-hover:scale-105"
            >
        </a>
    @else
        <div class="w-full overflow-hidden rounded-lg">
            <img
                src="{{ $post->image ? asset('images/'.$post->image) : asset('images/default-hero-image.jpg') }}"
                alt="{{ $post->title }}"
                class="aspect-video w-full object-cover transition duration-300 ease-in-out group-hover:scale-105"
            >
        </div>
    @endif

    <div class="flex flex-1 flex-col pt-4">
        <div class="mb-2 flex h-6 items-center gap-x-1 overflow-hidden text-xs">
            <time class="whitespace-nowrap text-zinc-700 dark:text-zinc-400">
                {{ $post->pubDate->format('M j, Y') }}
            </time>

            @if ($post->category)
                <span class="text-zinc-600">|</span>
                <x-filament::badge color="info">
                    {{ $post->category }}
                </x-filament::badge>
            @endif

            @if (! empty($post->tags))
                <span class="text-zinc-600">|</span>
                <div class="no-scrollbar flex flex-1 items-center gap-x-1 overflow-x-auto py-0.5">
                    @foreach ($post->tags as $tag)
                        <x-filament::badge color="gray">
                            {{ $tag }}
                        </x-filament::badge>
                    @endforeach
                </div>
            @endif
        </div>

        <h3 class="text-xl leading-tight font-bold text-zinc-900 dark:text-zinc-100">
            @if ($linkable)
                <a href="{{ route('blog.show', $post) }}" class="line-clamp-2 truncate wrap-break-word" title="{{ $post->title }}">
                    {{ $post->title }}
                </a>
            @else
                <span class="line-clamp-2 truncate wrap-break-word" title="{{ $post->title }}">
                    {{ $post->title }}
                </span>
            @endif
        </h3>

        <p class="mt-2 line-clamp-1 text-sm leading-relaxed text-zinc-600 dark:text-zinc-400">{{ $post->description }}</p>
    </div>
</article>
