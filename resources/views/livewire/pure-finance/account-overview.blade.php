@use('App\Enums\PureFinance\AccountType', 'AccountType')

<div x-data="{ accountFormModalOpen: false }" class="w-full p-4 mx-auto overflow-y-hidden sm:py-8 sm:px-6 lg:px-8 max-w-screen-2xl">
    <div>
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-slate-800 md:text-3xl dark:text-slate-100">
                Account Details
            </h1>

            <div class="flex flex-col justify-center sm:flex-row sm:items-center">
                <div>
                    <flux:button variant="indigo" icon="plus" class="w-full sm:w-auto"
                        x-on:click="accountFormModalOpen = true" aria-controls="accountFormModalOpen-modal">
                        Edit Account
                    </flux:button>

                    <livewire:pure-finance.account-form :$account :key="$account->id" />
                </div>
            </div>
        </div>

        <livewire:pure-finance.transactions-table :$account />
    </div>
</div>
