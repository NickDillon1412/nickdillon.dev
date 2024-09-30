@use('App\Services\MovieVaultService', 'MovieVaultService')

<div class="w-full p-4 mx-auto overflow-y-hidden sm:py-8 sm:px-6 lg:px-8 max-w-7xl">
    <div class="flex flex-wrap-reverse items-center justify-between gap-2">
        <h1 class="text-2xl font-bold text-slate-800 md:text-3xl dark:text-slate-100">
            {{ $vault->title ?? $vault->name }}
        </h1>

        <div class="flex items-center mt-2 space-x-2 sm:mt-0">
            <a href="{{ route('movie-vault.my-vault') }}" wire:navigate
                class="flex items-center justify-center w-full px-3 py-2 text-sm font-semibold duration-200 ease-in-out bg-indigo-500 rounded-md sm:w-auto hover:bg-indigo-600 text-slate-50">
                <x-ri-safe-2-line class="w-4 h-4 mr-1.5 -ml-1" />

                <span>Vault</span>
            </a>

            <a href="{{ route('movie-vault.wishlist') }}" wire:navigate
                class="flex items-center justify-center w-full px-3 py-2 text-sm font-semibold duration-200 ease-in-out bg-indigo-500 rounded-md sm:w-auto hover:bg-indigo-600 text-slate-50">
                <x-heroicon-o-heart class="w-4 h-4 mr-1 -ml-1" />

                <span>Wishlist</span>
            </a>
        </div>
    </div>

    <div
        class="flex flex-col justify-center w-full mt-4 border rounded-lg md:mt-8 md:flex-row border-slate-200 dark:border-slate-600/50">
        <img class="object-cover w-auto rounded-lg rounded-b-none md:rounded-r-none md:rounded-bl-lg h-96"
            src="{{ 'https://image.tmdb.org/t/p/w500/' . $vault->poster_path ?? $vault->backdrop_path . '?include_adult=false&language=en-US&page=1' }}" />

        <div
            class="flex flex-col p-4 bg-white rounded-b-lg sm:rounded-r-lg sm:rounded-bl-none sm:flex-row sm:relative dark:bg-slate-800 dark:text-slate-50 text-slate-800">
            <div class="space-y-3">
                <p>
                    <span class="font-semibold">
                        {{ $vault->title ? 'Title:' : 'Name:' }}
                    </span>

                    {{ $vault->title ?? $vault->name }}
                </p>

                <p>
                    <span class="font-semibold">
                        Type:
                    </span>

                    {{ $vault->vault_type === 'tv' ? 'TV Show' : Str::title($vault->vault_type) }}
                </p>

                <p>
                    <span class="font-semibold">
                        Overview:
                    </span>

                    {{ $vault->overview }}
                </p>

                <p>
                    <span class="font-semibold">
                        {{ $vault->release_date ? 'Release Date: ' : 'First Air Date: ' }}
                    </span>

                    {{ Carbon\Carbon::parse($vault->release_date ?? $vault->first_air_date)->format('M d, Y') }}
                </p>

                <p>
                    <span class="font-semibold">
                        Genres:
                    </span>

                    {{ Str::replace(',', ', ', $vault->genres) }}
                </p>

                <p>
                    <span class="font-semibold">
                        Rating:
                    </span>

                    {{ $vault->rating }}
                </p>

                @isset($vault->runtime)
                    <p>
                        <span class="font-semibold">
                            Length:
                        </span>

                        {{ MovieVaultService::formatRuntime($vault->runtime) }}
                    </p>
                @endisset

                @isset($vault->seasons)
                    <p>
                        <span class="font-semibold">
                            Seasons:
                        </span>

                        {{ $vault->seasons }}
                    </p>
                @endisset

                <p>
                    <span class="font-semibold">
                        Actors:
                    </span>

                    {{ Str::replace(',', ', ', $vault->actors) ?: 'No actors found' }}
                </p>
            </div>

            <div class="flex items-center pt-3 sm:bottom-0 sm:right-0 sm:p-4 sm:absolute sm:pt-0">
                <x-modal
                    wire:click="{{ $vault->on_wishlist ? 'addToVault(' . $vault->id . ')' : 'addToWishlist(' . $vault->id . ')' }}"
                    info>
                    <x-heroicon-s-plus-small
                        class="w-6 h-6 duration-200 ease-in-out rounded hover:bg-slate-200 dark:hover:bg-slate-700" />

                    <x-slot:title>
                        Add to
                        {{ $vault->on_wishlist ? 'vault' : 'wishlist' }}?
                    </x-slot:title>

                    <x-slot:body>
                        Are you sure you want to add

                        <span class="font-semibold text-indigo-500">
                            '{{ $vault->title ?? $vault->name }}'
                        </span>

                        to your

                        {{ $vault->on_wishlist ? 'vault' : 'wishlist' }}?
                    </x-slot:body>
                </x-modal>

                <x-modal wire:click="delete({{ $vault->id }})" delete>
                    <x-heroicon-o-trash
                        class="p-1 text-red-600 duration-100 ease-in-out rounded w-7 h-7 hover:bg-slate-200 dark:hover:bg-slate-700" />

                    <x-slot:title>
                        Remove from
                        {{ $vault->on_wishlist ? 'wishlist' : 'vault' }}
                    </x-slot:title>

                    <x-slot:body>
                        Are you sure you want to remove

                        <span class="font-semibold text-red-500">
                            '{{ $vault->title ?? $vault->name }}'
                        </span>

                        from your

                        {{ $vault->on_wishlist ? 'wishlist' : 'vault' }}?
                    </x-slot:body>
                </x-modal>
            </div>
        </div>
    </div>
</div>
