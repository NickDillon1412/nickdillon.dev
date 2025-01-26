<div x-data="{ accountFormModalOpen: false }" class="pt-3 mx-auto space-y-5 sm:pt-5 sm:space-y-3">
    <div
        class="bg-white border divide-y shadow-sm rounded-xl border-slate-200 dark:bg-slate-800 divide-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 dark:divide-slate-600 h-fit">
        <div class="flex items-center justify-between gap-2 px-4 py-2.5">
            <h1 class="text-xl font-semibold text-slate-800 dark:text-slate-200">
                Accounts
            </h1>

            <div>
                <flux:button x-on:click="accountFormModalOpen = true" aria-controls="accountFormModalOpen-modal"
                    variant="indigo" size="sm" class="!h-7">
                    <x-heroicon-o-plus class="w-4 h-4" />

                    Add
                </flux:button>

                <livewire:pure-finance.account-form />
            </div>
        </div>

        <div class="flex flex-col space-y-0.5 p-2">
            @forelse ($accounts as $account)
                <a href="{{ route('pure-finance.account.overview', $account) }}" wire:navigate
                    class="flex items-center justify-between p-2 text-sm duration-200 ease-in-out rounded-lg hover:bg-slate-100 dark:hover:bg-slate-700">
                    <p class="font-medium">{{ $account->name }}</p>

                    <p>${{ Number::format($account->balance ?? 0, 2) }}</p>
                </a>
            @empty
                <div
                    class="p-0.5 text-sm italic font-medium text-center text-slate-800 whitespace-nowrap dark:text-slate-200">
                    No accounts found...
                </div>
            @endforelse
        </div>
    </div>
</div>
