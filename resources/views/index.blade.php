<x-layout title="Home">
    @push('head')
        @vite('resources/css/filament/shadpanel/theme.css')
        @filamentStyles
    @endpush

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

    <div class="flex flex-col gap-y-8">
        {{-- Blog Preview --}}
        <div>
            <h2 class="text-text text-2xl font-bold sm:text-3xl">Latest blog posts</h2>
            <p class="text-lg text-zinc-800 dark:text-zinc-100">
                Find out about the latest updates on shadPS4. Read more <a class="font-bold underline" href="/blog">here</a>.
            </p>
            <div class="mt-6 grid gap-6 md:grid-cols-3">
                @foreach ($latestPosts as $i => $post)
                    <x-cards.post-card :post="$post" />
                @endforeach
            </div>
        </div>

        {{-- shadPSN --}}
        <div>
            <h2 class="text-text text-2xl font-bold sm:text-3xl">shadPSN</h2>
            <p class="text-lg text-zinc-800 dark:text-zinc-100">
                Explore the online world of your favorite games by using shadPSN. The best way to connect with other players. Get started
                <a class="font-bold underline" href="/shadPSN/register">here</a>
            </p>
            <div class="pt-2 text-xl font-bold sm:text-2xl">Trending Right Now:</div>
            <div class="mt-6 grid gap-6 md:grid-cols-3">
                <x-cards.shadpsn-card name="Bloodborne" cusa="CUSA00900" players="142" />
                <x-cards.shadpsn-card name="Dark Souls Remastered" cusa="CUSA09694" players="87" />
                <x-cards.shadpsn-card name="Devil May Cry 4 SE" cusa="CUSA00912" players="53" />
            </div>
        </div>

        {{-- Socials --}}
        <div>
            <h2 class="text-text text-2xl font-bold sm:text-3xl">Socials</h2>
            <p class="text-lg text-zinc-800 dark:text-zinc-100">Find out more about all things regarding shadPS4.</p>

            <div class="grid grid-cols-1 gap-6 pt-4 md:grid-cols-2 lg:gap-8">
                <x-cards.external-card
                    href="https://github.com/shadps4-emu/shadPS4"
                    aria="GitHub repository"
                    icon="fa-brands fa-github"
                    primary-color="oklch(0.97 0.01 0)"
                    secondary-color="oklch(0.1 0.02 248.35)"
                    name="GitHub"
                    tag="Contributing Code"
                    description="Built by a community of passionate developers and problem-solvers, who contribute in their free time. Pull requests are always welcome! Have a look at the code and file an issue, or open a pull request. Small commits, big dreams."
                    button="Explore repo"
                />

                <x-cards.external-card
                    href="https://discord.gg/bFJxfftGW6"
                    aria="Discord server"
                    icon="fa-brands fa-discord"
                    primary-color="#5864F2"
                    secondary-color="oklch(0.97 0.01 0)"
                    name="Discord"
                    tag="Support and general discussions"
                    description="If you need help, have questions, or just want to chat, join our Discord server!"
                    button="Join server"
                />

                <x-cards.external-card
                    href="https://www.youtube.com/@gmoralistube"
                    aria="Youtube channel"
                    icon="fa-brands fa-youtube"
                    primary-color="#FF0033"
                    secondary-color="white"
                    name="YouTube"
                    tag="For demos or previews of upcoming releases"
                    description="Watch the emulator progress on our YouTube channel, where we post demos, previews of games that show emulation progress, and more."
                    button="Watch"
                />

                <x-cards.external-card
                    href="https://ko-fi.com/shadps4"
                    aria="Support on Ko-fi"
                    icon="fa-solid fa-mug-saucer"
                    primary-color="oklch(0.97 0.01 0)"
                    secondary-color="oklch(0.68 0.21 38.31)"
                    name="Ko-fi"
                    tag="Optional donations"
                    description="If shadPS4 fixes your nostalgia, a coffee helps developing efforts, such as purchasing necessary hardware, games, and project maintenance costs."
                    button="Donate"
                />
            </div>
        </div>
    </div>
</x-layout>
