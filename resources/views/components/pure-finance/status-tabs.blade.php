@props(['transactions', 'cleared_total', 'pending_total'])

<div class="justify-center hidden sm:flex" x-data="{
    tabs: ['all', 'cleared', 'pending'],
    activeTab: $wire.entangle('status'),
    transactionCounts: {
        all: '{{ $transactions->total() }}',
        cleared: '{{ $cleared_total }}',
        pending: '{{ $pending_total }}'
    }
}">
    <div
        class="inline-flex p-[3px] rounded-lg bg-slate-200/60 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700">
        <template x-for="(tab, index) in tabs" :key="index">
            <button x-on:click="$wire.set('status', tab)"
                class="px-2.5 py-0.5 text-sm font-medium rounded-md transition-all duration-200 ease-in-out flex items-center gap-1.5 justify-center"
                :class="activeTab === tab ? 'bg-white dark:bg-slate-600 text-slate-800 dark:text-white shadow-sm' :
                    'text-slate-600 dark:text-slate-300 hover:text-slate-800 dark:hover:text-slate-100'">
                <span x-text="tab.charAt(0).toUpperCase() + tab.slice(1)"></span>
                <span class="text-slate-400" x-text="transactionCounts[tab]"></span>
            </button>
        </template>
    </div>
</div>
