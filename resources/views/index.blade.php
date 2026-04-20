<x-layout title="Home">
    {{-- Hero --}}
    <div class="relative flex min-h-[45vh] w-full flex-col items-center justify-center overflow-hidden rounded-2xl sm:min-h-[45vh]">
        <img
            src="{{ asset('game_images/main_background.png') }}"
            alt="Games"
            loading="eager"
            class="absolute inset-0 -z-10 h-full w-full mask-x-from-20% mask-x-to-100% object-cover opacity-40"
        >

        <div class="flex flex-col items-center gap-y-6 px-4 text-center sm:gap-y-12">
            <div class="flex flex-col items-center gap-4 sm:flex-row sm:gap-x-8">
                <img
                    src="{{ asset('logo/shadPS4Logo.png') }}"
                    alt="shadps4_logo"
                    class="size-16 rounded-sm sm:size-24"
                    loading="eager"
                >
                <span class="text-text text-5xl font-bold sm:text-7xl lg:text-8xl">{{ config('site.title') }}</span>
            </div>

            <span class="text-text max-w-2xl text-base font-semibold sm:text-xl">{{ config('site.description') }}</span>
        </div>
    </div>

    {{-- Blog Preview --}}
    <div>
        <h2 class="text-text text-2xl font-bold sm:text-3xl">Latest blog posts</h2>
        <p class="text-lg text-zinc-800 dark:text-zinc-100">
            Find out about the latest updates on shadPS4. Read more <a class="font-bold underline" href="/blog">here</a>.
        </p>
        {{-- TODO: <x-index.blog-preview /> --}}
    </div>

    {{-- shadPSN --}}
    <div>
        <h2 class="text-text text-2xl font-bold sm:text-3xl">shadPSN</h2>
        <p class="text-lg text-zinc-800 dark:text-zinc-100">
            Explore the online world of your favorite games by using shadPSN. The best way to connect with other players. Get started
            <a class="font-bold underline" href="/shadPSN/register">here</a>
        </p>
    </div>

    {{-- Socials --}}
    <div>
        <h2 class="text-text text-2xl font-bold sm:text-3xl">Socials</h2>
        <p class="text-lg text-zinc-800 dark:text-zinc-100">Find out more about all things regarding shadPS4.</p>
        {{-- TODO: <x-index.external-cards-preview /> --}}
    </div>
</x-layout>
