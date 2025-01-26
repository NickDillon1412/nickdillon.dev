<div x-cloak x-data="{
    categoryFormModalOpen: $wire.entangle('modal_open').live,
    title: '',
    clearForm() {
        $nextTick(() => {
            $wire.category = null;
            $wire.name = '';
            $wire.parent_id = null;
        });
    }
}" x-on:keydown.escape.window="categoryFormModalOpen = false; clearForm()"
    x-on:open-category-create-form.window="categoryFormModalOpen = true; title = 'Create'"
    x-on:open-category-edit-form.window="categoryFormModalOpen = true; $wire.loadCategory(); title = 'Edit'"
    x-on:category-saved="categoryFormModalOpen = false; clearForm()" class="relative w-auto h-auto">
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
            x-on:click.outside="categoryFormModalOpen = false; clearForm()"
            x-on:keydown.escape.window="categoryFormModalOpen = false; clearForm()"
            x-trap.inert.noscroll="categoryFormModalOpen">
            <div class="px-5 py-2.5 border-b border-slate-200 dark:border-slate-700">
                <div class="flex items-center justify-between">
                    <div class="text-lg font-semibold">
                        <span x-text="title"></span> Category
                    </div>

                    <flux:button icon="x-mark" x-on:click="categoryFormModalOpen = false; clearForm()"
                        class="!h-8 !w-8 !-mr-2 !border-none hover:!bg-slate-100 dark:hover:!bg-slate-700 !shadow-none" />
                </div>
            </div>

            <div x-cloak wire:loading.flex wire:target='loadCategory'
                class="flex justify-center text-center py-[105px]">
                <x-large-loading-spinner />
            </div>

            <div x-cloak wire:loading.remove wire:target='loadCategory' class="w-full">
                <div class="px-5 pt-4 space-y-5">
                    <div>
                        <div class="flex space-x-1">
                            <x-input-label for="name" :value="__('Name')" />

                            <span class="text-rose-500">*</span>
                        </div>

                        <x-text-input wire:model="name" id="name" class="block !rounded-lg w-full mt-1 sm:text-sm"
                            type="text" name="name" autofocus autocomplete="name" />

                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div>
                        <div class="flex space-x-1">
                            <x-input-label for="parent_id" :value="__('Parent')" />
                        </div>

                        <select wire:model='parent_id' id="parent_id" autofocus
                            class="flex w-full mt-1 sm:mt-1.5 sm:text-sm rounded-lg shadow-sm border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600">
                            <option value="">Select a parent category</option>

                            @foreach ($this->parent_categories as $parent)
                                <option value="{{ $parent->id }}">
                                    {{ $parent->name }}
                                </option>
                            @endforeach
                        </select>

                        <x-input-error :messages="$errors->get('parent_id')" class="mt-2" />
                    </div>
                </div>

                <div class="flex justify-end p-5">
                    <div class="space-x-1 text-sm text-white">
                        <flux:button variant="outline" class="!px-5"
                            x-on:click="categoryFormModalOpen = false; clearForm()">
                            Cancel
                        </flux:button>

                        <flux:button variant="indigo" class="!px-5" type="button" wire:click='submit'>
                            Submit
                        </flux:button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
