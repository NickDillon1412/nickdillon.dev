<x-app-layout>
    <div x-data="{
        tabs: ['accounts', 'transactions'],
        activeTab: 'accounts',
    }" class="w-full p-4 mx-auto overflow-y-hidden sm:px-6 sm:py-8 lg:px-8 max-w-7xl">
        <h1 class="text-2xl font-bold text-slate-800 md:text-3xl dark:text-slate-100">
            Pure Finance
        </h1>

        <div class="flex flex-col space-y-4 sm:space-y-0">
            <div class="flex flex-col gap-1 sm:gap-4 sm:flex-row">
                @livewire('pure-finance.accounts')

                @livewire('pure-finance.planned-spending')
            </div>

            @livewire('pure-finance.transaction-table')
        </div>
    </div>
</x-app-layout>
