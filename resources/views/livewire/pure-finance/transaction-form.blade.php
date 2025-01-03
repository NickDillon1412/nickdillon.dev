@use('App\Enums\PureFinance\TransactionType', 'TransactionType')

<div class="w-full max-w-4xl p-4 mx-auto space-y-5 overflow-y-hidden sm:py-8 sm:px-6 lg:px-8">
    <h1 class="text-2xl font-bold text-slate-800 md:text-3xl dark:text-slate-100">
        {{ $transaction ? 'Edit' : 'New' }} Transaction
    </h1>

    <form
        class="p-5 space-y-5 bg-white border rounded-lg shadow-sm dark:bg-slate-800 dark:border-slate-600 border-slate-200"
        wire:submit='submit'>
        <div class="space-y-4">
            @if (!$transaction)
                <div>
                    <div class="flex space-x-1">
                        <x-input-label for="account_id" :value="__('Account')" />

                        <span class="text-rose-500">*</span>
                    </div>

                    <select wire:model='account_id' id="account_id" required
                        class="flex w-full mt-1.5 text-sm rounded-md shadow-sm border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600">
                        <option value="">-- Select an account --</option>

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
                    <x-input-label for="description" :value="__('Description')" />

                    <span class="text-rose-500">*</span>
                </div>

                <x-text-input wire:model="description" id="description" class="block w-full mt-1 text-sm" type="text"
                    name="description" required autocomplete="description" />

                <x-input-error :messages="$errors->get('description')" class="mt-2" />
            </div>

            <div>
                <div class="flex space-x-1">
                    <x-input-label for="amount" :value="__('Amount')" />

                    <span class="text-rose-500">*</span>
                </div>

                <x-text-input wire:model="amount" id="amount" class="block w-full mt-1 text-sm" type="number"
                    name="amount" required autocomplete="amount" placeholder="100.00" step="0.01" />

                <x-input-error :messages="$errors->get('amount')" class="mt-2" />
            </div>

            <div>
                <div class="flex space-x-1">
                    <x-input-label for="type" :value="__('Type')" />

                    <span class="text-rose-500">*</span>
                </div>

                <select wire:model='type' id="type" required
                    class="flex w-full mt-1.5 text-sm rounded-md shadow-sm border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600">
                    <option value="">-- Select a type --</option>

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
                    class="flex w-full mt-1.5 text-sm rounded-md shadow-sm border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600">
                    <option value="">-- Select a category --</option>

                    @foreach ($categories as $key => $value)
                        <option value="{{ $key }}">
                            {{ $value }}
                        </option>
                    @endforeach
                </select>

                <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
            </div>

            <div>
                <div class="flex space-x-1">
                    <x-input-label for="date" :value="__('Date')" />

                    <span class="text-rose-500">*</span>
                </div>

                <x-text-input wire:model="date" id="date" class="block w-full mt-1 text-sm" type="date"
                    name="date" required autocomplete="date" />

                <x-input-error :messages="$errors->get('date')" class="mt-2" />
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
