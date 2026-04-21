@php
    $os = $getRecord()->os;
    $icons = [
        'Windows' => 'images/os/Windows.png',
        'Linux' => 'images/os/Linux.png',
        'MacOS' => 'images/os/MacOS.png',
    ];
@endphp

@if (isset($icons[$os]))
    <img src="{{ asset($icons[$os]) }}" alt="{{ $os }} logo" class="size-8">
@endif
