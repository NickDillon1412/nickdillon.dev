{{-- blade-formatter-disable --}}

@props([
    'iconTrailing' => null,
    'variant' => 'outline',
    'iconVariant' => null,
    'iconLeading' => null,
    'type' => 'button',
    'loading' => null,
    'size' => 'base',
    'square' => null,
    'inset' => null,
    'icon' => null,
    'kbd' => null,
])

@php
$iconLeading = $icon ??= $iconLeading;

// Button should be a square if it has no text contents...
$square ??= empty((string) $slot);

// Size-up icons in square/icon-only buttons... (xs buttons just get micro size/style...)
$iconVariant ??= ($size === 'xs')
    ? ($square ? 'micro' : 'micro')
    : ($square ? 'mini' : 'micro');

$loading ??= $loading ?? ($type === 'submit' || $attributes->whereStartsWith('wire:click')->isNotEmpty());

if ($loading && $type !== 'submit') {
    $attributes = $attributes->merge(['wire:loading.attr' => 'data-flux-loading']);
}

$classes = Flux::classes()
    ->add('relative inline-flex items-center font-medium justify-center gap-2 whitespace-nowrap')
    ->add('disabled:opacity-75 dark:disabled:opacity-75 disabled:cursor-default disabled:pointer-events-none')
    ->add(match ($size) { // Size...
        'base' => 'h-9 text-sm rounded-md' . ' ' . ($square ? 'w-8' : 'px-3'),
        'sm' => 'h-8 text-sm rounded-md' . ' ' . ($square ? 'w-8' : 'px-3'),
        'xs' => 'h-6 text-xs rounded-md' . ' ' . ($square ? 'w-6' : 'px-2'),
    })
    ->add($inset ? match ($size) { // Inset...
        'base' => $square
            ? Flux::applyInset($inset, top: '-mt-2.5', right: '-mr-2.5', bottom: '-mb-2.5', left: '-ml-2.5')
            : Flux::applyInset($inset, top: '-mt-2.5', right: '-mr-4', bottom: '-mb-3', left: '-ml-4'),
        'sm' => $square
            ? Flux::applyInset($inset, top: '-mt-1.5', right: '-mr-1.5', bottom: '-mb-1.5', left: '-ml-1.5')
            : Flux::applyInset($inset, top: '-mt-1.5', right: '-mr-3', bottom: '-mb-1.5', left: '-ml-3'),
        'xs' => $square
            ? Flux::applyInset($inset, top: '-mt-1', right: '-mr-1', bottom: '-mb-1', left: '-ml-1')
            : Flux::applyInset($inset, top: '-mt-1', right: '-mr-2', bottom: '-mb-1', left: '-ml-2'),
    } : '')
    ->add(match ($variant) { // Background color...
        'primary' => 'bg-slate-800 hover:bg-slate-700 dark:bg-white dark:hover:bg-slate-200 duration-200 ease-in-out',
        'indigo' => 'bg-indigo-500 hover:bg-indigo-600 duration-200 ease-in-out',
        'pink' => 'bg-pink-500 hover:bg-pink-600 duration-200 ease-in-out',
        'filled' => 'bg-slate-200 hover:bg-slate-300 dark:bg-white dark:hover:bg-slate-200 duration-200 ease-in-out',
        'outline' => 'bg-white hover:bg-slate-50 dark:bg-slate-800 dark:hover:bg-slate-700 border border-slate-200 dark:border-slate-600 duration-200 ease-in-out',
        'danger' => 'bg-red-500 hover:bg-red-600 dark:bg-red-600 dark:hover:bg-red-500 duration-200 ease-in-out',
        'ghost' => 'bg-transparent dark:hover:bg-slate-700 hover:bg-slate-200 duration-200 ease-in-out',
        'subtle' => 'bg-transparent hover:bg-slate-800/5 dark:hover:bg-white/15 duration-200 ease-in-out',
    })
    ->add(match ($variant) { // Text color...
        'primary' => 'text-slate-50 dark:text-slate-800 font-semibold',
        'indigo' => 'text-slate-50 font-semibold',
        'pink' => 'text-slate-50 font-semibold',
        'filled' => 'text-slate-800 font-semibold',
        'outline' => 'text-slate-800 dark:text-white',
        'danger' => 'text-white',
        'ghost' => 'text-slate-800 dark:text-white',
        'subtle' => 'text-slate-400 hover:text-slate-800 dark:text-slate-400 dark:hover:text-white',
    })
    ->add(match ($variant) { // Shadows...
        'primary' => 'shadow-[inset_0px_1px_theme(colors.slate.900),inset_0px_2px_theme(colors.white/.15)] dark:shadow-none',
        'indigo' => 'shadow-[inset_0px_1px_theme(colors.indigo.600),inset_0px_2px_theme(colors.white/.15)] dark:shadow-none',
        'danger' => 'shadow-[inset_0px_1px_theme(colors.red.500),inset_0px_2px_theme(colors.white/.15)] dark:shadow-none',
        'outline' => match ($size) {
            'base' => 'shadow-sm',
            'sm' => 'shadow-sm',
            'xs' => 'shadow-none',
        },
        default => '',
    })
    ->add(match ($variant) { // Grouped border treatments...
        'outline' => 'group-[]/button:-ml-[1px] group-[]/button:first:ml-0',
        'ghost' => '',
        'subtle' => '',
        default => 'group-[]/button:border-r group-[]/button:last:border-r-0 group-[]/button:border-black group-[]/button:dark:border-slate-900/25',
    })
    ->add($loading ? [ // Loading states...
        '*:transition-opacity',
        $type === 'submit' ? '[&[disabled]>:not([data-flux-loading-indicator])]:opacity-0' : '[&[data-flux-loading]>:not([data-flux-loading-indicator])]:opacity-0',
        $type === 'submit' ? '[&[disabled]>[data-flux-loading-indicator]]:opacity-100' : '[&[data-flux-loading]>[data-flux-loading-indicator]]:opacity-100',
        $type === 'submit' ? '[&[disabled]]:pointer-events-none' : '[&[data-flux-loading]]:pointer-events-none',
    ] : [])
    ;
@endphp

<flux:with-tooltip :$attributes>
    <flux:button-or-link :$type :attributes="$attributes->class($classes)" data-flux-button>
        <?php if (is_string($iconLeading)): ?>
            <flux:icon :icon="$iconLeading" :variant="$iconVariant" />
        <?php elseif ($iconLeading): ?>
            {{ $iconLeading }}
        <?php endif; ?>

        <?php if (! $loading): ?>
            {{ $slot }}
        <?php else: ?>
            <span>{{ $slot }}</span>

            <div class="absolute inset-0 flex items-center justify-center opacity-0" data-flux-loading-indicator>
                <flux:icon icon="loading" :variant="$iconVariant" />
            </div>
        <?php endif; ?>

        <?php if ($kbd): ?>
            <div class="text-xs text-slate-500 dark:text-slate-400">{{ $kbd }}</div>
        <?php endif; ?>

        <?php if (is_string($iconTrailing)): ?>
            <flux:icon :icon="$iconTrailing" :variant="$iconVariant" :class="$square ? '' : '-ml-1'" />
        <?php elseif ($iconTrailing): ?>
            {{ $iconTrailing }}
        <?php endif; ?>
    </flux:button-or-link>
</flux:with-tooltip>
