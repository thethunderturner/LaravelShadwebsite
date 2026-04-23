<div x-data="{ open: false }" class="lg:hidden">
    <button
        type="button"
        aria-label="Open menu"
        @click="open = true"
        class="text-text flex size-10 items-center justify-center rounded-md hover:bg-white/5"
    >
        <i class="fa-solid fa-bars text-2xl"></i>
    </button>

    {{-- Backdrop --}}
    <div
        x-cloak
        x-show="open"
        @click="open = false"
        x-transition:enter="transition-opacity duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 bg-black/60"
    ></div>

    {{-- Panel --}}
    <aside
        x-cloak
        x-show="open"
        x-trap.noscroll="open"
        @keydown.escape.window="open = false"
        x-transition:enter="transition-transform duration-200"
        x-transition:enter-start="-translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transition-transform duration-200"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="-translate-x-full"
        class="bg-header border-border fixed inset-y-0 left-0 z-50 flex w-80 max-w-[85%] flex-col border-r shadow-xl"
    >
        <div class="border-border flex items-center justify-between border-b p-4">
            <span class="text-text text-lg font-semibold">Menu</span>
            <button
                type="button"
                @click="open = false"
                aria-label="Close menu"
                class="text-text flex size-9 items-center justify-center rounded-md hover:bg-white/5"
            >
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>

        <nav class="flex flex-1 flex-col gap-y-1 overflow-y-auto p-4">
            @foreach (config('navigation.pages') as $item)
                <a href="{{ $item['href'] }}" class="text-text rounded-md px-3 py-2 text-base font-semibold hover:bg-white/5">
                    {{ $item['name'] }}
                </a>
            @endforeach

            @foreach (['online' => 'Online', 'blogs' => 'Blog', 'gallery' => 'Gallery', 'about' => 'About'] as $key => $label)
                <details class="text-text">
                    <summary class="hover:bg-white/5 flex cursor-pointer items-center justify-between rounded-md px-3 py-2 text-base font-semibold">
                        <span>{{ $label }}</span>
                        <i class="fa-solid fa-chevron-down text-xs transition-transform group-open:rotate-180"></i>
                    </summary>
                    <div class="mt-1 flex flex-col border-l border-white/10 pl-3">
                        @foreach (config('navigation.'.$key) as $child)
                            <a href="{{ $child['href'] }}" class="text-text/80 hover:bg-white/5 rounded-md px-3 py-2 text-sm">
                                {{ $child['name'] }}
                            </a>
                        @endforeach
                    </div>
                </details>
            @endforeach
        </nav>

        <div class="border-border flex items-center justify-between gap-x-2 border-t p-4">
            <div class="flex flex-wrap gap-x-3 gap-y-2">
                @foreach (config('navigation.external') as $item)
                    <a aria-label="{{ $item['name'] }}" href="{{ $item['href'] }}" class="text-text hover:text-text/80">
                        <i class="fa-brands fa-{{ $item['icon'] }} text-xl"></i>
                    </a>
                @endforeach
            </div>
            <x-header.theme-icon />
        </div>
    </aside>
</div>
