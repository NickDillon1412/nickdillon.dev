<div x-data="{ plannedSpendingFormModalOpen: false }" x-on:planned-expense-saved.window="$wire.$refresh"
    class="w-full p-4 mx-auto overflow-y-hidden sm:py-8 sm:px-6 lg:px-8 max-w-screen-2xl">
    <div class="flex flex-col space-y-3">
        <h1 class="text-2xl font-semibold md:text-3xl text-slate-800 dark:text-slate-200">
            Planned Expense
        </h1>

        <div
            class="bg-white border divide-y shadow-sm rounded-xl border-slate-200 dark:bg-slate-800 divide-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 dark:divide-slate-600 h-fit">
            <div class="flex items-center justify-between gap-2 px-4 py-2.5">
                <h1 class="text-xl font-semibold text-slate-800 dark:text-slate-200">
                    {{ $expense->name }}
                </h1>

                <div>
                    <flux:button x-on:click="plannedSpendingFormModalOpen = true"
                        aria-controls="plannedSpendingFormModalOpen-modal" variant="indigo" size="sm">
                        Edit
                    </flux:button>

                    <livewire:pure-finance.planned-spending-form :$expense />
                </div>
            </div>

            <div class="border-t border-slate-200 dark:border-slate-600">
                <h3 class="px-4 pt-3 text-sm font-medium">
                    Spending in category: {{ $expense->category->name }}
                </h3>

                <div class="flex flex-col justify-between sm:space-x-8 sm:flex-row">
                    <div class="flex flex-col w-full">
                        <div class="flex flex-col px-4 py-3 space-y-2 text-sm">
                            <h3 class="font-medium uppercase">
                                This Month
                            </h3>

                            <div>
                                <p>Available</p>

                                <div class="flex items-center justify-between">
                                    <h3 @class([
                                        '!text-red-500' => $percentage_spent > 100,
                                        'font-semibold',
                                    ])>
                                        @if ($percentage_spent <= 100)
                                            ${{ Number::format($available ?? 0, 2) }}
                                        @else
                                            ${{ Number::format(abs($available) ?? 0, 2) }} over spent
                                        @endif
                                    </h3>

                                    <p>
                                        {{ $transaction_count }} {{ Str::plural('transaction', $transaction_count) }}
                                    </p>
                                </div>

                                <div class="w-full my-1.5 h-9 bg-indigo-100 dark:bg-slate-700 shadow-sm rounded-lg">
                                    <div @class([
                                        '!rounded-r-lg' => $percentage_spent >= 100,
                                        '!bg-red-500' => $percentage_spent > 100,
                                        'min-w-[25px]' => $percentage_spent > 0,
                                        '!bg-transparent' => $percentage_spent === 0,
                                        'flex items-center justify-center h-full bg-indigo-500 rounded-lg rounded-r-none',
                                    ])
                                        style="width: {{ min($percentage_spent, 100) }}%;">
                                        <span x-cloak x-show="$wire.percentage_spent > 0"
                                            class="font-semibold text-white">
                                            {{ Number::format($percentage_spent, 0) }}%
                                        </span>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between">
                                    <p>
                                        Spent

                                        <span class="font-semibold">
                                            ${{ Number::format($total_spent ?? 0, 2) }}
                                        </span>
                                    </p>

                                    <p>
                                        of

                                        <span class="font-semibold">
                                            ${{ Number::format($expense->monthly_amount ?? 0, 2) }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="w-full px-4 py-3">
                        <h3 class="mb-2 text-sm font-medium uppercase">
                            Last 6 Months
                        </h3>

                        <div wire:ignore class="relative flex flex-col my-8 text-sm">
                            <div class="flex items-end mb-2">
                                @foreach ($monthly_totals->reverse() as $month)
                                    <div class="w-[45px] mx-2 sm:mx-3" wire:key="{{ $month['total_spent'] }}">
                                        <div style="height: {{ $month['total_spent'] }}px"
                                            class="relative bg-indigo-500 shadow-sm rounded-t-md">
                                            <div class="absolute top-0 left-0 right-0 -mt-6 text-sm text-center">
                                                {{ $month['total_spent'] }}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="flex items-end">
                                @foreach ($monthly_totals->reverse() as $month)
                                    <div class="w-[45px] mx-2 sm:mx-3" wire:key="{{ $month['month'] }}">
                                        <div class="relative">
                                            <div class="absolute top-0 left-0 right-0 mt-1 text-sm text-center">
                                                {{ $month['month'] }}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
