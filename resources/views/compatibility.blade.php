<x-layout title="Compatibility" description="Find out if your favorite games are compatible with shadPS4 emulator">
    <div>
        <div class="flex w-full flex-col gap-6 lg:flex-row lg:justify-evenly">
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
