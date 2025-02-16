<?php

declare(strict_types=1);

namespace App\Livewire\PureFinance;

use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Contracts\View\View;
use App\Models\PureFinance\Transaction;
use App\Models\PureFinance\PlannedExpense;

class PlannedSpending extends Component
{
    #[On('planned-expense-saved')]
    public function render(): View
    {
        $expenses = auth()->user()->planned_expenses;

        $timezone = 'America/Chicago';

        $start_of_month = now()->timezone($timezone)->startOfMonth()->toDateString();

        $end_of_month = now()->timezone($timezone)->endOfMonth()->toDateString();

        $totals = Transaction::query()
            ->selectRaw('transactions.category_id, SUM(transactions.amount) as total_spent')
            ->join('categories', 'transactions.category_id', '=', 'categories.id')
            ->whereIn('transactions.category_id', $expenses->pluck('category_id'))
            ->whereBetween('transactions.date', [$start_of_month, $end_of_month])
            ->groupBy('transactions.category_id')
            ->pluck('total_spent', 'category_id');

        $expenses->each(function (PlannedExpense $expense) use ($totals): void {
            $expense->total_spent = $totals[$expense->category_id] ?? 0;
        });

        return view('livewire.pure-finance.planned-spending', ['expenses' => $expenses]);
    }
}
