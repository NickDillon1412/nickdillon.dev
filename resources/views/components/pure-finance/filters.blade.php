@props(['account' => null, 'accounts', 'categories'])

@use('App\Enums\PureFinance\TransactionType', 'TransactionType')

<div x-data="{
    showSortBy: true,
    showTypes: true,
    showAccounts: true,
    showCategories: true,
    showDates: true,
    slideOverOpen: false,
    totalFilters() {
        total = $wire.selected_accounts.length + $wire.selected_categories.length;

        if ($wire.transaction_type) total++;

        if ($wire.date) total++;

        return total;
    },
}" class="relative z-20 flex w-auto h-auto">
    <div class="relative inline-block">
        <flux:button icon="funnel" variant="subtle" x-on:click="slideOverOpen = true"
            class="!h-8 sm:!w-8 !w-4 hover:!bg-white hover:!text-slate-500 dark:hover:!bg-slate-800 dark:hover:!text-slate-300" />

        <span x-cloak x-show="totalFilters() > 0"
            class="absolute top-0 right-0 flex items-center justify-center w-fit min-w-[18px] -mt-2 -mr-3 text-xs rounded-md border border-indigo-500 text-indigo-500 dark:border-indigo-500 dark:text-indigo-500 bg-indigo-500/10 dark:bg-indigo-500/10"
            x-text="totalFilters()">
        </span>
    </div>

    <template x-teleport="body">
        <div x-show="slideOverOpen" x-on:keydown.window.escape="slideOverOpen = false"
            x-trap.inert.noscroll="slideOverOpen" class="relative z-[99]">
            <div x-cloak x-show="slideOverOpen" x-transition.opacity.duration.200ms x-on:click="slideOverOpen = false"
                class="fixed inset-0 bg-slate-900 bg-opacity-20"></div>

            <div class="fixed inset-0 overflow-hidden">
                <div class="absolute inset-0 overflow-hidden">
                    <div class="fixed inset-y-0 right-0 flex max-w-full pl-10">
                        <div x-show="slideOverOpen" x-on:click.away="slideOverOpen = false"
                            x-transition:enter="transform transition ease-in-out duration-200"
                            x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
                            x-transition:leave="transform transition ease-in-out duration-200"
                            x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full"
                            class="w-screen max-w-[250px] sm:max-w-[300px]">
                            <div
                                class="flex flex-col h-full py-5 overflow-y-scroll bg-white border-l dark:bg-slate-800 border-slate-200 dark:border-slate-700 dark:text-slate-200 text-slate-800">
                                <div class="px-4 sm:px-5">
                                    <div class="flex items-center justify-between">
                                        <h2 class="font-semibold" id="slide-over-title">
                                            Filters
                                        </h2>

                                        <div class="flex items-center space-x-1">
                                            <button x-cloak x-show="totalFilters() > 1"
                                                class="px-2 text-sm font-medium text-indigo-500 duration-200 ease-in-out rounded hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700"
                                                x-on:click="$dispatch('clear-filters')">
                                                Clear all
                                            </button>

                                            <flux:button variant="subtle" icon="x-mark"
                                                class="!h-6 !w-6 hover:!bg-slate-200 dark:hover:!bg-slate-700 !-mr-0.5  hover:text-slate-800 dark:hover:text-slate-200"
                                                x-on:click="slideOverOpen = false" />
                                        </div>
                                    </div>
                                </div>

                                <div class="relative flex-1 px-4 mt-2 space-y-3 sm:px-5">
                                    <div class="mb-4">
                                        <div class="pb-0.5 text-sm font-medium flex items-center justify-between">
                                            <p>
                                                Types
                                            </p>

                                            <div class="flex items-center justify-between">
                                                <button x-cloak x-show="$wire.transaction_type"
                                                    class="px-2 text-sm font-medium duration-200 ease-in-out rounded hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700"
                                                    x-on:click="$wire.set('transaction_type', '')">
                                                    Clear
                                                </button>

                                                <flux:button variant="subtle" icon="chevron-down"
                                                    class="!h-6 !w-6 hover:!bg-slate-200 dark:hover:!bg-slate-700 !-mr-0.5  hover:text-slate-800 dark:hover:text-slate-200"
                                                    x-bind:class="showTypes ? 'rotate-180' : ''"
                                                    x-on:click="showTypes = !showTypes" />
                                            </div>
                                        </div>

                                        <div x-collapse x-show="showTypes"
                                            class="pt-2 space-y-2 border-t border-slate-300 dark:border-slate-700">
                                            @foreach (TransactionType::cases() as $type)
                                                <label for="{{ $type }}" class="flex items-center">
                                                    <input id="{{ $type }}" type="radio"
                                                        value="{{ $type }}" name="{{ $type }}"
                                                        class="w-4 h-4 text-indigo-600 bg-slate-100 border-slate-300 focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:ring-offset-slate-800 focus:ring-2 dark:bg-slate-700 dark:border-slate-600"
                                                        wire:model.live='transaction_type' />

                                                    <span class="ml-2 text-sm">
                                                        {{ $type->label() }}
                                                    </span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>

                                    @if (!$account)
                                        <div>
                                            <div class="pb-0.5 text-sm font-medium flex items-center justify-between">
                                                <p>
                                                    Accounts
                                                </p>

                                                <div class="flex items-center justify-between">
                                                    <button x-cloak x-show="$wire.selected_accounts.length > 0"
                                                        class="px-2 text-sm font-medium duration-200 ease-in-out rounded hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700"
                                                        x-on:click="$wire.set('selected_accounts', [])">
                                                        Clear
                                                    </button>

                                                    <flux:button variant="subtle" icon="chevron-down"
                                                        class="!h-6 !w-6 hover:!bg-slate-200 dark:hover:!bg-slate-700 !-mr-0.5  hover:text-slate-800 dark:hover:text-slate-200"
                                                        x-bind:class="showAccounts ? 'rotate-180' : ''"
                                                        x-on:click="showAccounts = !showAccounts" />
                                                </div>
                                            </div>

                                            <div x-collapse x-show="showAccounts"
                                                class="pt-1 border-t border-slate-300 dark:border-slate-700">
                                                @foreach ($accounts as $account)
                                                    <label for="selected_account.{{ $account }}"
                                                        class="flex items-center py-1">
                                                        <input id="selected_account.{{ $account }}"
                                                            name="selected_account.{{ $account }}" type="checkbox"
                                                            class="w-4 h-4 text-indigo-600 rounded bg-slate-100 border-slate-300 focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:ring-offset-slate-800 focus:ring-2 dark:bg-slate-700 dark:border-slate-600"
                                                            wire:model.live='selected_accounts'
                                                            value="{{ $account }}" />

                                                        <span class="ml-2 text-sm">
                                                            {{ $account }}
                                                        </span>
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    <div>
                                        <div class="pb-0.5 text-sm font-medium flex items-center justify-between">
                                            <p>
                                                Categories
                                            </p>

                                            <div class="flex items-center justify-between">
                                                <button x-cloak x-show="$wire.selected_categories.length > 0"
                                                    class="px-2 text-sm font-medium duration-200 ease-in-out rounded hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700"
                                                    x-on:click="$wire.set('selected_categories', [])">
                                                    Clear
                                                </button>

                                                <flux:button variant="subtle" icon="chevron-down"
                                                    class="!h-6 !w-6 hover:!bg-slate-200 dark:hover:!bg-slate-700 !-mr-0.5  hover:text-slate-800 dark:hover:text-slate-200"
                                                    x-bind:class="showCategories ? 'rotate-180' : ''"
                                                    x-on:click="showCategories = !showCategories" />
                                            </div>
                                        </div>

                                        <div x-collapse x-show="showCategories"
                                            class="pt-1 border-t border-slate-300 dark:border-slate-700">
                                            @foreach ($categories as $category)
                                                <label for="selected_category.{{ $category }}"
                                                    class="flex items-center py-1">
                                                    <input id="selected_category.{{ $category }}"
                                                        name="selected_category.{{ $category }}" type="checkbox"
                                                        class="w-4 h-4 text-indigo-600 rounded bg-slate-100 border-slate-300 focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:ring-offset-slate-800 focus:ring-2 dark:bg-slate-700 dark:border-slate-600"
                                                        wire:model.live='selected_categories'
                                                        value="{{ $category }}" />

                                                    <span class="ml-2 text-sm">
                                                        {{ $category }}
                                                    </span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div>
                                        <div class="pb-0.5 text-sm font-medium flex items-center justify-between">
                                            <p>
                                                Dates
                                            </p>

                                            <div class="flex items-center justify-between">
                                                <button x-cloak x-show="$wire.date"
                                                    class="px-2 text-sm font-medium duration-200 ease-in-out rounded hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700"
                                                    x-on:click="$wire.set('date', '')">
                                                    Clear
                                                </button>

                                                <flux:button variant="subtle" icon="chevron-down"
                                                    class="!h-6 !w-6 hover:!bg-slate-200 dark:hover:!bg-slate-700 !-mr-0.5  hover:text-slate-800 dark:hover:text-slate-200"
                                                    x-bind:class="showDates ? 'rotate-180' : ''"
                                                    x-on:click="showDates = !showDates" />
                                            </div>
                                        </div>

                                        <div x-collapse x-show="showDates"
                                            class="pt-2 space-y-2 border-t border-slate-300 dark:border-slate-700">
                                            <label for="last_7_days" class="flex items-center">
                                                <input id="last_7_days" type="radio"
                                                    value="{{ now()->subDays(7) }}" name="last_7_days"
                                                    class="w-4 h-4 text-indigo-600 bg-slate-100 border-slate-300 focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:ring-offset-slate-800 focus:ring-2 dark:bg-slate-700 dark:border-slate-600"
                                                    wire:model.live='date' />

                                                <span class="ml-2 text-sm">
                                                    Last 7 Days
                                                </span>
                                            </label>

                                            <label for="last_30_days" class="flex items-center">
                                                <input id="last_30_days" type="radio"
                                                    value="{{ now()->subDays(30) }}" name="last_30_days"
                                                    class="w-4 h-4 text-indigo-600 bg-slate-100 border-slate-300 focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:ring-offset-slate-800 focus:ring-2 dark:bg-slate-700 dark:border-slate-600"
                                                    wire:model.live='date' />

                                                <span class="ml-2 text-sm">
                                                    Last 30 Days
                                                </span>
                                            </label>

                                            <label for="last_3_months" class="flex items-center">
                                                <input id="last_3_months" type="radio"
                                                    value="{{ now()->subMonths(3) }}" name="last_3_months"
                                                    class="w-4 h-4 text-indigo-600 bg-slate-100 border-slate-300 focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:ring-offset-slate-800 focus:ring-2 dark:bg-slate-700 dark:border-slate-600"
                                                    wire:model.live='date' />

                                                <span class="ml-2 text-sm">
                                                    Last 3 Months
                                                </span>
                                            </label>

                                            <label for="last_6_months" class="flex items-center">
                                                <input id="last_6_months" type="radio"
                                                    value="{{ now()->subMonths(6) }}" name="last_6_months"
                                                    class="w-4 h-4 text-indigo-600 bg-slate-100 border-slate-300 focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:ring-offset-slate-800 focus:ring-2 dark:bg-slate-700 dark:border-slate-600"
                                                    wire:model.live='date' />

                                                <span class="ml-2 text-sm">
                                                    Last 6 Months
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </template>
</div>
