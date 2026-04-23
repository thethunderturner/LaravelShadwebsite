<x-layout title="Compatibility" description="Find out if your favorite games are compatible with shadPS4 emulator">
    @push('head')
        @vite('resources/css/filament/shadpanel/theme.css')
        @filamentStyles
        <style>
            .os-stats-row {
                display: grid;
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }
            @media (min-width: 1024px) {
                .os-stats-row {
                    grid-template-columns: repeat(3, minmax(0, 1fr));
                }
            }
        </style>
    @endpush

    @push('scripts')
        @filamentScripts
    @endpush

    <div>
        <div class="os-stats-row">
            <x-cards.stats-card
                name="Windows"
                icon="images/os/Windows.png"
                :stats="$stats['Windows']"
            />
            <x-cards.stats-card
                name="Linux"
                icon="images/os/Linux.png"
                :stats="$stats['Linux']"
            />
            <x-cards.stats-card
                name="macOS"
                icon="images/os/MacOS.png"
                :stats="$stats['MacOS']"
            />
        </div>
        <div class="mt-6">
            @livewire('compatibility-table')
        </div>
    </div>
</x-layout>
