@props(['genres'])

<div x-data="{ open: false }">
    <button
        class="p-2 duration-200 ease-in-out bg-white border rounded-md shadow-sm hover:bg-slate-200 dark:bg-slate-900 border-slate-300 dark:hover:bg-slate-800 dark:border-slate-700 dark:text-slate-300"
        x-on:click.prevent="open = !open" x-ref="filter">
        <x-feathericon-filter />
    </button>

    <div x-cloak x-show="open" x-anchor.offset.5.bottom-end="$refs.filter" x-on:click.outside="open = false"
        x-on:keydown.escape.window="open = false"
        class="z-10 bg-white border divide-y rounded-md shadow-sm dark:bg-slate-800 border-slate-300 dark:border-slate-700 dark:text-slate-300 divide-slate-300 dark:divide-slate-700 w-44">
        <h1 class="p-2 text-sm font-medium">
            Filter by genre:
        </h1>

        <div>
            @foreach ($genres as $genre)
                <label for="selected_genre.{{ $genre }}"
                    class="flex items-center px-2 py-1.5 hover:bg-slate-200 dark:hover:bg-slate-800">
                    <input id="selected_genre.{{ $genre }}" type="checkbox"
                        class="w-4 h-4 text-indigo-600 rounded bg-slate-100 border-slate-300 focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:ring-offset-slate-800 focus:ring-2 dark:bg-slate-700 dark:border-slate-600"
                        wire:model.live='selected_genres' value="{{ $genre }}" />

                    <span class="ml-2 text-sm">
                        {{ $genre }}
                    </span>
                </label>
            @endforeach
        </div>
    </div>
</div>
