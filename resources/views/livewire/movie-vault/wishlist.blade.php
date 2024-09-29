@use('App\Services\MovieVaultService', 'MovieVaultService')

<div class="w-full p-4 mx-auto overflow-y-hidden sm:py-8 sm:px-6 lg:px-8 max-w-7xl">
    <div class="flex flex-col justify-between sm:flex-row sm:items-center">
        <div class="flex flex-row items-center space-x-1.5">
            <h1 class="text-2xl font-bold text-slate-800 md:text-3xl dark:text-slate-100">
                My Wishlist
            </h1>

            <p class="text-2xl font-bold text-slate-800 md:text-3xl dark:text-slate-100">
                (Total: {{ $wishlist_records->total() }})
            </p>
        </div>

        <div class="flex items-center mt-2 space-x-2 sm:mt-0">
            <a href="{{ route('movie-vault.my-vault') }}" wire:navigate
                class="flex items-center justify-center w-full px-3 py-2 text-sm font-semibold duration-200 ease-in-out bg-indigo-500 rounded-md sm:w-auto hover:bg-indigo-600 text-slate-50">
                <x-ri-safe-2-line class="w-4 h-4 mr-1.5 -ml-1" />

                <span>Vault</span>
            </a>

            <a href="{{ route('movie-vault.explore') }}" wire:navigate
                class="flex items-center justify-center w-full px-3 py-2 text-sm font-semibold duration-200 ease-in-out bg-indigo-500 rounded-md sm:w-auto hover:bg-indigo-600 text-slate-50">
                <x-heroicon-s-plus-small class="w-5 h-5 mr-0.5 -ml-1" />

                <span>Add to vault</span>
            </a>
        </div>
    </div>

    @if (count(auth()->user()->vaults->where('on_wishlist', true)) > 0)
        <div class="flex items-center mt-4 space-x-2">
            <div class="relative w-full">
                <x-text-input id="search" wire:model.live.debounce.300ms='search'
                    class="w-full bg-white form-input pl-9 dark:bg-slate-800 placeholder:text-slate-400" type="text"
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

                <button x-cloak x-show="$wire.search.length > 0" wire:click="$set('search', '')"
                    class="absolute inset-0 left-auto pr-2 group" type="submit" aria-label="Search">
                    <x-heroicon-s-x-mark
                        class="w-5 h-5 duration-200 ease-in-out text-slate-500 hover:text-slate-600 dark:hover:text-slate-400" />
                </button>
            </div>

            <x-movie-vault.filters :$ratings :$genres />
        </div>
    @endif

    <div wire:loading.remove>
        <div class="grid grid-cols-1 gap-4 pt-4 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($wishlist_records as $vault)
                <x-mary-card shadow
                    class="duration-200 ease-in-out border text-slate-800 dark:bg-slate-800 border-slate-200 dark:border-slate-700 bg-slate-50 dark:text-slate-50">
                    <div class="-mx-1 -my-3">
                        <h1 class="text-xl font-bold truncate whitespace-nowrap">
                            {{ $vault->original_title ?? $vault->original_name }}
                        </h1>

                        <h3>
                            {{ $vault->release_date ? 'Release Date: ' : 'First Air Date: ' }}

                            {{ Carbon\Carbon::parse($vault->release_date ?? $vault->first_air_date)->format('M d, Y') }}
                        </h3>

                        <p class="truncate">
                            Genres: {{ Str::replace(',', ', ', $vault->genres) }}
                        </p>

                        <p>
                            Rating: {{ $vault->rating }}
                        </p>

                        @isset($vault->runtime)
                            <p>
                                Length:
                                {{ MovieVaultService::formatRuntime($vault->runtime) }}
                            </p>
                        @endisset

                        @isset($vault->seasons)
                            <p>
                                Seasons:
                                {{ $vault->seasons }}
                            </p>
                        @endisset

                        <p class="truncate">
                            Actors:
                            {{ Str::replace(',', ', ', $vault->actors) ?: 'No actors found' }}
                        </p>

                        <div class="flex items-center justify-between w-full text-sm">
                            <a class="font-medium text-indigo-500 duration-200 ease-in-out hover:text-indigo-600 dark:hover:text-indigo-400"
                                href="{{ route('movie-vault.details', $vault->id) }}" wire:navigate>
                                View all details &rarr;
                            </a>

                            <div class="flex items-center -mr-2">
                                <x-modal wire:click="addToVault({{ $vault->id }})" info>
                                    <x-heroicon-s-plus-small
                                        class="w-6 h-6 duration-200 ease-in-out rounded hover:bg-slate-200 dark:hover:bg-slate-700" />

                                    <x-slot:title>
                                        Add to vault
                                    </x-slot:title>

                                    <x-slot:body>
                                        Are you sure you want to add

                                        <span class="font-semibold text-indigo-500">
                                            '{{ $vault->title ?? $vault->name }}'
                                        </span>

                                        to your vault?
                                    </x-slot:body>
                                </x-modal>

                                <x-modal wire:click="addToVault({{ $vault->id }})" delete>
                                    <x-heroicon-o-trash
                                        class="p-1 text-red-600 duration-100 ease-in-out rounded w-7 h-7 hover:bg-slate-200 dark:hover:bg-slate-700" />

                                    <x-slot:title>
                                        Remove from wishlist
                                    </x-slot:title>

                                    <x-slot:body>
                                        Are you sure you want to remove

                                        <span class="font-semibold text-red-500">
                                            '{{ $vault->title ?? $vault->name }}'
                                        </span>

                                        from your wishlist?
                                    </x-slot:body>
                                </x-modal>
                            </div>
                        </div>
                    </div>

                    <x-slot:figure>
                        <a href="{{ route('movie-vault.details', $vault->id) }}" wire:navigate class="w-full">
                            <img class="h-[300px] w-full object-cover"
                                src="{{ 'https://image.tmdb.org/t/p/w500/' . $vault->poster_path ?? $vault->backdrop_path . '?include_adult=false&language=en-US&page=1' }}"
                                alt="{{ $vault->original_title ?? $vault->original_name }}" />
                        </a>
                    </x-slot:figure>
                </x-mary-card>
            @empty
                <div class="col-span-3 mx-auto mt-6 text-center">
                    <h1 class="text-lg font-semibold text-slate-500">
                        Add movies or TV shows from the

                        <a class="-mr-1 font-medium text-indigo-500 duration-200 ease-in-out hover:text-indigo-600 dark:hover:text-indigo-400"
                            href="{{ route('movie-vault.explore') }}" wire:navigate>
                            Explore page
                        </a>.
                    </h1>
                </div>
            @endforelse
        </div>

        <div class="pt-4">
            {{ $wishlist_records->links() }}
        </div>
    </div>

    <div wire:loading.flex class="flex justify-center mt-4 items center">
        <x-large-loading-spinner />
    </div>
</div>
