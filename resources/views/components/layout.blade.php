@props(['title' => null, 'description' => null])

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ? $title.' | '.config('site.title') : config('site.title') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/filament/shadpanel/theme.css'])
    @filamentStyles
    @fluxAppearance
</head>
<body class="bg-root flex min-h-screen flex-col mx-auto">
    <x-header />
    <main class="w-full max-w-[70%] flex-1 mx-auto">
        <div class="flex flex-col gap-y-2 pt-4">
            @if($title)
                <span class="py-8 text-text text-3xl font-bold">
                    {{$title}}
                </span>
            @endif
            @if($description)
                <span class="text-base font-normal">
                    {{$description}}
                </span>
            @endif
        </div>
        {{ $slot }}
    </main>
    <x-footer />
    @filamentScripts
    @livewireScripts
    @fluxScripts
</body>
</html>
