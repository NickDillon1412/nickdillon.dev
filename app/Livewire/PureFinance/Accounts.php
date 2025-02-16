<?php

declare(strict_types=1);

namespace App\Livewire\PureFinance;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Layout;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;

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
                ->withSum(['transactions as cleared_balance' => function (Builder $query): void {
                    $query->where('status', true);
                }], 'amount')
                ->orderBy('name')
                ->get()
        ]);
    }
}
