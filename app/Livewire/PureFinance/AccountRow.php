<?php

declare(strict_types=1);

namespace App\Livewire\PureFinance;

use Livewire\Component;
use App\Models\PureFinance\Account;
use Illuminate\Contracts\View\View;

class AccountRow extends Component
{
    public Account $account;

    public function render(): View
    {
        return view('livewire.pure-finance.account-row');
    }
}
