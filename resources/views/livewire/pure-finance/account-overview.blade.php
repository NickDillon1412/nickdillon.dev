@use('App\Enums\PureFinance\AccountType', 'AccountType')

<div x-data="{ accountFormModalOpen: false }" x-on:account-updated="$wire.$refresh"
    class="w-full p-4 mx-auto overflow-y-hidden sm:py-8 sm:px-6 lg:px-8 max-w-screen-2xl">
    <div>
        <h1 class="text-2xl font-bold text-slate-800 md:text-3xl dark:text-slate-100">
            Account Overview
        </h1>

        <div class="flex flex-col sm:gap-4 sm:grid-cols-8 sm:grid">
            <div
                class="mt-3 mb-4 bg-white border divide-y shadow-sm sm:col-span-2 sm:mb-0 rounded-xl border-slate-200 dark:bg-slate-800 divide-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 dark:divide-slate-600 h-fit">
                <div class="flex items-center justify-between gap-2 px-4 py-2.5">
                    <h1 class="text-xl font-semibold text-slate-800 dark:text-slate-200">
                        Details
                    </h1>

                    <div>
                        <flux:button x-on:click="accountFormModalOpen = true" aria-controls="accountFormModalOpen-modal"
                            variant="indigo" size="sm" class="!h-7">
                            Edit
                        </flux:button>

                        <livewire:pure-finance.account-form :$account :key="$account->id" />
                    </div>
                </div>

                <div class="p-4 space-y-2.5">
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

                        ${{ Number::format($account->balance ?? 0) }}
                    </p>
                </div>
            </div>

            <div class="sm:col-span-6">
                <livewire:pure-finance.transaction-table :$account />
            </div>
        </div>
    </div>
</div>
