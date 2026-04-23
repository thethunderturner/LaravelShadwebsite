<x-layout title="Blog Posts" description="Latest news about the shadPS4 emulator">
    @push('head')
        @vite('resources/css/filament/shadpanel/theme.css')
        @filamentStyles
    @endpush

    @push('scripts')
        @filamentScripts
    @endpush

    @livewire('grid-posts-table')
</x-layout>
