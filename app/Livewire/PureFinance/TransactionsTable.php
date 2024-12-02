<?php

declare(strict_types=1);

namespace App\Livewire\PureFinance;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\PureFinance\Account;
use Illuminate\Contracts\View\View;
use App\Models\PureFinance\Category;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class TransactionsTable extends Component
{
    use WithPagination;

    public ?Account $account = null;

    public string $search = '';

    public string $status = 'all';

    public int $cleared_total;

    public int $pending_total;

    public string $sort_col = '';

    public bool $sort_asc = false;

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedStatus(): void
    {
        $this->resetPage();
    }

    public function sortBy(string $column): void
    {
        if ($this->sort_col === $column) {
            $this->sort_asc = !$this->sort_asc;
        } else {
            $this->sort_col = $column;
            $this->sort_asc = false;
        }
    }

    public function applyColumnSorting(Builder $query): Builder
    {
        $direction = $this->sort_asc ? 'asc' : 'desc';

        return match ($this->sort_col) {
            'account' => $query->orderBy(
                Account::select('name')
                    ->whereColumn('id', 'transactions.account_id')
                    ->limit(1),
                $direction
            ),
            'category' => $query->orderBy(
                Category::select('name')
                    ->whereColumn('id', 'transactions.category_id')
                    ->limit(1),
                $direction
            ),
            'amount', 'description', 'date', 'status' => $query->orderBy($this->sort_col, $direction),
            default => $query
        };
    }

    public function filterTransactions(HasManyThrough|HasMany $transactions): LengthAwarePaginator
    {
        return $transactions
            ->with(['account:id,name', 'category:id,name'])
            ->when($this->status !== 'all', function (Builder $query): void {
                $query->where('status', $this->status === 'cleared' ? true : false);
            })
            ->when(strlen($this->search) >= 1, function (Builder $query): void {
                $query->where(function (Builder $query) {
                    $query->whereRelation('category', 'name', 'like', "%{$this->search}%")
                        ->orWhere('description', 'like', "%{$this->search}%")
                        ->orWhere('amount', 'like', "%{$this->search}%");

                    if (!$this->account) {
                        $query->orWhereRelation('account', 'name', 'like', "%{$this->search}%");
                    }
                });
            })
            ->when($this->sort_col, fn(Builder $query): Builder => $this->applyColumnSorting($query))
            ->latest()
            ->paginate(25);
    }

    public function render(): View
    {
        $transactions = $this->account
            ? $this->account->transactions()
            : auth()->user()->transactions();

        $this->cleared_total = $transactions->clone()->where('status', true)->count();
        $this->pending_total = $transactions->clone()->where('status', false)->count();

        return view('livewire.pure-finance.transactions-table', [
            'transactions' => $this->filterTransactions($transactions)
        ]);
    }
}
