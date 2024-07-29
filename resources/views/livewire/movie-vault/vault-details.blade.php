<div class="w-full p-4 mx-auto overflow-y-hidden sm:py-8 sm:px-6 lg:px-8 max-w-7xl">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-slate-800 md:text-3xl dark:text-slate-100">
            {{ $vault->title ?? $vault->name }}
        </h1>

        <a href="{{ route('movie-vault.my-vault') }}" wire:navigate
            class="flex items-center px-3 py-2 text-sm font-semibold duration-200 ease-in-out bg-indigo-500 rounded-md hover:bg-indigo-600 text-slate-50">
            &larr; Back to My Vault
        </a>
    </div>

    <div
        class="flex flex-col justify-center w-full mt-4 border rounded-lg sm:mt-8 sm:flex-row border-slate-200 dark:border-slate-600/50">
        <img class="object-cover rounded-lg rounded-b-none sm:rounded-r-none sm:rounded-bl-lg h-96 w-96"
            src="{{ 'https://image.tmdb.org/t/p/w500/' . $vault['poster_path'] ?? $vault['backdrop_path'] . '?include_adult=false&language=en-US&page=1' }}"
            alt="{{ $vault['original_title'] ?? $vault['original_name'] }}" />

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
                    <span class="font-semibold">Overview:</span>

                    {{ $vault->overview }}
                </p>

                <p>
                    <span class="font-semibold">
                        {{ $vault->release_date ? 'Release Date: ' : 'First Air Date: ' }}
                    </span>

                    {{ Carbon\Carbon::parse($vault->release_date ?? $vault->first_air_date)->format('M d, Y') }}
                </p>
            </div>

            <div class="pt-3 sm:bottom-0 sm:right-0 sm:p-4 sm:absolute sm:pt-0">
                <x-delete-modal id="{{ $vault['id'] }}" title="{{ $vault['title'] ?? $vault['name'] }}">
                    <button
                        class="inline-flex items-center justify-center w-full px-4 py-1 text-sm font-medium leading-6 text-white whitespace-no-wrap transition duration-300 ease-in-out bg-red-500 border border-red-500 rounded-md shadow-sm hover:border-red-600 hover:bg-red-600"
                        type="button">
                        Remove
                    </button>
                </x-delete-modal>
            </div>
        </div>
    </div>
</div>
