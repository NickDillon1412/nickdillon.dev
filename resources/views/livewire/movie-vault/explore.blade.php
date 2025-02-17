@use('App\Services\MovieVaultService', 'MovieVaultService')

<div class="w-full p-4 mx-auto overflow-y-hidden sm:py-8 sm:px-6 lg:px-8 max-w-7xl">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-800 md:text-3xl dark:text-gray-100">
            Explore
        </h1>

        <flux:button variant="indigo" icon="arrow-left" href="{{ route('movie-vault.my-vault') }}" wire:navigate>
            Back to vault
        </flux:button>
    </div>

    <div class="relative mt-4">
        <x-text-input id="search" wire:model.live.debounce.300ms='search'
            class="w-full bg-white pl-9 dark:bg-slate-800 placeholder:text-slate-400" type="text"
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

    <div class="grid grid-cols-1 gap-4 pt-4 sm:grid-cols-2 lg:grid-cols-3">
        @forelse ($this->searchResults as $media)
            @isset($media['original_language'])
                @if ($media['original_language'] === 'en')
                    <x-mary-card shadow
                        class="border text-slate-800 dark:bg-slate-800 border-slate-200 dark:border-slate-700 bg-slate-50 dark:text-slate-50">
                        <div class="-mx-1 -my-3">
                            <h1 class="text-xl font-bold truncate whitespace-nowrap">
                                {{ $media['original_title'] ?? $media['original_name'] }}
                            </h1>

                            <h3>
                                Release Date:
                                {{ Carbon\Carbon::parse($media['release_date'] ?? $media['first_air_date'])->format('M d, Y') }}
                            </h3>

                            <p class="truncate">
                                Genres:
                                {{ Str::replace(',', ', ', $media['genres']) ?: 'None' }}
                            </p>

                            <p>
                                Rating:
                                {{ $media['rating'] ?? 'None' }}

                                @if ($media['imdb_id'] !== '' ? $media['imdb_id'] : null)
                                    -

                                    <a class="text-sm font-medium text-indigo-500 duration-200 ease-in-out hover:text-indigo-600 dark:hover:text-indigo-400"
                                        href="https://www.imdb.com/title/{{ $media['imdb_id'] }}/parentalguide"
                                        target="_blank">
                                        <span class="inline-flex items-center">
                                            View parents guide

                                            <x-heroicon-s-arrow-up-right class="w-3 h-3 ml-0.5" />
                                        </span>
                                    </a>
                                @endif
                            </p>

                            @isset($media['runtime'])
                                <p>
                                    Length:
                                    {{ MovieVaultService::formatRuntime($media['runtime']) }}
                                </p>
                            @endisset

                            @isset($media['number_of_seasons'])
                                <p>
                                    Seasons:
                                    {{ $media['number_of_seasons'] }}
                                </p>
                            @endisset

                            <p class="truncate">
                                Actors:
                                {{ Str::replace(',', ', ', $media['actors']) ?: 'None' }}
                            </p>

                            <div class="flex items-center justify-between my-2 space-x-3">
                                <form wire:submit='save(@json($media))' class="w-full">
                                    <flux:button variant="indigo" class="w-full" type="submit">
                                        Add to vault
                                    </flux:button>
                                </form>

                                <form wire:submit="save(@js($media), 'wishlist')" class="w-full">
                                    <flux:button variant="filled" class="w-full" type="submit">
                                        Add to wishlist
                                    </flux:button>
                                </form>
                            </div>
                        </div>

                        <x-slot:figure>
                            <img class="h-[300px] w-full object-cover"
                                src="{{ 'https://image.tmdb.org/t/p/w500/' . $media['poster_path'] ?? $media['backdrop_path'] . '?include_adult=false&language=en-US&page=1' }}"
                                alt="{{ $media['original_title'] ?? $media['original_name'] }}" />
                        </x-slot:figure>
                    </x-mary-card>
                @endif
            @endisset
        @empty
            <div class="col-span-3 pt-6 mx-auto text-slate-500">
                <h1 class="text-lg font-semibold" wire:loading.remove>
                    Search for movies or TV shows...
                </h1>

                <div class="flex justify-center" wire:loading wire:target='search'>
                    <x-large-loading-spinner />
                </div>
            </div>
        @endforelse
    </div>
</div>
