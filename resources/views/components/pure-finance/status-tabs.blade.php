@props(['transactions', 'cleared_total', 'pending_total'])

<div class="flex justify-center" x-data="{
    tabs: ['all', 'cleared', 'pending'],
    activeTab: $wire.entangle('status'),
    transactionCounts: {
        all: '{{ $transactions->total() }}',
        cleared: '{{ $cleared_total }}',
        pending: '{{ $pending_total }}'
    }
}">
    <div
        class="p-[3px] border rounded-lg bg-slate-200/60 dark:bg-slate-800/60 border-slate-200 dark:border-slate-700 w-fit">
        <div class="flex">
            <template x-for="(tab, index) in tabs" :key="index">
                <button x-on:click="$wire.set('status', tab)"
                    class="py-1 px-2.5 text-sm font-medium transition rounded-md text-slate-600 dark:text-slate-300 hover:text-slate-800 dark:hover:text-slate-100 focus:outline-none duration-200 ease-in-out flex items-center text-center justify-center"
                    :class="activeTab === tab ? 'text-slate-800 dark:text-white bg-white dark:bg-slate-600 shadow' :
                        ''">
                    <span x-text="tab.charAt(0).toUpperCase() + tab.slice(1)"></span>

                    <span class="ml-1 text-slate-400" x-text="transactionCounts[tab]"></span>
                </button>
            </template>
        </div>
    </div>
</div>
