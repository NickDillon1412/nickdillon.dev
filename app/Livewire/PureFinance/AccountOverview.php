<?php

declare(strict_types=1);

namespace App\Livewire\PureFinance;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use App\Models\PureFinance\Account;
use Illuminate\Contracts\View\View;

#[Layout('layouts.app')]
class AccountOverview extends Component
{
    use WithPagination;

    public Account $account;

    public function render(): View
    {
        return view('livewire.pure-finance.account-overview');
    }
}
