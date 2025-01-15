<div x-data="{ accountFormModalOpen: false }" class="w-full max-w-3xl pt-5 mx-auto overflow-y-hidden">
    <div class="flex flex-col justify-center sm:flex-row sm:items-center">
        <div>
            <flux:button variant="indigo" icon="plus" class="w-full sm:w-auto" x-on:click="accountFormModalOpen = true"
                aria-controls="accountFormModalOpen-modal">
                New Account
            </flux:button>

            <livewire:pure-finance.account-form />
        </div>
    </div>

    <div class="flex flex-col w-full pt-5">
        <div class="space-y-3">
            @forelse ($accounts as $account)
                <a href="{{ route('pure-finance.account.overview', $account) }}" wire:navigate class="bg-white block dark:bg-slate-800 rounded-xl border shadow-sm border-slate-200 dark:border-slate-600 px-3 py-2.5 w-full dark:text-slate-200">
                    <p class="font-medium">{{ $account->name }}</p>

                    <div class="flex items-center text-sm justify-between">
                        <p>Balance</p>

                        <p>${{ Number::format($account->balance, 2) }}</p>
                    </div>
                </a>
            @empty
                <div
                    class="p-3 text-sm italic font-medium text-center text-slate-800 whitespace-nowrap dark:text-slate-200">
                    No accounts found...
                </div>
            @endforelse
        </div>

        <div class="hidden sm:inline-block min-w-full align-middle">
            <div class="overflow-x-auto border rounded-lg shadow-xs dark:border-slate-700">
                <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700">
                    <thead class="bg-slate-100/75 dark:bg-slate-700">
                        <tr>
                            <th scope="col"
                                class="px-2 py-3 pl-5 text-xs font-medium uppercase text-slate-600 text-start dark:text-slate-200">
                                Name
                            </th>

                            <th scope="col"
                                class="px-2 py-3 text-xs font-medium uppercase text-slate-600 text-start dark:text-slate-200">
                                Type
                            </th>

                            <th scope="col"
                                class="px-2 py-3 text-xs font-medium uppercase text-slate-600 text-start dark:text-slate-200">
                                Balance
                            </th>

                            <th scope="col"
                                class="py-3 pr-5 text-xs font-medium uppercase text-slate-600 text-end dark:text-slate-200">
                                Actions
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y bg-slate-50 dark:bg-slate-900 divide-slate-200 dark:divide-slate-700">
                        @forelse ($accounts as $account)
                            <livewire:pure-finance.account-row :$account wire:key="'account-'.{{ $account->id }}" />
                        @empty
                            <tr>
                                <td colspan="4"
                                    class="p-3 text-sm italic font-medium text-center text-slate-800 whitespace-nowrap dark:text-slate-200">
                                    No accounts found...
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
