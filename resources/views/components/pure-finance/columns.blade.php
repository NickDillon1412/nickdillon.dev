@props(['columns'])

<div x-data="{ columnsModalOpen: false }" wire:ignore>
    <flux:button icon="view-columns" variant="subtle" x-on:click="columnsModalOpen = true"
        class="!h-8 !w-8 hover:!bg-white hover:!text-slate-500 dark:hover:!bg-slate-800 dark:hover:!text-slate-300"
        x-ref="columns" />

    <div x-cloak x-show="columnsModalOpen" x-on:keydown.window.escape="columnsModalOpen = false"
        x-on:click.away="columnsModalOpen = false"
        class="p-5 bg-white dark:bg-slate-800 rounded-lg z-10 w-[275px] border shadow-md border-slate-200 dark:border-slate-600"
        x-anchor.bottom-end="$refs.columns">
        <h1 class="mb-1 font-semibold text-slate-800 dark:text-slate-200">
            Columns
        </h1>

        @foreach ($columns as $column)
            <label for="column.{{ $column }}" class="flex items-center py-2">
                <input id="column.{{ $column }}" name="column.{{ $column }}" type="checkbox"
                    class="w-4 h-4 text-indigo-600 rounded bg-slate-100 border-slate-300 focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:ring-offset-slate-800 focus:ring-2 dark:bg-slate-700 dark:border-slate-600"
                    wire:model.live='columns' value="{{ $column }}" />

                <span class="ml-2 text-sm">
                    {{ Str::title($column) }}
                </span>
            </label>
        @endforeach
    </div>
</div>
