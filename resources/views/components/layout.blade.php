@props(['title' => null])

<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ? $title.' | '.config('site.title') : config('site.title') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @fluxAppearance
    @stack('head')
</head>
<body class="bg-root flex min-h-screen flex-col">
    <x-header />
    <main class="mx-auto w-full max-w-[70%] flex-1">
        <div class="py-8 text-text text-3xl font-bold">
            {{$title}}
        </div>
        {{ $slot }}
    </main>
    <x-footer />
    @livewireScripts
    @fluxScripts
    @stack('scripts')
</body>
</html>
