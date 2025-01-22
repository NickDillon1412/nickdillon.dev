<div x-cloak x-data="{ tagFormModalOpen: $wire.entangle('modal_open').live }" x-on:keydown.escape.window="tagFormModalOpen = false" class="relative w-auto h-auto">
    <button x-on:click="tagFormModalOpen = true" type="button"
        class="dark:bg-slate-900 m-0.5 p-0.5 duration-100 ease-in-out hover:bg-slate-200 dark:hover:bg-slate-700 rounded-md">
        <x-heroicon-o-plus class="w-5 h-5 text-slate-600 dark:text-slate-500" />
    </button>

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
            x-on:click.outside="tagFormModalOpen = false" x-on:keydown.escape.window="tagFormModalOpen = false"
            x-trap.inert.noscroll="tagFormModalOpen">
            <div class="px-5 py-2.5 border-b border-slate-200 dark:border-slate-700">
                <div class="flex items-center justify-between">
                    <div class="text-lg font-semibold">
                        {{ $tag ? 'Edit' : 'Create' }} Tag
                    </div>

                    <flux:button icon="x-mark" x-on:click="tagFormModalOpen = false"
                        class="!h-8 !w-8 !-mr-2 !border-none hover:!bg-slate-100 dark:hover:!bg-slate-700 !shadow-none" />
                </div>
            </div>

            <div class="space-y-5">
                <div class="px-5 pt-5">
                    <div class="flex space-x-1">
                        <x-input-label for="tag-name" :value="__('Name')" />

                        <span class="text-rose-500">*</span>
                    </div>

                    <x-text-input wire:model="name" id="tag-name" class="block w-full mt-2 text-sm" type="text"
                        name="tag-name" autocomplete="name" />

                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div class="flex justify-end px-5 pb-5">
                    <div class="space-x-1 text-sm text-white">
                        <flux:button variant="outline" class="!px-5" x-on:click="tagFormModalOpen = false">
                            Cancel
                        </flux:button>

                        <flux:button variant="indigo" class="!px-5" type="button" wire:click='submit'
                            x-on:click="$dispatch('tag-saved')">
                            Submit
                        </flux:button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
