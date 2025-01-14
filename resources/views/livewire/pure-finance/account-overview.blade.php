@use('App\Enums\PureFinance\AccountType', 'AccountType')

<div x-data="{ accountFormModalOpen: false }" x-on:account-updated="$wire.$refresh"
    class="w-full p-4 mx-auto overflow-y-hidden sm:py-8 sm:px-6 lg:px-8 max-w-screen-2xl">
    <div>
        <h1 class="text-2xl font-bold text-slate-800 md:text-3xl dark:text-slate-100">
            Account Overview
        </h1>

        <div
            class="px-6 py-5 mt-4 space-y-2 bg-white border shadow-sm rounded-xl border-slate-200 dark:border-slate-700 dark:bg-slate-800 w-fit text-slate-800 dark:text-slate-200">
            <div class="flex items-center justify-between space-x-8">
                <h1 class="text-lg font-bold">
                    Account Details
                </h1>

                <div>
                    <flux:button x-on:click="accountFormModalOpen = true" aria-controls="accountFormModalOpen-modal"
                        variant="indigo" size="sm" class="!h-7">
                        Edit
                    </flux:button>

                    <livewire:pure-finance.account-form :$account :key="$account->id" />
                </div>
            </div>

            <p>
                <span class="font-semibold">
                    Name:
                </span>

                {{ $account->name }}
            </p>

            <p>
                <span class="font-semibold">
                    Type:
                </span>

                {{ $account->type->label() }}
            </p>

            <p>
                <span class="font-semibold">
                    Balance:
                </span>

                ${{ Number::format($account->balance) }}
            </p>
        </div>

        <livewire:pure-finance.transaction-table :$account />
    </div>
</div>
