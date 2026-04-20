@props(['label', 'items' => []])

<flux:dropdown position="bottom" align="start">
    <button
        type="button"
        class="group flex cursor-pointer items-center gap-x-1 text-lg/6 font-semibold text-white outline-none"
    >
        <span>{{ $label }}</span>
        <flux:icon.chevron-down
            variant="mini"
            class="size-5 text-white/80 transition-transform duration-200 group-aria-expanded:rotate-180"
            aria-hidden="true"
        />
    </button>

    <flux:navmenu class="min-w-48">
        @foreach ($items as $item)
            <flux:navmenu.item :href="$item['href']">{{ $item['name'] }}</flux:navmenu.item>
        @endforeach
    </flux:navmenu>
</flux:dropdown>
