<x-app-layout>
    <div x-data="{
        tabs: ['accounts', 'transactions'],
        activeTab: 'accounts',
    }" class="w-full p-4 mx-auto overflow-y-hidden sm:px-6 sm:py-8 lg:px-8 max-w-7xl">
        <h1 class="text-2xl font-bold text-slate-800 md:text-3xl dark:text-slate-100">
            Pure Finance
        </h1>

        <div class="flex flex-col gap-4 sm:grid-cols-8 sm:grid">
            <div class="sm:col-span-2">
                @livewire('pure-finance.accounts')
            </div>

            <div class="sm:col-span-6">
                @livewire('pure-finance.transaction-table')
            </div>
        </div>
    </div>
</x-app-layout>
