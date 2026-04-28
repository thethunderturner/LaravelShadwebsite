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
    <main class="mx-auto w-full max-w-465 flex-1 px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col gap-y-0.5 py-8">
            @if($title)
                <span class="text-text text-3xl font-bold">
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
