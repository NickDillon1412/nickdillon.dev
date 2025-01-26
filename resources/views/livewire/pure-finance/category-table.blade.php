<div class="w-full p-4 mx-auto overflow-y-hidden sm:py-8 sm:px-6 lg:px-8 max-w-screen-2xl">
    <div class="flex flex-col space-y-3">
        <div class="flex items-center justify-between w-full">
            <h1 class="text-2xl font-semibold md:text-3xl text-slate-800 dark:text-slate-200">
                Categories
            </h1>

            <div>
                <flux:button x-on:click="$dispatch('open-category-create-form')" variant="indigo" icon="plus"
                    size="sm" class="w-full sm:w-auto">
                    New Category
                </flux:button>
            </div>
        </div>

        <div
            class="bg-white border divide-y shadow-sm rounded-xl border-slate-200 dark:bg-slate-800 divide-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 dark:divide-slate-600">
            <div class="flex justify-between items-center px-5 py-3.5">
                <div class="flex items-center w-full sm:w-64 justify-between -mr-1.5 space-x-1">
                    <div class="relative w-full sm:pr-2">
                        <label for="search" class="sr-only">
                            Search
                        </label>

                        <input type="text" wire:model.live.debounce.300ms='search' name="search" id="search"
                            autofocus
                            class="block w-full px-3 py-1.5 sm:text-sm rounded-lg shadow-sm border-slate-300 ps-9 focus:z-10 focus:border-indigo-500 focus:ring-indigo-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-slate-700 dark:text-slate-400 dark:placeholder-slate-500 dark:focus:ring-indigo-600"
                            placeholder="Search categories..." />

                        <div class="absolute inset-y-0 flex items-center pointer-events-none start-0 ps-3">
                            <svg class="text-slate-400 size-4 dark:text-slate-500" xmlns="<http://www.w3.org/2000/svg>"
                                width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8"></circle>
                                <path d="m21 21-4.3-4.3"></path>
                            </svg>
                        </div>

                        <button x-cloak x-show="$wire.search.length > 0" wire:click="$set('search', '')"
                            class="absolute inset-0 left-auto pr-2 sm:pr-4" type="submit" aria-label="Search">
                            <x-heroicon-s-x-mark
                                class="w-6 h-6 p-0.5 text-rose-500 duration-200 ease-in-out rounded-md hover:bg-slate-200 dark:hover:bg-slate-700" />
                        </button>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full divide-y table-auto divide-slate-200 dark:divide-slate-600">
                    <thead class="bg-slate-100/75 dark:bg-slate-700">
                        <tr>
                            <th scope="col"
                                class="py-3 pl-5 text-xs font-semibold uppercase text-slate-600 text-start dark:text-slate-200">
                                Name
                            </th>

                            <th scope="col"
                                class="py-3 text-xs font-semibold text-left uppercase text-slate-600 dark:text-slate-200">
                                Parent
                            </th>

                            <th scope="col"
                                class="py-3 pr-5 text-xs font-semibold uppercase text-slate-600 text-end dark:text-slate-200">
                                Actions
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-200 dark:divide-slate-600">
                        @forelse ($categories as $category)
                            <tr wire:key='{{ $category->id }}'>
                                <td class="py-3.5 pl-5 text-sm text-slate-800 whitespace-nowrap dark:text-slate-200">
                                    {{ $category->name }}
                                </td>

                                <td
                                    class="py-3.5 text-left text-sm text-slate-800 whitespace-nowrap dark:text-slate-200">
                                    {{ $category->parent?->name }}
                                </td>

                                <td
                                    class="py-1 pr-5 text-sm font-medium whitespace-nowrap text-slate-800 dark:text-slate-200">
                                    <div class="flex items-center justify-end">
                                        <button
                                            x-on:click="$dispatch('open-category-edit-form', { category: {{ $category->toJson() }} })">
                                            <x-heroicon-o-pencil-square
                                                class="p-1 text-indigo-500 duration-100 ease-in-out rounded-md w-7 h-7 hover:bg-slate-200 dark:hover:bg-slate-700" />
                                        </button>

                                        <x-modal icon="information-circle" delete variant="danger"
                                            wire:submit="delete({{ $category->id }})">
                                            <x-slot:button>
                                                <x-heroicon-o-trash
                                                    class="p-1 -mr-2 text-red-500 duration-100 ease-in-out rounded-md w-7 h-7 hover:bg-slate-200 dark:hover:bg-slate-700" />
                                            </x-slot:button>

                                            <x-slot:title>
                                                Delete Category
                                            </x-slot:title>

                                            <x-slot:body>
                                                Are you sure you want to delete the

                                                <span class="font-semibold text-red-500">
                                                    '{{ $category->name }}'
                                                </span>

                                                category?
                                            </x-slot:body>
                                        </x-modal>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8">
                                    <p class="p-3 text-sm italic font-medium text-center">
                                        No categories found...
                                    </p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{ $categories->links() }}

        <livewire:pure-finance.category-form />
    </div>
</div>
