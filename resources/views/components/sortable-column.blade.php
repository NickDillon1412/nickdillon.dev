@props(['sort_col', 'sort_asc', 'column'])

<th scope="col" class="py-3 text-xs first:pl-5 text-slate-600 dark:text-slate-200">
    <button wire:click="sortBy('{{ $column }}')"
        class="flex items-center gap-1 font-semibold text-left uppercase group">
        {{ Str::title($column) }}

        @if ($sort_col === $column)
            <div>
                @if ($sort_asc)
                    <flux:icon.chevron-up class="!h-4 !w-4" />
                @else
                    <flux:icon.chevron-down class="!h-4 !w-4" />
                @endif
            </div>
        @else
            <div class="duration-150 ease-in-out opacity-0 group-hover:opacity-100">
                <flux:icon.chevrons-up-down class="!h-4 !w-4" />
            </div>
        @endif
    </button>
</th>
