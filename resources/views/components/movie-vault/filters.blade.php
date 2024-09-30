@props(['ratings', 'genres'])

<div x-data="{
    showSortBy: true,
    showTypes: true,
    showRatings: true,
    showGenres: true,
    slideOverOpen: false,
    totalFilters() {
        total = $wire.selected_ratings.length + $wire.selected_genres.length;

        if ($wire.sort_direction) total++;

        if ($wire.type) total++;

        return total;
    },
}" class="relative z-50 w-auto h-auto">
    <div class="relative inline-block">
        <button
            class="p-2 duration-200 ease-in-out bg-white border rounded-md shadow-sm hover:bg-slate-200 dark:bg-slate-900 border-slate-300 dark:hover:bg-slate-800 dark:border-slate-700 dark:text-slate-300"
            x-on:click.prevent="slideOverOpen = true">
            <x-feathericon-filter />
        </button>

        <span x-cloak x-show="totalFilters() > 0"
            class="absolute top-0 right-0 flex items-center justify-center w-[19px] h-[19px] -mt-2 -mr-2 text-xs bg-indigo-500 rounded-full text-slate-200"
            x-text="totalFilters()">
        </span>
    </div>

    <template x-teleport="body">
        <div x-show="slideOverOpen" x-on:keydown.window.escape="slideOverOpen = false" class="relative z-[99]">
            <div x-cloak x-show="slideOverOpen" x-transition.opacity.duration.200ms x-on:click="slideOverOpen = false"
                class="fixed inset-0 bg-slate-900 bg-opacity-20"></div>

            <div class="fixed inset-0 overflow-hidden">
                <div class="absolute inset-0 overflow-hidden">
                    <div class="fixed inset-y-0 right-0 flex max-w-full pl-10">
                        <div x-show="slideOverOpen" x-on:click.away="slideOverOpen = false"
                            x-transition:enter="transform transition ease-in-out duration-200"
                            x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
                            x-transition:leave="transform transition ease-in-out duration-200"
                            x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full"
                            class="w-screen max-w-[250px] sm:max-w-[300px]">
                            <div
                                class="flex flex-col h-full py-5 overflow-y-scroll bg-white border-l dark:bg-slate-800 border-slate-200 dark:border-slate-700 dark:text-slate-200 text-slate-800">
                                <div class="px-4 sm:px-5">
                                    <div class="flex items-center justify-between">
                                        <h2 class="font-semibold" id="slide-over-title">
                                            Filters
                                        </h2>

                                        <div class="flex items-center space-x-1">
                                            <button x-cloak x-show="totalFilters() > 1"
                                                class="px-2 text-sm font-medium text-indigo-500 duration-200 ease-in-out rounded hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700"
                                                x-on:click="$dispatch('clear-filters')">
                                                Clear all
                                            </button>

                                            <button x-on:click="slideOverOpen = false" type="button"
                                                class="duration-200 ease-in-out rounded hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-800 dark:text-slate-200">
                                                <x-heroicon-s-x-mark class="w-5 h-5" />
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="relative flex-1 px-4 mt-2 space-y-3 sm:px-5">
                                    <div>
                                        <div class="flex pb-0.5 items-center justify-between text-sm font-medium">
                                            <p>
                                                Sort By
                                            </p>

                                            <flux:button variant="subtle" icon="chevron-down"
                                                class="!h-6 !w-6 hover:!bg-slate-200 dark:hover:!bg-slate-700 !-mr-0.5  hover:text-slate-800 dark:hover:text-slate-200"
                                                x-bind:class="showSortBy ? 'rotate-180' : ''"
                                                x-on:click="showSortBy = !showSortBy" />
                                        </div>

                                        <div x-collapse x-show="showSortBy"
                                            class="pt-2 space-y-2 border-t border-slate-300 dark:border-slate-700">
                                            <label for="sort_direction_asc" class="flex items-center">
                                                <input id="sort_direction_asc" type="radio" value="asc"
                                                    name="sort_direction"
                                                    class="w-4 h-4 text-indigo-600 bg-gray-100 border-gray-300 focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                                    wire:model.live='sort_direction' />

                                                <span class="ml-2 text-sm">
                                                    A-Z
                                                </span>
                                            </label>

                                            <label for="sort_direction_desc" class="flex items-center">
                                                <input id="sort_direction_desc" type="radio" value="desc"
                                                    name="sort_direction"
                                                    class="w-4 h-4 text-indigo-600 bg-gray-100 border-gray-300 focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                                    wire:model.live='sort_direction' />

                                                <span class="ml-2 text-sm">
                                                    Z-A
                                                </span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <div class="pb-0.5 text-sm font-medium flex items-center justify-between">
                                            <p>
                                                Types
                                            </p>

                                            <div class="flex items-center justify-between">
                                                <button x-cloak x-show="$wire.type"
                                                    class="px-2 text-sm font-medium duration-200 ease-in-out rounded hover:!bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700"
                                                    x-on:click="$wire.set('type', '')">
                                                    Clear
                                                </button>

                                                <flux:button variant="subtle" icon="chevron-down"
                                                    class="!h-6 !w-6 hover:!bg-slate-200 dark:hover:!bg-slate-700 !-mr-0.5  hover:text-slate-800 dark:hover:text-slate-200"
                                                    x-bind:class="showTypes ? 'rotate-180' : ''"
                                                    x-on:click="showTypes = !showTypes" />
                                            </div>
                                        </div>

                                        <div x-collapse x-show="showTypes"
                                            class="pt-2 space-y-2 border-t border-slate-300 dark:border-slate-700">
                                            <label for="movie" class="flex items-center">
                                                <input id="movie" type="radio" value="movie" name="type"
                                                    class="w-4 h-4 text-indigo-600 bg-gray-100 border-gray-300 focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                                    wire:model.live='type' />

                                                <span class="ml-2 text-sm">
                                                    Movie
                                                </span>
                                            </label>

                                            <label for="tv" class="flex items-center">
                                                <input id="tv" type="radio" value="tv" name="type"
                                                    class="w-4 h-4 text-indigo-600 bg-gray-100 border-gray-300 focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                                    wire:model.live='type' />

                                                <span class="ml-2 text-sm">
                                                    TV Show
                                                </span>
                                            </label>
                                        </div>
                                    </div>

                                    <div>
                                        <div class="pb-0.5 text-sm font-medium flex items-center justify-between">
                                            <p>
                                                Ratings
                                            </p>

                                            <div class="flex items-center justify-between">
                                                <button x-cloak x-show="$wire.selected_ratings.length > 0"
                                                    class="px-2 text-sm font-medium duration-200 ease-in-out rounded hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700"
                                                    x-on:click="$wire.set('selected_ratings', [])">
                                                    Clear
                                                </button>

                                                <flux:button variant="subtle" icon="chevron-down"
                                                    class="!h-6 !w-6 hover:!bg-slate-200 dark:hover:!bg-slate-700 !-mr-0.5  hover:text-slate-800 dark:hover:text-slate-200"
                                                    x-bind:class="showRatings ? 'rotate-180' : ''"
                                                    x-on:click="showRatings = !showRatings" />
                                            </div>
                                        </div>

                                        <div x-collapse x-show="showRatings"
                                            class="pt-1 border-t border-slate-300 dark:border-slate-700">
                                            @foreach ($ratings as $rating)
                                                <label for="selected_rating.{{ $rating }}"
                                                    class="flex items-center py-1.5">
                                                    <input id="selected_rating.{{ $rating }}"
                                                        name="selected_rating.{{ $rating }}" type="checkbox"
                                                        class="w-4 h-4 text-indigo-600 rounded bg-slate-100 border-slate-300 focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:ring-offset-slate-800 focus:ring-2 dark:bg-slate-700 dark:border-slate-600"
                                                        wire:model.live='selected_ratings'
                                                        value="{{ $rating }}" />

                                                    <span class="ml-2 text-sm">
                                                        {{ $rating }}
                                                    </span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div>
                                        <div class="pb-0.5 text-sm font-medium flex items-center justify-between">
                                            <p>
                                                Genres
                                            </p>

                                            <div class="flex items-center justify-between">
                                                <button x-cloak x-show="$wire.selected_genres.length > 0"
                                                    class="px-2 text-sm font-medium duration-200 ease-in-out rounded hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700"
                                                    x-on:click="$wire.set('selected_genres', [])">
                                                    Clear
                                                </button>

                                                <flux:button variant="subtle" icon="chevron-down"
                                                    class="!h-6 !w-6 hover:!bg-slate-200 dark:hover:!bg-slate-700 !-mr-0.5  hover:text-slate-800 dark:hover:text-slate-200"
                                                    x-bind:class="showGenres ? 'rotate-180' : ''"
                                                    x-on:click="showGenres = !showGenres" />
                                            </div>
                                        </div>

                                        <div x-collapse x-show="showGenres"
                                            class="pt-1 border-t border-slate-300 dark:border-slate-700">
                                            @foreach ($genres as $genre)
                                                <label for="selected_genre.{{ $genre }}"
                                                    class="flex items-center py-1.5">
                                                    <input id="selected_genre.{{ $genre }}"
                                                        name="selected_genre.{{ $genre }}" type="checkbox"
                                                        class="w-4 h-4 text-indigo-600 rounded bg-slate-100 border-slate-300 focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:ring-offset-slate-800 focus:ring-2 dark:bg-slate-700 dark:border-slate-600"
                                                        wire:model.live='selected_genres'
                                                        value="{{ $genre }}" />

                                                    <span class="ml-2 text-sm">
                                                        {{ $genre }}
                                                    </span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </template>
</div>
