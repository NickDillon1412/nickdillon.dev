@props(['genres'])

<div x-data="{ open: false }">
    <div class="relative inline-block">
        <button
            class="p-2 duration-200 ease-in-out bg-white border rounded-md shadow-sm hover:bg-slate-200 dark:bg-slate-900 border-slate-300 dark:hover:bg-slate-800 dark:border-slate-700 dark:text-slate-300"
            x-on:click.prevent="open = !open" x-ref="filter">
            <x-feathericon-filter />
        </button>

        <span x-cloak x-show="$wire.selected_genres.length > 0"
            class="absolute top-0 right-0 flex items-center justify-center w-[20px] h-[20px] -mt-2 -mr-2 text-xs bg-indigo-500 rounded-full dark:bg-indigo-600 text-slate-200"
            x-text="$wire.selected_genres.length">
        </span>
    </div>

    <div x-cloak x-show="open" x-anchor.offset.5.bottom-end="$refs.filter" x-on:click.outside="open = false"
        x-on:click.outside="open = false" x-on:keydown.escape.window="open = false"
        class="z-10 w-56 bg-white border divide-y rounded-md shadow-md dark:bg-slate-800 border-slate-300 dark:border-slate-700 dark:text-slate-200 divide-slate-300 dark:divide-slate-700 text-slate-800">
        <div class="flex items-center justify-between p-2">
            <p class="px-2 py-1 text-sm font-medium">
                Filter by genre:
            </p>

            <button x-cloak x-show="$wire.selected_genres.length > 0"
                class="px-2 py-1 text-sm duration-200 ease-in-out rounded hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 dark:text-slate-200"
                x-on:click="$wire.set('selected_genres', [])">
                Clear
            </button>
        </div>

        <div class="py-2">
            @foreach ($genres as $genre)
                <label for="selected_genre.{{ $genre }}"
                    class="flex items-center px-4 py-2 hover:bg-slate-200 dark:hover:bg-slate-700">
                    <input id="selected_genre.{{ $genre }}" name="selected_genre.{{ $genre }}"
                        type="checkbox"
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
