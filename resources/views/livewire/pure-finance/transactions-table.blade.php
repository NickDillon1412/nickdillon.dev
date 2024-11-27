<div class="flex flex-col pt-5" x-data="{
    tabs: ['all', 'cleared', 'pending'],
    activeTab: $wire.entangle('status'),
    transactionCounts: {
        all: '{{ $transactions->count() }}',
        cleared: '{{ $transactions->where('status', true)->count() }}',
        pending: '{{ $transactions->where('status', false)->count() }}'
    }
}">
    <div
        class="bg-white border divide-y rounded-lg shadow-sm border-slate-200 dark:bg-slate-800 divide-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 dark:divide-slate-700">
        <div class="flex items-center justify-between px-5 py-3">
            <div class="flex items-center gap-3">
                @if ($account)
                    <h1 class="text-xl font-semibold">
                        Transactions
                    </h1>
                @endif

                <div class="relative w-40 -my-2 sm:w-64">
                    <label for="hs-table-search" class="sr-only">
                        Search
                    </label>

                    <input type="text" wire:model.live.debounce.300ms='search' name="hs-table-search"
                        id="hs-table-search"
                        class="block w-full px-3 py-[7px] text-sm rounded-lg shadow-sm border-slate-200 ps-9 focus:z-10 focus:border-indigo-500 focus:ring-indigo-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-slate-700 dark:text-slate-400 dark:placeholder-slate-500 dark:focus:ring-indigo-600"
                        placeholder="Search..." />

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
            </div>

            <div x-cloak class="flex justify-center">
                <div
                    class="relative p-[3px] border rounded-lg bg-slate-200/60 dark:bg-slate-800/60 border-slate-200 dark:border-slate-700 w-fit">
                    <div class="absolute w-24 h-[28px] transition-all duration-300 bg-white dark:bg-slate-700 rounded-md shadow top-[3px] left-[3px]"
                        :style="'transform: translateX(' + (activeTab === 'all' ? '0%' : activeTab === 'cleared' ?
                            '100%' :
                            activeTab === 'pending' ? '200%' : '300%') + ')'">
                    </div>

                    <div class="relative z-10 flex gap-0">
                        <template x-for="(tab, index) in tabs" :key="index">
                            <button x-on:click="$wire.set('status', tab)"
                                class="w-24 h-[28px] text-sm font-medium transition rounded-md text-slate-600 dark:text-slate-300 hover:text-slate-800 dark:hover:text-slate-100 focus:outline-none duration-200 ease-in-out flex items-center text-center justify-center"
                                :class="activeTab === tab ? 'text-slate-800 dark:text-white' : ''">
                                <span x-text="tab.charAt(0).toUpperCase() + tab.slice(1)"></span>

                                <span class="ml-1.5 text-slate-400" x-text="transactionCounts[tab]"></span>
                            </button>
                        </template>
                    </div>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full divide-y table-auto divide-slate-200 dark:divide-slate-700">
                <thead class="bg-slate-100/75 dark:bg-slate-700">
                    <tr>
                        {{-- <th scope="col" class="px-4 py-3 pe-0">
                                <div class="flex items-center h-4">
                                    <input id="hs-table-search-checkbox-all" type="checkbox"
                                        class="text-indigo-600 rounded border-slate-200 focus:ring-indigo-500 dark:bg-slate-700 dark:border-slate-500 dark:checked:bg-indigo-500 dark:checked:border-indigo-500 dark:focus:ring-offset-slate-800" />
                                    <label for="hs-table-search-checkbox-all" class="sr-only">
                                        Checkbox
                                    </label>
                                </div>
                            </th> --}}

                        @unless ($account)
                            <th scope="col"
                                class="px-6 py-3 text-xs font-medium uppercase text-slate-600 text-start dark:text-slate-200">
                                Account
                            </th>
                        @endunless

                        <th scope="col"
                            class="px-6 py-3 text-xs font-medium uppercase text-slate-600 text-start dark:text-slate-200">
                            Category
                        </th>

                        <th scope="col"
                            class="px-6 py-3 text-xs font-medium uppercase text-slate-600 text-start dark:text-slate-200">
                            Amount
                        </th>

                        <th scope="col"
                            class="px-6 py-3 text-xs font-medium uppercase text-slate-600 text-start dark:text-slate-200">
                            Description
                        </th>

                        <th scope="col"
                            class="px-6 py-3 text-xs font-medium uppercase text-slate-600 text-start dark:text-slate-200">
                            Date
                        </th>

                        <th scope="col"
                            class="px-6 py-3 text-xs font-medium uppercase text-slate-600 text-start dark:text-slate-200">
                            Status
                        </th>

                        <th scope="col"
                            class="px-6 py-3 text-xs font-medium uppercase text-slate-600 text-end dark:text-slate-200">
                            Actions
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                    @forelse ($transactions as $transaction)
                        <tr>
                            {{-- <td class="py-3 ps-4">
                                    <div class="flex items-center h-5">
                                        <input id="hs-table-search-checkbox-1" type="checkbox"
                                            class="text-indigo-600 rounded border-slate-200 focus:ring-indigo-500 dark:bg-slate-800 dark:border-slate-700 dark:checked:bg-indigo-500 dark:checked:border-indigo-500 dark:focus:ring-offset-slate-800" />
                                        <label for="hs-table-search-checkbox-1" class="sr-only">
                                            Checkbox
                                        </label>
                                    </div>
                                </td> --}}

                            @unless ($account)
                                <td
                                    class="px-6 py-4 text-sm font-medium text-slate-800 whitespace-nowrap dark:text-slate-200">
                                    <a class="text-sm font-medium text-indigo-500 duration-200 ease-in-out hover:text-indigo-600 dark:hover:text-indigo-400"
                                        href="{{ route('pure-finance.account.overview', $transaction->account) }}"
                                        wire:navigate>
                                        {{ $transaction->account->name }}
                                    </a>
                                </td>
                            @endunless

                            <td class="px-6 py-4 text-sm text-slate-800 whitespace-nowrap dark:text-slate-200">
                                {{ $transaction->category->name }}
                            </td>

                            <td class="px-6 py-4 text-sm text-slate-800 whitespace-nowrap dark:text-slate-200">
                                ${{ Number::format($transaction->amount, 2) }}
                            </td>

                            <td class="px-6 py-4 text-sm text-slate-800 whitespace-nowrap dark:text-slate-200">
                                {{ $transaction->description }}
                            </td>

                            <td class="px-6 py-4 text-sm text-slate-800 whitespace-nowrap dark:text-slate-200">
                                {{ Carbon\Carbon::parse($transaction->date)->format('F d Y') }}
                            </td>

                            <td class="px-6 whitespace-nowrap">
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

                            <td class="flex items-center justify-end px-6 py-4 text-sm font-medium whitespace-nowrap">
                                <button type="button">
                                    <x-heroicon-o-pencil-square
                                        class="p-1 text-indigo-500 duration-100 ease-in-out rounded-md w-7 h-7 hover:bg-slate-200 dark:hover:bg-slate-700" />
                                </button>

                                <button type="button">
                                    <x-heroicon-o-trash
                                        class="p-1 -mr-2 text-red-500 duration-100 ease-in-out rounded-md w-7 h-7 hover:bg-slate-200 dark:hover:bg-slate-700" />
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
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
