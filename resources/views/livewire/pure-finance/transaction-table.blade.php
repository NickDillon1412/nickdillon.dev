<div class="flex flex-col gap-3 pt-5">
    <div class="flex items-center justify-between w-full">
        <h1 class="text-2xl font-semibold text-slate-800">
            Transactions
        </h1>

        <flux:button variant="indigo" icon="plus" size="sm" class="w-full sm:w-auto">
            New Transaction
        </flux:button>
    </div>

    <div
        class="bg-white border divide-y rounded-lg shadow-sm border-slate-200 dark:bg-slate-800 divide-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 dark:divide-slate-600">
        <div class="flex justify-between px-5 py-3">
            <x-pure-finance.status-tabs :$transactions :$cleared_total :$pending_total />

            <div class="flex items-center justify-between space-x-2">
                <div class="relative w-40 sm:w-64">
                    <label for="search" class="sr-only">
                        Search
                    </label>

                    <input type="text" wire:model.live.debounce.300ms='search' name="search" id="search"
                        class="block w-full px-3 py-1.5 text-sm rounded-md shadow-sm border-slate-300 ps-9 focus:z-10 focus:border-indigo-500 focus:ring-indigo-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-slate-700 dark:text-slate-400 dark:placeholder-slate-500 dark:focus:ring-indigo-600"
                        placeholder="Search transactions..." />

                    <div class="absolute inset-y-0 flex items-center pointer-events-none start-0 ps-3">
                        <svg class="text-slate-400 size-4 dark:text-slate-500" xmlns="http://www.w3.org/2000/svg"
                            width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"></circle>
                            <path d="m21 21-4.3-4.3"></path>
                        </svg>
                    </div>

                    <button x-cloak x-show="$wire.search.length > 0" wire:click="$set('search', '')"
                        class="absolute inset-0 left-auto pr-2" type="submit" aria-label="Search">
                        <x-heroicon-s-x-mark
                            class="w-5 h-5 duration-200 ease-in-out text-slate-500 hover:text-slate-600 dark:hover:text-slate-400" />
                    </button>
                </div>

                <x-pure-finance.filters :account="$account ?: null" :$accounts :$categories />
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full divide-y table-auto divide-slate-200 dark:divide-slate-600">
                <thead class="bg-slate-100/75 dark:bg-slate-700">
                    <tr>
                        <th scope="col" class="py-3 pl-6 text-xs text-slate-600 dark:text-slate-200">
                            <x-sortable-column column="date" :$sort_col :$sort_asc>
                                Date
                            </x-sortable-column>
                        </th>

                        @unless ($account)
                            <th scope="col" class="py-3 pl-6 text-xs text-slate-600 dark:text-slate-200">
                                <x-sortable-column column="account" :$sort_col :$sort_asc>
                                    Account
                                </x-sortable-column>
                            </th>
                        @endunless

                        <th scope="col" class="py-3 pl-6 text-xs text-slate-600 dark:text-slate-200">
                            <x-sortable-column column="category" :$sort_col :$sort_asc>
                                Category
                            </x-sortable-column>
                        </th>

                        <th scope="col" class="py-3 pl-6 text-xs text-slate-600 dark:text-slate-200">
                            <x-sortable-column column="type" :$sort_col :$sort_asc>
                                Type
                            </x-sortable-column>
                        </th>

                        <th scope="col" class="py-3 pl-6 text-xs text-slate-600 dark:text-slate-200">
                            <x-sortable-column column="amount" :$sort_col :$sort_asc>
                                Amount
                            </x-sortable-column>
                        </th>

                        <th scope="col" class="py-3 pl-6 text-xs text-slate-600 dark:text-slate-200">
                            <x-sortable-column column="description" :$sort_col :$sort_asc>
                                Description
                            </x-sortable-column>
                        </th>

                        <th scope="col" class="py-3 pl-6 text-xs text-slate-600 dark:text-slate-200">
                            <x-sortable-column column="status" :$sort_col :$sort_asc>
                                Status
                            </x-sortable-column>
                        </th>

                        <th scope="col"
                            class="px-6 py-3 text-xs font-semibold uppercase text-slate-600 text-end dark:text-slate-200">
                            Actions
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-200 dark:divide-slate-600">
                    @forelse ($transactions as $transaction)
                        <tr class="even:bg-slate-50 even:dark:bg-slate-700">
                            <td class="py-4 pl-6 text-sm text-slate-800 whitespace-nowrap dark:text-slate-200">
                                {{ Carbon\Carbon::parse($transaction->date)->format('M j, Y') }}
                            </td>

                            @unless ($account)
                                <td
                                    class="py-3.5 pl-6 text-sm font-medium text-slate-800 whitespace-nowrap dark:text-slate-200">
                                    <a class="text-sm font-medium text-indigo-500 duration-200 ease-in-out hover:text-indigo-600 dark:hover:text-indigo-400"
                                        href="{{ route('pure-finance.account.overview', $transaction->account) }}"
                                        wire:navigate>
                                        {{ $transaction->account->name }}
                                    </a>
                                </td>
                            @endunless

                            <td class="py-3.5 pl-6 text-sm text-slate-800 whitespace-nowrap dark:text-slate-200">
                                {{ $transaction->category->name }}
                            </td>

                            <td class="py-3.5 pl-6 text-sm text-slate-800 whitespace-nowrap dark:text-slate-200">
                                {{ $transaction->type->label() }}
                            </td>

                            <td class="py-3.5 pl-6 text-sm text-slate-800 whitespace-nowrap dark:text-slate-200">
                                ${{ Number::format($transaction->amount, 2) }}
                            </td>

                            <td class="py-3.5 pl-6 text-sm text-slate-800 whitespace-nowrap dark:text-slate-200">
                                {{ $transaction->description }}
                            </td>

                            <td class="pl-6 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div @class([
                                        'border-emerald-500 text-emerald-500 dark:border-emerald-500 dark:text-emerald-500 bg-emerald-500/10 dark:bg-emerald-500/10' =>
                                            $transaction->status,
                                        'border-amber-500 text-amber-500 dark:border-amber-500 dark:text-amber-500 bg-amber-500/10 dark:bg-amber-500/10' => !$transaction->status,
                                        'inline-flex px-2 py-1 overflow-hidden text-xs font-medium border rounded-md w-fit',
                                    ])>
                                        {{ $transaction->status ? 'Cleared' : 'Pending' }}
                                    </div>
                                </div>
                            </td>

                            <td class="flex items-center justify-end py-3.5 pr-6 text-sm font-medium whitespace-nowrap">
                                <button type="button">
                                    <x-heroicon-o-pencil-square
                                        class="p-1 text-indigo-500 duration-100 ease-in-out rounded-md w-7 h-7 hover:bg-slate-200 dark:hover:bg-slate-600" />
                                </button>

                                <x-modal icon="information-circle" delete variant="danger"
                                    wire:submit="delete({{ $transaction->id }})">
                                    <x-slot:button>
                                        <x-heroicon-o-trash
                                            class="p-1 -mr-2 text-red-500 duration-100 ease-in-out rounded-md w-7 h-7 hover:bg-slate-200 dark:hover:bg-slate-600" />
                                    </x-slot:button>

                                    <x-slot:title>
                                        Delete Transaction
                                    </x-slot:title>

                                    <x-slot:body>
                                        Are you sure you want to delete this transaction?
                                    </x-slot:body>
                                </x-modal>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">
                                <p class="p-3 text-sm italic font-medium text-center">No transactions found...</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="pt-4">
        {{ $transactions->links() }}
    </div>
</div>
