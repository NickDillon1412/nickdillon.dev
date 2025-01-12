@props(['tags'])

<div x-data="{
    showDropdown: false,
    tags: $wire.entangle('tags'),
    search: '',
    get filteredTags() {
        return $wire.user_tags.filter(function(user_tag) {
            return !this.tags.some(function(tag) {
                return tag.id === user_tag.id;
            }) && user_tag.name.toLowerCase().includes(this.search.toLowerCase());
        }.bind(this));
    }
}" wire:ignore>
    <button type="button" x-on:click="$refs.multiselect.focus(); showDropdown = true"
        class="block text-sm font-medium text-slate-700 dark:text-slate-300">
        Tags
    </button>

    <div class="relative inline-flex w-full">
        <div
            class="flex items-center w-full mt-2 text-sm text-left rounded-lg shadow-sm border-slate-300 dark:border-slate-700 dark:bg-slate-900 form-input dark:text-slate-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600">
            <button type="button" x-ref="multiselect" class="flex items-center justify-between w-full"
                aria-label="Select date range" aria-haspopup="true" x-on:click="showDropdown = true"
                :aria-expanded="showDropdown" aria-expanded="false">
                <div class="flex items-center gap-1">
                    <p class="px-1.5" x-cloak x-show="tags.length === 0">
                        -- Select tags --
                    </p>

                    <template x-for="(value, index) in tags" :key="index">
                        <div
                            class="rounded px-1.5 text-xs text-indigo-400 dark:text-indigo-500 bg-indigo-100 dark:bg-indigo-900/50 border border-indigo-400 dark:border-indigo-500 flex items-center justify-between space-x-0.5">
                            <p x-text="value.name"></p>

                            <button type="button" x-on:click="tags.splice(index, 1); search = ''"
                                class="focus:outline-none">
                                <x-heroicon-s-x-mark class="w-3 h-3" />
                            </button>
                        </div>
                    </template>
                </div>

                <svg class="mx-1 fill-current shrink-0 text-slate-500" width="11" height="7" viewBox="0 0 11 7">
                    <path d="M5.4 6.8L0 1.4 1.4 0l4 4 4-4 1.4 1.4z"></path>
                </svg>
            </button>

            <button type="button" class="border-l border-slate-300 dark:border-slate-700">
                <x-heroicon-o-plus
                    class="w-6 h-6 p-0.5 text-slate-500 rounded-r-lg duration-100 ease-in-out hover:bg-slate-200 dark:hover:bg-slate-700" />
            </button>
        </div>

        <div class="absolute left-0 z-10 w-full pb-1 mt-1 overflow-hidden bg-white border rounded-lg shadow-lg dark:bg-slate-900 top-full border-slate-200 dark:border-slate-700"
            x-on:click.outside="showDropdown = false" x-on:keydown.escape.window="showDropdown = false"
            x-show="showDropdown" x-transition:enter="transition ease-out duration-100 transform"
            x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-out duration-100" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" style="display: none;">
            <div class="text-sm font-medium text-slate-600 dark:text-slate-300">
                <div class="relative mb-1 border-b border-slate-300 dark:border-slate-700">
                    <label for="search" class="sr-only">
                        Search
                    </label>

                    <input type="text" x-model="search" name="search" id="search"
                        class="block w-full px-3 py-1.5 my-0.5 text-sm shadow-xs border-none ps-9 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:text-slate-400 dark:placeholder-slate-500 focus:ring-0"
                        placeholder="Search tags..." />

                    <div class="absolute inset-y-0 -mt-0.5 flex items-center pointer-events-none start-0 ps-3">
                        <svg class="text-slate-400 size-4 dark:text-slate-500" xmlns="<http://www.w3.org/2000/svg>"
                            width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"></circle>
                            <path d="m21 21-4.3-4.3"></path>
                        </svg>
                    </div>

                    <button x-cloak x-show="search.length > 0" x-on:click="search = ''"
                        class="absolute inset-0 left-auto pr-2" type="button" aria-label="Search">
                        <x-heroicon-s-x-mark
                            class="w-6 h-6 p-0.5 text-slate-500 duration-100 ease-in-out rounded-md hover:bg-slate-200 dark:hover:bg-slate-700" />
                    </button>
                </div>

                <div class="px-1">
                    <template x-for="(value, index) in filteredTags" :key="index">
                        <button type="button" :for="value.name" x-on:click="tags.push(value); search = ''"
                            class="flex items-center w-full px-3 py-2 duration-200 ease-in-out rounded-md hover:bg-slate-100 dark:hover:bg-slate-800">
                            <span class="text-sm capitalize" x-text="value.name"></span>
                        </button>
                    </template>

                    <div x-cloak x-show="filteredTags.length === 0">
                        <p class="px-3 py-2 text-sm text-center">No tags found...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
