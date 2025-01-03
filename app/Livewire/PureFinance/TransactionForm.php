<?php

declare(strict_types=1);

namespace App\Livewire\PureFinance;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Contracts\View\View;
use App\Models\PureFinance\Transaction;

#[Layout('layouts.app')]
class TransactionForm extends Component
{
    public ?Transaction $transaction = null;

    public function render(): View
    {
        return view('livewire.pure-finance.transaction-form');
    }
}
