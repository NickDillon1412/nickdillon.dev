@use('App\Enums\PureFinance\AccountType', 'AccountType')

<div x-cloak x-on:account-saved="accountFormModalOpen = false">
    <div class="fixed inset-0 z-[99] transition-opacity bg-slate-900 bg-opacity-40 dark:bg-opacity-60 backdrop-blur-sm"
        x-show="accountFormModalOpen" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-out duration-100" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" aria-hidden="true" style="display: none;">
    </div>

    <div id="accountFormModalOpen-modal"
        class="fixed inset-0 z-[99] flex items-center justify-center px-4 my-4 overflow-hidden sm:px-6" role="dialog"
        aria-modal="true" x-show="accountFormModalOpen" x-transition:enter="transition ease-in-out duration-200"
        x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in-out duration-200" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-4" style="display: none;">
        <div class="w-full max-w-lg max-h-full overflow-auto bg-white border rounded-lg shadow-lg dark:bg-slate-800 text-slate-800 dark:text-slate-100 border-slate-200 dark:border-slate-700"
            x-on:click.outside="accountFormModalOpen = false" x-on:keydown.escape.window="accountFormModalOpen = false"
            x-trap.inert.noscroll="accountFormModalOpen">
            <div class="px-5 py-2.5 border-b border-slate-200 dark:border-slate-700">
                <div class="flex items-center justify-between">
                    <div class="text-lg font-semibold">
                        {{ $account ? 'Edit' : 'Create' }} Account
                    </div>

                    <flux:button icon="x-mark" x-on:click="accountFormModalOpen = false"
                        class="!h-8 !w-8 !-mr-2 !border-none hover:!bg-slate-100 dark:hover:!bg-slate-700 !shadow-none" />
                </div>
            </div>

            <form class="p-5 space-y-5" wire:submit='submit' x-on:submit="$dispatch('account-updated')">
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

                    <div class="text-left">
                        <label class="font-medium sm:text-sm" for="type">
                            Account Type

                            <span class="text-rose-500">*</span>

                            <select wire:model='type' id="type" required autofocus
                                class="flex w-full mt-1.5 sm:text-sm rounded-lg shadow-sm border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600">
                                <option value="">-- Select a type --</option>

                                @foreach (AccountType::cases() as $account_type)
                                    <option value="{{ $account_type->value }}">
                                        {{ $account_type->label() }}
                                    </option>
                                @endforeach
                            </select>
                        </label>

                        <x-input-error :messages="$errors->get('type')" class="mt-2" />
                    </div>

                    @if (!$account)
                        <div>
                            <div class="flex space-x-1">
                                <x-input-label for="balance" :value="__('Balance')" />
                            </div>

                            <x-text-input wire:model="balance" id="balance"
                                class="block !rounded-lg w-full mt-1 sm:mt-2 sm:text-sm" type="number" name="balance"
                                autofocus autocomplete="balance" placeholder="100.00" step="0.01" />

                            <x-input-error :messages="$errors->get('balance')" class="mt-2" />
                        </div>
                    @endif
                </div>

                <div class="flex justify-end">
                    <div class="space-x-1 text-sm text-white">
                        <flux:button variant="outline" class="!px-5" x-on:click="accountFormModalOpen = false">
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
