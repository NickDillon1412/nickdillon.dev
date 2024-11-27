<x-app-layout>
    <div x-data="{
        tabs: ['accounts', 'transactions'],
        activeTab: 'accounts',
    }" class="w-full p-4 mx-auto overflow-y-hidden sm:py-8 sm:px-6 lg:px-8 max-w-7xl">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 md:text-3xl dark:text-slate-100">
                Pure Finance
            </h1>

            <div x-cloak class="flex justify-center mt-4">
                <div
                    class="relative p-[3px] border rounded-lg bg-slate-200/60 dark:bg-slate-800/60 border-slate-200 dark:border-slate-700 w-fit">
                    <div class="absolute w-32 h-[30px] transition-all duration-300 bg-white dark:bg-slate-700 rounded-md shadow top-[3px] left-[3px]"
                        :style="'transform: translateX(' + (activeTab === 'accounts' ? '0%' : activeTab === 'transactions' ?
                            '100%' :
                            activeTab === 'budgets' ? '200%' : '300%') + ')'">
                    </div>

                    <div class="relative z-10 flex gap-0">
                        <template x-for="(tab, index) in tabs" :key="index">
                            <button x-on:click="activeTab = tab"
                                class="w-32 h-[30px] text-sm font-medium transition rounded-md text-slate-600 dark:text-slate-300 hover:text-slate-800 dark:hover:text-slate-100 focus:outline-none duration-200 ease-in-out flex items-center text-center justify-center"
                                :class="activeTab === tab ? 'text-slate-800 dark:text-white' : ''">
                                <flux:icon.banknotes class="mr-1.5 !h-5 !w-5" x-show="tab === 'accounts'" />

                                <flux:icon.calendar-days class="mr-1.5 !h-5 !w-5" x-show="tab === 'scheduled'" />

                                <flux:icon.book-open class="mr-1.5 !h-5 !w-5" x-show="tab === 'budgets'" />

                                <flux:icon.document-text class="mr-1.5 !h-5 !w-5" x-show="tab === 'transactions'" />

                                <span x-text="tab.charAt(0).toUpperCase() + tab.slice(1)"></span>
                            </button>
                        </template>
                    </div>
                </div>
            </div>

            <div x-show="activeTab === 'accounts'">
                @livewire('pure-finance.accounts')
            </div>

            <div x-cloak x-show="activeTab === 'transactions'">
                @livewire('pure-finance.transactions-table')
            </div>
        </div>
    </div>
</x-app-layout>
