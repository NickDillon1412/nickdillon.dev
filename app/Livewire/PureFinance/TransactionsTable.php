<?php

declare(strict_types=1);

namespace App\Livewire\PureFinance;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\PureFinance\Account;
use Illuminate\Contracts\View\View;
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

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedStatus(): void
    {
        $this->resetPage();
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
            ->latest()
            ->paginate(25);
    }

    public function render(): View
    {
        if ($this->account) {
            $transactions = $this->filterTransactions($this->account->transactions());
        } else {
            $transactions = $this->filterTransactions(auth()->user()->transactions());
        }

        return view('livewire.pure-finance.transactions-table', [
            'transactions' => $transactions
        ]);
    }
}
