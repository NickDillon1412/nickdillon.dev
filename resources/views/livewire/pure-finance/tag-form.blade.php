<div x-cloak x-data="{
    tagFormModalOpen: $wire.entangle('modal_open').live,
    title: '',
    clearForm() {
        $nextTick(() => {
            $wire.tag = null;
            $wire.name = '';
        });
    }
}" x-on:keydown.escape.window="tagFormModalOpen = false; clearForm()"
    x-on:open-tag-create-form.window="tagFormModalOpen = true; title = 'Create'"
    x-on:open-tag-edit-form.window="tagFormModalOpen = true; $wire.loadTag(); title = 'Edit'"
    x-on:tag-saved="tagFormModalOpen = false; clearForm()" class="relative w-auto h-auto">
    <div class="fixed inset-0 z-[99] transition-opacity bg-slate-900 bg-opacity-40 dark:bg-opacity-60 backdrop-blur-sm"
        x-show="tagFormModalOpen" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-out duration-100" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" aria-hidden="true" style="display: none;">
    </div>

    <div id="tagFormModalOpen-modal"
        class="fixed inset-0 z-[99] flex items-center justify-center px-4 my-4 overflow-hidden sm:px-6" role="dialog"
        aria-modal="true" x-show="tagFormModalOpen" x-transition:enter="transition ease-in-out duration-200"
        x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in-out duration-200" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-4" style="display: none;">
        <div class="w-full max-w-xl max-h-full overflow-auto bg-white border rounded-lg shadow-lg dark:bg-slate-800 text-slate-800 dark:text-slate-100 border-slate-200 dark:border-slate-700"
            x-on:click.outside="tagFormModalOpen = false; clearForm()"
            x-on:keydown.escape.window="tagFormModalOpen = false; clearForm()" x-trap.inert.noscroll="tagFormModalOpen">
            <div class="px-5 py-2.5 border-b border-slate-200 dark:border-slate-700">
                <div class="flex items-center justify-between">
                    <div class="text-lg font-semibold">
                        <span x-text="title"></span> Tag
                    </div>

                    <flux:button icon="x-mark" x-on:click="tagFormModalOpen = false; clearForm()"
                        class="!h-8 !w-8 !-mr-2 !border-none hover:!bg-slate-100 dark:hover:!bg-slate-700 !shadow-none" />
                </div>
            </div>

            <div x-cloak wire:loading.flex wire:target='loadTag' class="flex justify-center text-center py-[63px]">
                <x-large-loading-spinner />
            </div>

            <div x-cloak wire:loading.remove wire:target='loadTag' class="w-full">
                <div class="px-5 pt-4">
                    <div class="flex space-x-1">
                        <x-input-label for="name" :value="__('Name')" />

                        <span class="text-rose-500">*</span>
                    </div>

                    <x-text-input wire:model="name" id="name" class="block !rounded-lg w-full mt-1 text-sm"
                        type="text" name="name" autofocus autofocus autocomplete="name" />

                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div class="flex justify-end p-5">
                    <div class="space-x-1 text-sm text-white">
                        <flux:button variant="outline" class="!px-5"
                            x-on:click="tagFormModalOpen = false; clearForm()">
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
