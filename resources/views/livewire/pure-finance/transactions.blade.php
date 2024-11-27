@use('App\Enums\PureFinance\AccountType', 'AccountType')

<div x-data="{ accountFormModalOpen: false }" class="w-full pt-5 mx-auto overflow-y-hidden max-w-screen-2xl">
    <livewire:pure-finance.transactions-table />
</div>
