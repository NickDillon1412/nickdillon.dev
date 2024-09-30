@use('App\Services\MovieVaultService', 'MovieVaultService')

<div class="w-full p-4 mx-auto overflow-y-hidden sm:py-8 sm:px-6 lg:px-8 max-w-7xl">
    <div class="flex flex-col-reverse items-center justify-between gap-2 sm:flex-row">
        <h1 class="w-full text-2xl font-bold text-slate-800 md:text-3xl dark:text-slate-100">
            {{ $vault->title }}
        </h1>

        <div class="flex items-center w-full mt-2 space-x-2 sm:w-auto sm:flex-row sm:mt-0">
            <flux:button variant="indigo" icon="film" href="{{ route('movie-vault.my-vault') }}" wire:navigate
                class="w-full sm:w-auto">
                Vault
            </flux:button>

            <flux:button variant="indigo" href="{{ route('movie-vault.wishlist') }}" wire:navigate
                class="w-full sm:w-auto">
                <flux:icon icon="heart" variant="outline" class="w-4 h-4" />

                Wishlist
            </flux:button>
        </div>
    </div>

    <div
        class="flex flex-col w-full mt-2 overflow-hidden bg-white border rounded-lg shadow sm:mt-4 md:flex-row border-slate-200 dark:border-slate-700 dark:bg-slate-800 text-slate-800 dark:text-slate-100">
        <div class="relative w-full md:w-96 h-96 md:h-auto">
            <img class="absolute inset-0 object-cover w-full h-full"
                src="{{ 'https://image.tmdb.org/t/p/w500/' . $vault->poster_path ?? $vault->backdrop_path . '?include_adult=false&language=en-US&page=1' }}"
                alt="{{ $vault->title }}" />
        </div>

        <div class="relative flex flex-col justify-between w-full p-4 space-y-3">
            <p>
                <span class="font-semibold">
                    Title:
                </span>

                {{ $vault->title }}
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

                {{ MovieVaultService::formatDate($vault->release_date ?? $vault->first_air_date) }}
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

            <div class="flex items-center sm:bottom-0 sm:right-0 sm:p-4 sm:absolute sm:pt-0">
                <x-modal
                    wire:click="{{ $vault->on_wishlist ? 'addToVault(' . $vault->id . ')' : 'addToWishlist(' . $vault->id . ')' }}"
                    info>
                    <x-heroicon-s-plus-small
                        class="w-6 h-6 duration-200 ease-in-out rounded-md hover:bg-slate-200 dark:hover:bg-slate-700" />

                    <x-slot:title>
                        Add to
                        {{ $vault->on_wishlist ? 'vault' : 'wishlist' }}?
                    </x-slot:title>

                    <x-slot:body>
                        Are you sure you want to add

                        <span class="font-semibold text-indigo-500">
                            '{{ $vault->title }}'
                        </span>

                        to your

                        {{ $vault->on_wishlist ? 'vault' : 'wishlist' }}?
                    </x-slot:body>
                </x-modal>

                <x-modal wire:click="delete({{ $vault->id }})" delete>
                    <x-heroicon-o-trash
                        class="p-1 duration-100 ease-in-out rounded-md text-rose-600 w-7 h-7 hover:bg-slate-200 dark:hover:bg-slate-700" />

                    <x-slot:title>
                        Remove from
                        {{ $vault->on_wishlist ? 'wishlist' : 'vault' }}
                    </x-slot:title>

                    <x-slot:body>
                        Are you sure you want to remove

                        <span class="font-semibold text-rose-600">
                            '{{ $vault->title }}'
                        </span>

                        from your

                        {{ $vault->on_wishlist ? 'wishlist' : 'vault' }}?
                    </x-slot:body>
                </x-modal>
            </div>
        </div>
    </div>
</div>
