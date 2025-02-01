<div x-cloak x-on:planned-expense-saved="plannedSpendingFormModalOpen = false">
    <div class="fixed inset-0 z-30 transition-opacity bg-slate-900 bg-opacity-40 dark:bg-opacity-60 backdrop-blur-sm"
        x-show="plannedSpendingFormModalOpen" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-out duration-100" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" aria-hidden="true" style="display: none;">
    </div>

    <div id="plannedSpendingFormModalOpen-modal"
        class="fixed inset-0 z-30 flex items-center justify-center px-4 my-4 sm:px-6" role="dialog" aria-modal="true"
        x-show="plannedSpendingFormModalOpen" x-transition:enter="transition ease-in-out duration-200"
        x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in-out duration-200" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-4" style="display: none;">
        <div class="w-full max-w-lg max-h-full bg-white border rounded-lg shadow-lg dark:bg-slate-800 text-slate-800 dark:text-slate-100 border-slate-200 dark:border-slate-700"
            x-on:click.outside="plannedSpendingFormModalOpen = false"
            x-on:keydown.escape.window="plannedSpendingFormModalOpen = false"
            x-trap.inert.noscroll="plannedSpendingFormModalOpen">
            <div class="px-5 py-2.5 border-b border-slate-200 dark:border-slate-700">
                <div class="flex items-center justify-between">
                    <div class="text-lg font-semibold">
                        {{ $expense ? 'Edit' : 'Create' }} Expense
                    </div>

                    <flux:button icon="x-mark" x-on:click="plannedSpendingFormModalOpen = false"
                        class="!h-8 !w-8 !-mr-2 !border-none hover:!bg-slate-100 dark:hover:!bg-slate-700 !shadow-none" />
                </div>
            </div>

            <form class="p-5 space-y-5" wire:submit='submit' x-on:submit="$dispatch('planned-expense-updated')">
                <div class="space-y-5">
                    <div>
                        <div class="flex space-x-1">
                            <x-input-label for="name" :value="__('Name')" />

                            <span class="text-rose-500">*</span>
                        </div>

                        <x-text-input wire:model="name" id="name" class="block w-full mt-1 !rounded-lg sm:text-sm"
                            type="text" name="name" required autofocus autocomplete="name" />

                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div>
                        <x-pure-finance.categories />

                        <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                    </div>

                    <div>
                        <div class="flex space-x-1">
                            <x-input-label for="monthly_amount" :value="__('Monthly Amount')" />

                            <span class="text-rose-500">*</span>
                        </div>

                        <x-text-input wire:model="monthly_amount" id="monthly_amount"
                            class="block !rounded-lg w-full mt-1 sm:text-sm" type="number" name="monthly_amount"
                            required autofocus autocomplete="monthly_amount" placeholder="100.00" step="0.01" />

                        <x-input-error :messages="$errors->get('monthly_amount')" class="mt-2" />
                    </div>
                </div>

                <div class="flex justify-end">
                    <div class="space-x-1 text-sm text-white">
                        <flux:button variant="outline" class="!px-5" x-on:click="plannedSpendingFormModalOpen = false">
                            Cancel
                        </flux:button>

                        <flux:button variant="indigo" class="!px-5" type="submit">
                            Submit
                        </flux:button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
