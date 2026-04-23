<flux:button
    variant="subtle"
    square
    x-data
    x-on:click="$flux.dark = ! $flux.dark"
    aria-label="Toggle dark mode"
>
    <flux:icon.sun x-cloak x-show="$flux.dark" class="size-5 text-text" />
    <flux:icon.moon x-cloak x-show="! $flux.dark" class="size-5 text-text" />
</flux:button>
