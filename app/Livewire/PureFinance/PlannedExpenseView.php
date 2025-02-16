<?php

namespace App\Livewire\PureFinance;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Collection;
use Illuminate\Contracts\View\View;
use App\Models\PureFinance\Transaction;
use Illuminate\Database\Eloquent\Builder;
use App\Models\PureFinance\PlannedExpense;

#[Layout('layouts.app')]
class PlannedExpenseView extends Component
{
    public PlannedExpense $expense;

    public string $timezone = '';

    public int|float $total_spent = 0;

    public int $transaction_count = 0;

    public int|float $available = 0;

    public float $percentage_spent = 0;

    public Collection $monthly_totals;

    public function mount(): void
    {
        $this->timezone = 'America/Chicago';

        $this->monthly_totals = collect();
    }

    private function getCurrentMonthData(): void
    {
        $start_of_month = now()->timezone($this->timezone)->startOfMonth()->toDateString();

        $end_of_month = now()->timezone($this->timezone)->endOfMonth()->toDateString();

        $transactions_query = Transaction::query()
            ->where(function (Builder $query): void {
                $query->where('category_id', $this->expense->category_id)
                    ->orWhereRelation('category', 'parent_id', $this->expense->category_id);
            })
            ->whereBetween('date', [$start_of_month, $end_of_month]);

        $this->total_spent = $transactions_query->sum('amount');

        $this->transaction_count = $transactions_query->count();

        $this->available = $this->expense->monthly_amount - $this->total_spent;

        $this->percentage_spent = ($this->total_spent / $this->expense->monthly_amount) * 100;
    }

    private function getTotalSpentLastSixMonths(): void
    {
        $now = now()->timezone($this->timezone);

        $months = collect();

        for ($i = 1; $i < 7; $i++) {
            $months->push($now->copy()->subMonths($i));
        }

        foreach ($months as $month) {
            $start_of_month = $month->startOfMonth()->toDateString();
            $end_of_month = $month->endOfMonth()->toDateString();

            // Sum the amount for transactions in the selected category and month
            $total_for_month = Transaction::query()
                ->where(function (Builder $query): void {
                    $query->where('category_id', $this->expense->category_id)
                        ->orWhereRelation('category', 'parent_id', $this->expense->category_id);
                })
                ->whereBetween('date', [$start_of_month, $end_of_month])
                ->sum('amount');

            $this->monthly_totals->push([
                'month' => $month->format('M'),
                'total_spent' => ceil($total_for_month),
            ]);
        }
    }

    public function render(): View
    {
        $this->getCurrentMonthData();

        $this->getTotalSpentLastSixMonths();

        return view('livewire.pure-finance.planned-expense-view');
    }
}
