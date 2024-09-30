@props(['icon' => null])

<flux:button
    class="!duration-200 !bg-indigo-500 w-full sm:w-auto hover:!bg-indigo-600 !text-slate-50 !font-semibold !border-none !rounded-md"
    {{ $attributes->whereStartsWith('wire:click') }}>
    @if ($icon)
        {{ $icon }}
    @endif
    {{ $slot }}
</flux:button>
