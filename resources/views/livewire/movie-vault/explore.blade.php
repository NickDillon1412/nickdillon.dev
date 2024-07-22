<div class="w-full p-4 mx-auto overflow-y-hidden sm:py-8 sm:px-6 lg:px-8 max-w-7xl">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-800 md:text-3xl dark:text-gray-100">
            Explore
        </h1>

        <a href="{{ route('movie-vault.my-vault') }}" wire:navigate
            class="flex items-center px-3 py-2 text-sm font-semibold duration-200 ease-in-out bg-indigo-500 rounded-md hover:bg-indigo-600 text-slate-50">
            &larr; Back to My Vault
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
        @forelse ($this->searchResults as $result)
            @isset($result['original_language'])
                @if ($result['original_language'] === 'en')
                    <x-mary-card shadow
                        class="border text-slate-800 dark:bg-slate-800 border-slate-200 dark:border-slate-700 bg-slate-50 dark:text-slate-50">
                        <div class="-mx-1 -my-3">
                            <h1 class="text-xl font-bold truncate whitespace-nowrap">
                                {{ $result['original_title'] ?? $result['original_name'] }}
                            </h1>

                            <h3>
                                Release Date:
                                {{ Carbon\Carbon::parse($result['release_date'] ?? $result['first_air_date'])->format('M d, Y') }}
                            </h3>

                            <button
                                class="w-full px-4 py-2.5 my-2 text-sm font-semibold duration-200 ease-in-out bg-indigo-500 rounded-md hover:bg-indigo-600 text-slate-50">
                                Add to vault
                            </button>
                        </div>

                        <x-slot:figure>
                            <img class="h-[300px] w-[375px] object-cover"
                                src="{{ 'https://image.tmdb.org/t/p/w500/' . $result['poster_path'] ?? $result['backdrop_path'] . '?include_adult=false&language=en-US&page=1' }}"
                                alt="{{ $result['original_title'] ?? $result['original_name'] }}" />
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
                    <x-mary-loading />
                </div>
            </div>
        @endforelse
    </div>
</div>