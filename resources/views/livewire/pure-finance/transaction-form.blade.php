@use('App\Enums\PureFinance\TransactionType', 'TransactionType')
@use('App\Enums\PureFinance\RecurringFrequency', 'RecurringFrequency')

<div class="w-full max-w-4xl p-4 mx-auto space-y-5 overflow-y-hidden sm:py-8 sm:px-6 lg:px-8">
    <h1 class="text-2xl font-bold text-slate-800 md:text-3xl dark:text-slate-100">
        {{ $transaction ? 'Edit' : 'New' }} Transaction
    </h1>

    <form wire:submit='submit' class="space-y-4">
        <div
            class="grid items-start grid-cols-1 gap-5 p-6 bg-white border shadow-xs rounded-xl dark:bg-slate-800 dark:border-slate-600 border-slate-200 sm:grid-cols-2">
            <div class="space-y-5">
                @if (!$account && !$transaction)
                    <div>
                        <div class="flex space-x-1">
                            <x-input-label for="account_id" :value="__('Account')" />

                            <span class="text-rose-500">*</span>
                        </div>

                        <select wire:model.live='account_id' id="account_id" required autofocus
                            class="flex w-full mt-1 rounded-lg shadow-sm sm:text-sm border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600">
                            <option value="">Select an account</option>

                            @foreach ($accounts as $account)
                                <option value="{{ $account->id }}">
                                    {{ $account->name }}
                                </option>
                            @endforeach
                        </select>

                        <x-input-error :messages="$errors->get('account_id')" class="mt-2" />
                    </div>
                @endif

                <div>
                    <div class="flex space-x-1">
                        <x-input-label for="type" :value="__('Type')" />

                        <span class="text-rose-500">*</span>
                    </div>

                    <select x-model="$wire.type" id="type" required autofocus
                        class="flex w-full mt-1 rounded-lg shadow-sm sm:text-sm border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600">
                        <option value="">Select a type</option>

                        @foreach ($transaction_types as $transaction_type)
                            <option value="{{ $transaction_type->value }}">
                                {{ $transaction_type->label() }}
                            </option>
                        @endforeach
                    </select>

                    <x-input-error :messages="$errors->get('type')" class="mt-2" />
                </div>

                <div x-cloak x-show="$wire.type === 'transfer'">
                    <div class="flex space-x-1">
                        <x-input-label for="transfer_to" :value="__('Transfer To')" />

                        <span class="text-rose-500">*</span>
                    </div>

                    <select wire:model="transfer_to" id="transfer_to" required autofocus
                        class="flex w-full mt-1 rounded-lg shadow-sm sm:text-sm border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600">
                        <option value="">Select an account</option>

                        @foreach ($accounts as $account)
                            @if ($account->id !== $account_id)
                                <option value="{{ $account->id }}">
                                    {{ $account->name }}
                                </option>
                            @endif
                        @endforeach
                    </select>

                    <x-input-error :messages="$errors->get('type')" class="mt-2" />
                </div>

                <div>
                    <x-pure-finance.categories />

                    <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                </div>

                <div>
                    <x-pure-finance.tags />

                    <x-input-error :messages="$errors->get('tags')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="notes" :value="__('Notes')" />

                    <textarea name="notes" id="notes" wire:model="notes" rows="5" autocomplete="notes" autofocus
                        class="w-full rounded-lg mt-1 sm:mt-2 -mb-1.5 shadow-sm border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 sm:text-sm resize-none"></textarea>

                    <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                </div>

                <div>
                    <label class="space-y-1 sm:space-y-2" for="status">
                        <p class="block font-medium sm:text-sm text-slate-700 dark:text-slate-300">
                            Status
                        </p>

                        <div class="flex items-center cursor-pointer w-fit">
                            <input type="checkbox" id="status" name="status" wire:model="status" autofocus
                                class="sr-only peer" />

                            <div
                                class="relative z-0 w-11 h-6 bg-amber-500 dark:bg-amber-600 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-slate-600 peer-checked:bg-emerald-500 dark:peer-checked:bg-emerald-600">
                            </div>

                            <span class="text-sm italic ms-2.5 text-slate-500 dark:text-slate-400"
                                x-text="$wire.status ? 'Cleared' : 'Pending'"></span>
                        </div>
                    </label>
                </div>
            </div>

            <div class="space-y-5">
                <div>
                    <div class="flex space-x-1">
                        <x-input-label for="payee" :value="__('Payee')" />

                        <span class="text-rose-500">*</span>
                    </div>

                    <x-text-input wire:model="payee" id="payee" class="block !rounded-lg w-full mt-1 sm:text-sm"
                        type="text" name="payee" required autofocus autocomplete="payee" />

                    <x-input-error :messages="$errors->get('payee')" class="mt-2" />
                </div>

                <div>
                    <div class="flex space-x-1">
                        <x-input-label for="amount" :value="__('Amount')" />

                        <span class="text-rose-500">*</span>
                    </div>

                    <x-text-input wire:model="amount" id="amount" class="block !rounded-lg w-full mt-1 sm:text-sm"
                        type="number" name="amount" required autofocus autocomplete="amount" placeholder="100.00"
                        step="0.01" />

                    <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                </div>

                <div>
                    <div class="flex space-x-1">
                        <x-input-label for="date" :value="__('Date')" />

                        <span class="text-rose-500">*</span>
                    </div>

                    <x-datepicker field="date" />

                    <x-input-error :messages="$errors->get('date')" class="mt-2" />
                </div>

                @if (!$transaction?->parent)
                    <div>
                        <label class="space-y-1 sm:space-y-2" for="is_recurring">
                            <p class="block font-medium sm:text-sm text-slate-700 dark:text-slate-300">
                                Recurring?
                            </p>

                            <div class="flex items-center cursor-pointer w-fit">
                                <input type="checkbox" id="is_recurring" name="is_recurring"
                                    x-model="$wire.is_recurring" class="sr-only peer" autofocus />

                                <div
                                    class="relative w-11 h-6 bg-amber-500 dark:bg-amber-600 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-slate-600 peer-checked:bg-indigo-500 dark:peer-checked:bg-indigo-600">
                                </div>

                                <span class="text-sm italic ms-2.5 text-slate-500 dark:text-slate-400"
                                    x-text="$wire.is_recurring ? 'Yes' : 'No'"></span>
                            </div>
                        </label>
                    </div>

                    <div x-cloak x-show="$wire.is_recurring" x-collapse class="space-y-5">
                        <div>
                            <div class="flex space-x-1">
                                <x-input-label for="frequency" :value="__('Frequency')" />

                                <span class="text-rose-500">*</span>
                            </div>

                            <select wire:model='frequency' id="frequency" autofocus
                                class="flex w-full mt-1 rounded-lg shadow-sm sm:text-sm border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600">
                                <option value="">Select a frequency</option>

                                @foreach (RecurringFrequency::cases() as $frequency)
                                    <option value="{{ $frequency->value }}">
                                        Every {{ $frequency->label() }}
                                    </option>
                                @endforeach
                            </select>

                            <x-input-error :messages="$errors->get('frequency')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="recurring_end" :value="__('End Date')" class="sm:mb-2" />

                            <x-datepicker field="recurring_end" />

                            <x-input-error :messages="$errors->get('recurring_end')" class="mt-2" />
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="bg-white border shadow-xs rounded-xl dark:bg-slate-800 dark:border-slate-600 border-slate-200">
            <div class="px-6 py-3.5 border-b border-slate-200 dark:border-slate-700">
                <h1 class="text-lg font-semibold text-slate-800 dark:text-slate-200">
                    Attachments
                </h1>
            </div>

            <div class="p-6">
                <livewire:file-uploader :files="$transaction?->attachments" />
            </div>
        </div>

        <div class="flex justify-end">
            <div class="space-x-1 text-sm text-white">
                <flux:button href="{{ route('pure-finance.index') }}" wire:navigate variant="outline" class="!px-5">
                    Cancel
                </flux:button>

                <flux:button variant="indigo" class="!px-5" type="submit">
                    Submit
                </flux:button>
            </div>
        </div>
    </form>
</div>
