<header class="border-border bg-header sticky top-0 z-50 w-full border-b">
    <nav class="mx-auto flex h-16 w-full max-w-465 items-center justify-between px-4 sm:px-6 lg:px-8">
        <div class="hidden flex-row gap-x-3 lg:flex">
            {{-- Simple pages --}}
            @foreach (config('navigation.pages') as $item)
                <a href="{{ $item['href'] }}" class="text-text text-lg/6 font-semibold">
                    {{ $item['name'] }}
                </a>
            @endforeach

            {{-- Popovers --}}
            <x-header.popover label="Online" :items="config('navigation.online')" />
            <x-header.popover label="Blog" :items="config('navigation.blogs')" />
            <x-header.popover label="Gallery" :items="config('navigation.gallery')" />
            <x-header.popover label="About" :items="config('navigation.about')" />
        </div>

        <div class="hidden flex-row items-center gap-x-1.5 lg:flex">
            <div class="flex flex-row gap-x-2">
                @foreach (config('navigation.external') as $item)
                    <a aria-label="{{ $item['name'] }}" href="{{ $item['href'] }}" class="text-text">
                        <i class="fa-brands fa-{{ $item['icon'] }} text-xl"></i>
                    </a>
                @endforeach
            </div>
            <div class="h-6 w-px bg-gray-700 dark:bg-gray-600"></div>
            <x-header.theme-icon />
        </div>

        {{-- Mobile trigger --}}
        <x-header.mobile-sidebar />
    </nav>
</header>
