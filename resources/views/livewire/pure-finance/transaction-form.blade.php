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
                @if (!$transaction)
                    <div>
                        <div class="flex space-x-1">
                            <x-input-label for="account_id" :value="__('Account')" />

                            <span class="text-rose-500">*</span>
                        </div>

                        <select wire:model='account_id' id="account_id" required
                            class="flex w-full mt-1 text-sm rounded-lg shadow-sm border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600">
                            <option value="">Select an account</option>

                            @foreach ($accounts as $key => $value)
                                <option value="{{ $key }}">
                                    {{ $value }}
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

                    <select wire:model='type' id="type" required
                        class="flex w-full mt-1 text-sm rounded-lg shadow-sm border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600">
                        <option value="">Select a type</option>

                        @foreach (TransactionType::cases() as $transaction_type)
                            <option value="{{ $transaction_type->value }}">
                                {{ $transaction_type->label() }}
                            </option>
                        @endforeach
                    </select>

                    <x-input-error :messages="$errors->get('type')" class="mt-2" />
                </div>

                <div>
                    <div class="flex space-x-1">
                        <x-input-label for="category_id" :value="__('Category')" />

                        <span class="text-rose-500">*</span>
                    </div>

                    <select wire:model='category_id' id="category_id" required
                        class="flex w-full mt-1 text-sm rounded-lg shadow-sm border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600">
                        <option value="">Select a category</option>

                        @foreach ($categories as $key => $value)
                            <option value="{{ $key }}">
                                {{ $value }}
                            </option>
                        @endforeach
                    </select>

                    <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                </div>

                <div>
                    <x-pure-finance.tags-multi-select :$tags :transaction="$transaction ?? null" />

                    <x-input-error :messages="$errors->get('tags')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="notes" :value="__('Notes')" />

                    <textarea name="notes" id="notes" wire:model="notes" rows="5" autocomplete="notes"
                        class="w-full rounded-lg mt-2 -mb-1.5 shadow-sm border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 text-sm resize-none"></textarea>

                    <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                </div>

                <div>
                    <label class="space-y-2" for="status">
                        <p class="block text-sm font-medium text-slate-700 dark:text-slate-300">
                            Status
                        </p>

                        <div class="flex items-center cursor-pointer w-fit">
                            <input type="checkbox" id="status" name="status" wire:model="status"
                                class="sr-only peer" />

                            <div
                                class="relative w-11 h-6 bg-amber-600 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-slate-600 peer-checked:bg-emerald-500">
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
                        <x-input-label for="description" :value="__('Description')" />

                        <span class="text-rose-500">*</span>
                    </div>

                    <x-text-input wire:model="description" id="description"
                        class="block !rounded-lg w-full mt-1 text-sm" type="text" name="description" required
                        autocomplete="description" />

                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                </div>

                <div>
                    <div class="flex space-x-1">
                        <x-input-label for="amount" :value="__('Amount')" />

                        <span class="text-rose-500">*</span>
                    </div>

                    <x-text-input wire:model="amount" id="amount" class="block !rounded-lg w-full mt-1 text-sm"
                        type="number" name="amount" required autocomplete="amount" placeholder="100.00"
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

                <div>
                    <label class="space-y-2" for="is_recurring">
                        <p class="block text-sm font-medium text-slate-700 dark:text-slate-300">
                            Recurring?
                        </p>

                        <div class="flex items-center cursor-pointer w-fit">
                            <input type="checkbox" id="is_recurring" name="is_recurring" x-model="$wire.is_recurring"
                                class="sr-only peer" />

                            <div
                                class="relative w-11 h-6 bg-amber-600 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-slate-600 peer-checked:bg-indigo-600">
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

                        <select wire:model='frequency' id="frequency"
                            class="flex w-full mt-1 text-sm rounded-lg shadow-sm border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600">
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
                        <x-input-label for="recurring_end" :value="__('End Date')" />

                        <x-datepicker field="recurring_end" />

                        <x-input-error :messages="$errors->get('recurring_end')" class="mt-2" />
                    </div>
                </div>
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
                <flux:button href="{{ route('pure-finance.index') }}" variant="outline" class="!px-5">
                    Cancel
                </flux:button>

                <flux:button variant="indigo" class="!px-5" type="submit">
                    Submit
                </flux:button>
            </div>
        </div>
    </form>
</div>
