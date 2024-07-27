<div class="w-full p-4 mx-auto overflow-y-hidden sm:py-8 sm:px-6 lg:px-8 max-w-7xl">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-slate-800 md:text-3xl dark:text-slate-100">
            My Vault
        </h1>

        <a href="{{ route('movie-vault.explore') }}" wire:navigate
            class="flex items-center px-3 py-2 text-sm font-semibold duration-200 ease-in-out bg-indigo-500 rounded-md hover:bg-indigo-600 text-slate-50">
            <x-heroicon-s-plus-small class="w-5 h-5 mr-0.5 -ml-1" />

            Add Movies
        </a>
    </div>

    <div class="relative mt-4">
        <x-text-input id="search" wire:model.live.debounce.300ms='search'
            class="w-full bg-white form-input pl-9 dark:bg-slate-800 placeholder:text-slate-400" type="search"
            placeholder="Search..." />

        <button class="absolute inset-0 right-auto group" type="submit" aria-label="Search">
            <svg class="ml-3 mr-2 fill-current text-slate-400 shrink-0 dark:text-slate-500 group-hover:text-slate-500 dark:group-hover:text-slate-400"
                width="16" height="16" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M7 14c-3.86 0-7-3.14-7-7s3.14-7 7-7 7 3.14 7 7-3.14 7-7 7zM7 2C4.243 2 2 4.243 2 7s2.243 5 5 5 5-2.243 5-5-2.243-5-5-5z" />
                <path
                    d="M15.707 14.293L13.314 11.9a8.019 8.019 0 01-1.414 1.414l2.393 2.393a.997.997 0 001.414 0 .999.999 0 000-1.414z" />
            </svg>
        </button>
    </div>

    <div class="grid grid-cols-1 gap-4 pt-4 sm:grid-cols-2 lg:grid-cols-3">
        @forelse ($vault_records as $media)
            <x-mary-card shadow
                class="duration-200 ease-in-out border text-slate-800 dark:bg-slate-800 border-slate-200 dark:border-slate-700 bg-slate-50 dark:text-slate-50">
                <div class="-mx-1 -my-3">
                    <h1 class="text-xl font-bold truncate whitespace-nowrap">
                        {{ $media['original_title'] ?? $media['original_name'] }}
                    </h1>

                    <h3>
                        Release Date:
                        {{ Carbon\Carbon::parse($media['release_date'] ?? $media['first_air_date'])->format('M d, Y') }}
                    </h3>

                    <div class="flex items-center justify-between w-full text-sm">
                        <a class="font-medium text-indigo-500 duration-200 ease-in-out hover:text-indigo-600 dark:hover:text-indigo-400"
                            href="{{ route('movie-vault.explore') }}" wire:navigate>
                            View all details &rarr;
                        </a>

                        <div class="flex items-center -mr-1 space-x-1">
                            <button>
                                <x-heroicon-s-plus-small
                                    class="w-6 h-6 mb-1 duration-200 ease-in-out hover:text-slate-600 dark:hover:text-slate-400" />
                            </button>

                            <div x-data="{ modalOpen: false }" @keydown.escape.window="modalOpen = false"
                                class="relative z-50 w-auto h-auto">
                                <button @click="modalOpen=true">
                                    <x-heroicon-o-trash
                                        class="w-6 h-6 text-red-600 duration-100 ease-in-out hover:text-red-700" />
                                </button>

                                <template x-teleport="body">
                                    <div x-show="modalOpen"
                                        class="fixed top-0 left-0 z-[99] flex items-center justify-center w-screen h-screen text-slate-800 dark:text-slate-50"
                                        x-cloak>
                                        <div x-show="modalOpen" x-transition:enter="ease-out duration-200"
                                            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                            x-transition:leave="ease-in duration-200"
                                            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                                            @click="modalOpen=false"
                                            class="absolute inset-0 w-full h-full bg-black bg-opacity-40 dark:bg-opacity-60">
                                        </div>

                                        <div x-show="modalOpen" x-trap.inert.noscroll="modalOpen"
                                            x-transition:enter="ease-out duration-200"
                                            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                                            x-transition:leave="ease-in duration-200"
                                            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                                            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                            class="relative w-10/12 py-6 bg-white border rounded-lg dark:bg-slate-800 sm:w-full px-7 sm:max-w-lg border-slate-200 dark:border-slate-600/50">
                                            <div class="flex items-center pb-4">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="icon icon-tabler icon-tabler-alert-circle" width="30"
                                                    height="30" viewBox="0 0 24 24" stroke-width="1.5"
                                                    stroke="#ff2825" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
                                                    <path d="M12 8v4" />
                                                    <path d="M12 16h.01" />
                                                </svg>

                                                <h3 class="ml-2 text-lg font-semibold">
                                                    Remove from vault
                                                </h3>

                                                <button @click="modalOpen=false"
                                                    class="absolute top-0 right-0 flex items-center justify-center w-8 h-8 mt-5 mr-5 rounded-full text-slate-600 hover:text-slate-800 hover:bg-slate-50 dark:hover:bg-slate-900 dark:text-slate-50">
                                                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg"
                                                        fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                        stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </button>
                                            </div>

                                            <div class="relative ml-5">
                                                <p>
                                                    Are you sure you want to remove
                                                    <span
                                                        class="font-semibold text-red-500">'{{ $media['title'] ?? $media['name'] }}'
                                                    </span>
                                                    from your vault?
                                                </p>
                                            </div>

                                            <div class="flex justify-end mt-5">
                                                <div class="space-x-1 text-sm text-white">
                                                    <button @click="modalOpen=false"
                                                        class="inline-flex items-center justify-center px-4 py-1 font-medium leading-6 whitespace-no-wrap transition duration-300 ease-in-out bg-white border rounded-md shadow-sm text-slate-600 border-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 dark:text-slate-50 hover:bg-slate-100 dark:border-slate-600">
                                                        Cancel
                                                    </button>

                                                    <button @click="modalOpen=false"
                                                        wire:click='delete({{ $media['id'] }})'
                                                        class="inline-flex items-center justify-center px-4 py-1 font-medium leading-6 text-white whitespace-no-wrap transition duration-300 ease-in-out bg-red-500 border border-red-500 rounded-md shadow-sm hover:border-red-600 hover:bg-red-600">
                                                        Remove
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>

                <x-slot:figure>
                    <img class="h-[300px] w-[375px] object-cover"
                        src="{{ 'https://image.tmdb.org/t/p/w500/' . $media['poster_path'] ?? $media['backdrop_path'] . '?include_adult=false&language=en-US&page=1' }}"
                        alt="{{ $media['original_title'] ?? $media['original_name'] }}" />
                </x-slot:figure>
            </x-mary-card>
        @empty
            <div class="col-span-3 mx-auto mt-6 text-center">
                <h1 class="text-lg font-semibold text-slate-500">
                    Add movies or TV shows from the

                    <a class="-mr-1 font-medium text-indigo-500 hover:text-indigo-600 dark:hover:text-indigo-400"
                        href="{{ route('movie-vault.explore') }}" wire:navigate>
                        Explore page
                    </a>.
                </h1>
            </div>
        @endforelse
    </div>

    <div class="pt-4">
        {{ $vault_records->links() }}
    </div>
</div>
