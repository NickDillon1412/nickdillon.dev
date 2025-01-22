<div x-data="categories" wire:ignore>
    <p class="block text-sm font-medium cursor-default text-slate-700 dark:text-slate-300">
        Category

        <span class="text-rose-500">*</span>
    </p>

    <div class="relative inline-flex w-full">
        <div class="flex items-stretch w-full mt-2">
            <div class="flex items-center w-full text-sm text-left rounded-lg ring-1 shadow-sm border-slate-300 dark:border-slate-700 dark:bg-slate-900 form-input py-[9px] dark:text-slate-300 z-20"
                :class="{ '!border-indigo-500 dark:!border-indigo-600 ring-1 !ring-indigo-500 dark:!ring-indigo-600': showDropdown }">
                <button type="button" class="flex items-center justify-between w-full py-0" aria-haspopup="true"
                    x-on:click="showDropdown = true" :aria-expanded="showDropdown" aria-expanded="false">
                    <p class="-my-[1px] text-slate-600 dark:text-slate-300" x-text="selectedCategoryName"></p>

                    <flux:icon.chevrons-up-down class="!h-4 !w-4 !-mr-0.5 text-slate-500" />
                </button>
            </div>
        </div>

        <div class="absolute left-0 z-40 w-full pb-1 mt-1 overflow-hidden bg-white border rounded-lg shadow-lg dark:bg-slate-900 top-full border-slate-200 dark:border-slate-700"
            x-on:click.outside="showDropdown = false" x-on:keydown.escape.window="showDropdown = false"
            x-show="showDropdown" x-transition:enter="transition ease-out duration-100 transform"
            x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-out duration-100" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" style="display: none;">
            <div class="text-sm font-medium text-slate-600 dark:text-slate-300">
                <div class="relative mb-1 border-b border-slate-300 dark:border-slate-700">
                    <label for="category-search" class="sr-only">
                        Search
                    </label>

                    <input type="text" x-model="search" name="category-search" id="category-search"
                        class="block w-full px-3 py-1.5 my-0.5 text-sm shadow-xs border-none ps-9 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:text-slate-400 dark:placeholder-slate-500 focus:ring-0"
                        placeholder="Search categories..." />

                    <div class="absolute inset-y-0 -mt-0.5 flex items-center pointer-events-none start-0 ps-3">
                        <svg class="text-slate-400 size-4 dark:text-slate-500" xmlns="<http://www.w3.org/2000/svg>"
                            width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"></circle>
                            <path d="m21 21-4.3-4.3"></path>
                        </svg>
                    </div>

                    <div class="absolute flex items-center -space-x-0.5 pr-1 inset-0 left-auto">
                        <button x-cloak x-show="search.length > 0" x-on:click="search = ''" type="button"
                            aria-label="Search">
                            <x-heroicon-s-x-mark
                                class="w-6 h-6 p-0.5 text-rose-500 duration-200 ease-in-out rounded-md hover:bg-slate-200 dark:hover:bg-slate-700" />
                        </button>

                        <livewire:pure-finance.category-form />
                    </div>
                </div>

                <div class="px-1 overflow-y-scroll max-h-[250px]">
                    <template x-for="category in filteredCategories" :key="category.id">
                        <div>
                            <button type="button" x-on:click="category_id = category.id; search = ''"
                                class="flex items-center justify-between w-full px-2.5 py-2 duration-200 ease-in-out rounded-md hover:bg-slate-100 dark:hover:bg-slate-800"
                                :class="{ 'bg-slate-100 dark:bg-slate-800': category_id === category.id }">
                                <span class="text-sm capitalize"
                                    :class="{ 'text-indigo-600 font-medium': category_id === category.id }"
                                    x-text="category.name">
                                </span>

                                <div x-cloak x-show="category_id === category.id">
                                    <flux:icon.check
                                        class="h-5 -mr-1 w-5 p-0.5 stroke-indigo-600 stroke-2 dark:text-slate-400" />
                                </div>
                            </button>

                            <div x-cloak x-show="category.children.length > 0" class="pl-4 my-0.5">
                                <template x-for="child in category.children" :key="child.id">
                                    <button type="button" x-on:click="category_id = child.id; search = ''"
                                        class="flex items-center my-0.5 justify-between w-full px-2.5 py-2 duration-200 ease-in-out rounded-md hover:bg-slate-100 dark:hover:bg-slate-800"
                                        :class="{ 'bg-slate-100 dark:bg-slate-800': category_id === child.id }">
                                        <span class="text-sm capitalize"
                                            :class="{ 'text-indigo-600 font-medium': category_id === child.id }"
                                            x-text="child.name">
                                        </span>

                                        <div x-cloak x-show="category_id === child.id">
                                            <flux:icon.check
                                                class="h-5 -mr-1 w-5 p-0.5 stroke-indigo-600 stroke-2 dark:text-slate-400" />
                                        </div>
                                    </button>
                                </template>
                            </div>
                        </div>
                    </template>

                    <div x-cloak x-show="filteredCategories.length === 0">
                        <p class="px-3 py-2 text-sm text-center">No categories found...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@script
    <script>
        Alpine.data('categories', () => {
            return {
                showDropdown: false,
                category_id: $wire.entangle('category_id'),
                categories: $wire.entangle('categories'),
                search: '',
                get filteredCategories() {
                    return this.categories
                        .map(parent => {
                            const matchesParent = parent.name.toLowerCase().includes(this.search
                                .toLowerCase());

                            const filteredChildren = (parent.children || []).filter(child =>
                                child.name.toLowerCase().includes(this.search.toLowerCase())
                            );

                            if (matchesParent || filteredChildren.length > 0) {
                                return {
                                    ...parent,
                                    children: filteredChildren,
                                };
                            }

                            return null;
                        })
                        .filter(Boolean);
                },
                get selectedCategoryName() {
                    let category = this.categories.find(category => category.id === this.category_id);

                    if (!category) {
                        this.categories.forEach(parent => {
                            const child = parent.children.find(child => child.id === this.category_id);
                            if (child) category = child;
                        });
                    }

                    return category ? category.name : 'Select a category';
                }
            };
        })
    </script>
@endscript
