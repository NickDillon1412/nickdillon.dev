<div class="w-full p-4 mx-auto overflow-y-hidden sm:py-8 sm:px-6 lg:px-8 max-w-7xl">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-800 md:text-3xl dark:text-gray-100">
            My Vault
        </h1>

        <a href="{{ route('movie-vault.explore') }}" wire:navigate
            class="flex items-center px-3 py-2 text-sm font-semibold duration-200 ease-in-out bg-indigo-500 rounded-md hover:bg-indigo-600 text-slate-50">
            <x-heroicon-s-plus-small class="w-5 h-5 mr-0.5 -ml-1" />

            Add Movies
        </a>
    </div>

    <div class="relative mt-4">
        <x-text-input id="search" class="w-full bg-white form-input pl-9 dark:bg-slate-800 placeholder:text-slate-400"
            type="search" placeholder="Search..." />

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
        <a href="#" wire:navigate>
            <x-mary-card shadow
                class="duration-200 ease-in-out border hover:scale-105 text-slate-800 dark:bg-slate-800 border-slate-200 dark:border-slate-700 bg-slate-50 dark:text-slate-50">
                <div class="-mx-1 -my-3">
                    <h1 class="text-xl font-bold">
                        Movie Title
                    </h1>

                    <h3>
                        Movie description
                    </h3>
                </div>

                <x-slot:figure>
                    <img src="https://picsum.photos/500/200" />
                </x-slot:figure>
            </x-mary-card>
        </a>
    </div>
</div>
</div>
