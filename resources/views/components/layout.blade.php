@props(['title' => null])

<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ? $title.' | '.config('site.title') : config('site.title') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @fluxAppearance
</head>
<body>
    <x-header />
    <div class="max-w-[75%] mx-auto">
        {{ $slot }}
    </div>
    @livewireScripts
    @fluxScripts
</body>
</html>
