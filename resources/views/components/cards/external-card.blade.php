@props([
    'href',
    'aria',
    'icon',
    'primaryColor' => null,
    'secondaryColor' => null,
    'name',
    'tag',
    'description',
    'button',
])

<a
    href="{{ $href }}"
    aria-label="{{ $aria }}"
    class="group bg-card border-border text-text flex transform flex-col justify-between rounded-xl border p-6 shadow-md ease-in-out hover:-translate-y-1 hover:shadow-lg hover:transition"
>
    <div class="flex flex-col">
        <div class="flex items-center gap-3">
            <div class="rounded-full p-2" style="background-color: {{ $primaryColor }};">
                <i class="{{ $icon }} text-2xl" style="color: {{ $secondaryColor }};"></i>
            </div>
            <div>
                <h3 class="text-lg font-bold">{{ $name }}</h3>
                <p class="text-sm">{{ $tag }}</p>
            </div>
        </div>

        <p class="mt-4 text-sm">{{ $description }}</p>
    </div>

    <div class="mt-6 flex items-center gap-3">
        <span class="border-border ml-auto inline-flex items-center gap-2 rounded-md border bg-slate-100 px-3 py-1 text-xs dark:bg-slate-900">
            {{ $button }}
        </span>
    </div>
</a>
