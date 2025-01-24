<div x-cloak x-data="{ categoryFormModalOpen: $wire.entangle('modal_open').live }" x-on:keydown.escape.window="categoryFormModalOpen = false"
    class="relative w-auto h-auto">
    <button x-on:click="categoryFormModalOpen = true" type="button"
        class="dark:bg-slate-900 m-0.5 p-0.5 duration-100 ease-in-out hover:bg-slate-200 dark:hover:bg-slate-700 rounded-md">
        <x-heroicon-o-plus class="w-5 h-5 text-slate-600 dark:text-slate-500" />
    </button>

    <div class="fixed inset-0 z-[99] transition-opacity bg-slate-900 bg-opacity-40 dark:bg-opacity-60 backdrop-blur-sm"
        x-show="categoryFormModalOpen" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-out duration-100" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" aria-hidden="true" style="display: none;">
    </div>

    <div id="categoryFormModalOpen-modal"
        class="fixed inset-0 z-[99] flex items-center justify-center px-4 my-4 overflow-hidden sm:px-6" role="dialog"
        aria-modal="true" x-show="categoryFormModalOpen" x-transition:enter="transition ease-in-out duration-200"
        x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in-out duration-200" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-4" style="display: none;">
        <div class="w-full max-w-xl max-h-full overflow-auto bg-white border rounded-lg shadow-lg dark:bg-slate-800 text-slate-800 dark:text-slate-100 border-slate-200 dark:border-slate-700"
            x-on:click.outside="categoryFormModalOpen = false"
            x-on:keydown.escape.window="categoryFormModalOpen = false" x-trap.inert.noscroll="categoryFormModalOpen">
            <div class="px-5 py-2.5 border-b border-slate-200 dark:border-slate-700">
                <div class="flex items-center justify-between">
                    <div class="text-lg font-semibold">
                        {{ $category ? 'Edit' : 'Create' }} Category
                    </div>

                    <flux:button icon="x-mark" x-on:click="categoryFormModalOpen = false"
                        class="!h-8 !w-8 !-mr-2 !border-none hover:!bg-slate-100 dark:hover:!bg-slate-700 !shadow-none" />
                </div>
            </div>

            <div class="space-y-5">
                <div class="px-5 pt-4 space-y-5">
                    <div>
                        <div class="flex space-x-1">
                            <x-input-label for="name" :value="__('Name')" />

                            <span class="text-rose-500">*</span>
                        </div>

                        <x-text-input wire:model="name" id="name" class="block w-full mt-2 text-sm" type="text"
                            name="name" autocomplete="name" required />

                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div>
                        <div class="flex space-x-1">
                            <x-input-label for="parent_id" :value="__('Parent')" />
                        </div>

                        <select wire:model='parent_id' id="parent_id" required
                            class="flex w-full mt-1 text-sm rounded-lg shadow-sm border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600">
                            <option value="">Select a category</option>

                            @foreach ($this->parent_categories as $parent)
                                <option value="{{ $parent->id }}">
                                    {{ $parent->name }}
                                </option>
                            @endforeach
                        </select>

                        <x-input-error :messages="$errors->get('parent_id')" class="mt-2" />
                    </div>
                </div>

                <div class="flex justify-end px-5 pb-5">
                    <div class="space-x-1 text-sm text-white">
                        <flux:button variant="outline" class="!px-5" x-on:click="categoryFormModalOpen = false">
                            Cancel
                        </flux:button>

                        <flux:button variant="indigo" class="!px-5" type="button" wire:click='submit'
                            x-on:click="$dispatch('category-saved')">
                            Submit
                        </flux:button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
