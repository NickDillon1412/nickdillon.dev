<?php

namespace App\Livewire\PureFinance;

use Carbon\Carbon;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Contracts\View\View;
use App\Models\PureFinance\Transaction;
use App\Models\PureFinance\PlannedExpense;

#[Layout('layouts.app')]
class PlannedExpenseView extends Component
{
    public PlannedExpense $expense;

    public int|float $total_spent = 0;

    public int $transaction_count = 0;

    public int|float $available = 0;

    public float $percentage_spent = 0;

    public function render(): View
    {
        $timezone = 'America/Chicago';

        $start_of_month = now()->timezone($timezone)->startOfMonth()->toDateString();

        $end_of_month = now()->timezone($timezone)->endOfMonth()->toDateString();

        $this->total_spent = Transaction::query()
            ->whereCategoryId($this->expense->category_id)
            ->whereBetween('date', [$start_of_month, $end_of_month])
            ->sum('amount');

        $this->transaction_count = Transaction::query()
            ->whereCategoryId($this->expense->category_id)
            ->whereBetween('date', [$start_of_month, $end_of_month])
            ->count();

        $this->available = $this->expense->monthly_amount - $this->total_spent;

        $this->percentage_spent = $this->expense->monthly_amount > 0
            ? ($this->total_spent / $this->expense->monthly_amount) * 100
            : 0;

        return view('livewire.pure-finance.planned-expense-view');
    }
}
