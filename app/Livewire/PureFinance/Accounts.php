<?php

declare(strict_types=1);

namespace App\Livewire\PureFinance;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Layout;
use App\Models\PureFinance\Account;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use App\Enums\PureFinance\TransactionType;

#[Layout('layouts.app')]
class Accounts extends Component
{
    #[On('account-saved')]
    public function render(): View
    {
        return view('livewire.pure-finance.accounts', [
            'accounts' => auth()
                ->user()
                ->accounts()
                ->withCount('transactions')
                ->withSum(['transactions as cleared_deposits' => function (Builder $query): void {
                    $query->whereIn('type', [TransactionType::CREDIT, TransactionType::DEPOSIT])
                        ->where('status', true);
                }], 'amount')
                ->withSum(['transactions as cleared_debits' => function (Builder $query): void {
                    $query->whereIn('type', [TransactionType::DEBIT, TransactionType::TRANSFER, TransactionType::WITHDRAWAL])
                        ->where('status', true);
                }], 'amount')
                ->get()
                ->map(function (Account $account): Account {
                    $account->cleared_balance = $account->initial_balance +
                        ($account->cleared_deposits ?? 0) - ($account->cleared_debits ?? 0);

                    return $account;
                })
        ]);
    }
}
