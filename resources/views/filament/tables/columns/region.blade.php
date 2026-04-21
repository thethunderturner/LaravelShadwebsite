@php
    $region = $getRecord()->region;
    $flagCode = match ($region) {
        'USA' => 'us',
        'Europe' => 'eu',
        'Japan' => 'jp',
        'Asia' => 'cn',
        'World' => 'wr',
        default => 'xx',
    };
@endphp

<img
    src="{{ asset("images/region/{$flagCode}.svg") }}"
    alt="{{ $region }} flag"
    class="size-8 rounded-sm"
>
