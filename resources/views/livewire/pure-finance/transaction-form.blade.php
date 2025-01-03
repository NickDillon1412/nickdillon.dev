@use('App\Enums\PureFinance\AccountType', 'AccountType')

<div class="w-full max-w-4xl p-4 mx-auto space-y-5 overflow-y-hidden sm:py-8 sm:px-6 lg:px-8">
    <h1 class="text-2xl font-bold text-slate-800 md:text-3xl dark:text-slate-100">
        {{ $transaction ? 'Edit' : 'New' }} Transaction
    </h1>

    <form
        class="p-5 space-y-5 bg-white border rounded-lg shadow-sm dark:bg-slate-800 dark:border-slate-600 border-slate-200"
        wire:submit='submit'>
        <div class="space-y-3">
            <div>
                <div class="flex space-x-1">
                    <x-input-label for="name" :value="__('Name')" />

                    <span class="text-rose-500">*</span>
                </div>

                <x-text-input wire:model="name" id="name" class="block w-full mt-1 text-sm" type="text"
                    name="name" required autocomplete="name" />

                <x-input-error :messages="$errors->get('name')" class="mt-2" />
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
