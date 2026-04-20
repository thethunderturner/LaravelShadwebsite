<x-layout title="Compatibility">
    @push('head')
        @vite('resources/css/filament/shadpanel/theme.css')
        @filamentStyles
    @endpush

    @push('scripts')
        @filamentScripts
    @endpush

    <div class="flex w-full flex-col gap-6 lg:flex-row lg:justify-evenly">
        <x-compatibility.stats-card
            name="Windows"
            icon="images/os/Windows.png"
            :stats="$stats['Windows']"
        />
        <x-compatibility.stats-card
            name="Linux"
            icon="images/os/Linux.png"
            :stats="$stats['Linux']"
        />
        <x-compatibility.stats-card
            name="macOS"
            icon="images/os/MacOS.png"
            :stats="$stats['MacOS']"
        />
    </div>

    <div class="mt-6">
        @livewire('compatibility-table')
    </div>
</x-layout>
