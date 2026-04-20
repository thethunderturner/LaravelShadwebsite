@props(['title' => null])

<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ? $title.' | '.config('site.title') : config('site.title') }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @fluxAppearance
</head>
<body class="bg-root">
    <x-header />
    <div class="max-w-[70%] mx-auto">
        <div class="py-8 text-text text-3xl font-bold">
            {{$title}}
        </div>
        {{ $slot }}
    </div>
    <x-footer />
    @livewireScripts
    @fluxScripts
</body>
</html>
