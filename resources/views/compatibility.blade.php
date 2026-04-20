<x-layout title="Compatibility">
    @push('head')
        @vite('resources/css/filament/shadpanel/theme.css')
        @filamentStyles
    @endpush

    @push('scripts')
        @filamentScripts
    @endpush

    @livewire('compatibility-table')
</x-layout>
