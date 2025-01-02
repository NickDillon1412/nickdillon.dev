<?php

declare(strict_types=1);

namespace App\Livewire\PureFinance;

use Carbon\Carbon;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Illuminate\Support\Collection;
use App\Models\PureFinance\Account;
use Illuminate\Contracts\View\View;
use App\Models\PureFinance\Category;
use App\Services\PureFinanceService;
use App\Models\PureFinance\Transaction;
use Filament\Notifications\Notification;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class TransactionTable extends Component
{
    use WithPagination;

    public ?Account $account = null;

    public string $search = '';

    public string $status = 'all';

    public int $cleared_total;

    public int $pending_total;

    public string $transaction_type = '';

    public Collection $accounts;

    public array $selected_accounts = [];

    public Collection $categories;

    public array $selected_categories = [];

    public array $columns = [
        'date',
        'account',
        'category',
        'type',
        'amount',
        'description',
        'status'
    ];

    public string $date = '';

    public string $sort_col = 'date';

    public bool $sort_asc = false;

    public function mount(PureFinanceService $service): void
    {
        if (!$this->account) $this->accounts = $service->getAccounts();

        $this->categories = $service->getCategories();

        if (!is_null($this->account)) {
            $this->columns = collect($this->columns)
                ->reject(fn(string $column): bool => $column === 'account')
                ->values()
                ->toArray();
        }
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedStatus(): void
    {
        $this->resetPage();
    }

    public function updatingColumns(string $column): void
    {
        unset($this->columns[$column]);
    }

    #[On('clear-filters')]
    public function clearFilters(): void
    {
        $this->reset(['transaction_type', 'selected_categories', 'selected_accounts', 'date']);
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
            'type', 'amount', 'description', 'date', 'status' => $query->orderBy($this->sort_col, $direction),
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
                $query->where(function (Builder $query): void {
                    $query->whereRelation('category', 'name', 'like', "%{$this->search}%")
                        ->orWhere('description', 'like', "%{$this->search}%")
                        ->orWhere('amount', 'like', "%{$this->search}%")
                        ->orWhere('transactions.type', 'like', "%{$this->search}%");

                    if (!$this->account) {
                        $query->orWhereRelation('account', 'name', 'like', "%{$this->search}%");
                    }
                });
            })
            ->when($this->sort_col, fn(Builder $query): Builder => $this->applyColumnSorting($query))
            ->when($this->transaction_type, function (Builder $query): void {
                $query->where('transactions.type', $this->transaction_type);
            })
            ->when(!empty($this->selected_accounts), function (Builder $query): void {
                $query->where(function (Builder $query): void {
                    foreach ($this->selected_accounts as $account) {
                        $query->orWhereRelation('account', 'name', 'like', "%{$account}%");
                    }
                });
            })
            ->when(!empty($this->selected_categories), function (Builder $query): void {
                $query->where(function (Builder $query): void {
                    foreach ($this->selected_categories as $category) {
                        $query->orWhereRelation('category', 'name', 'like', "%{$category}%");
                    }
                });
            })
            ->when($this->date, function (Builder $query): void {
                $query->whereBetween('date', [Carbon::parse($this->date)->toDateString(), now()->toDateString()]);
            })
            ->paginate(25);
    }

    public function delete(Transaction $transaction): void
    {
        $transaction->delete();

        Notification::make()
            ->title("Successfully deleted transaction")
            ->success()
            ->send();

        $this->dispatch('close-modal');
    }

    public function render(): View
    {
        $transactions = $this->account
            ? $this->account->transactions()
            : auth()->user()->transactions();

        $this->cleared_total = $transactions->clone()->where('status', true)->count();
        $this->pending_total = $transactions->clone()->where('status', false)->count();

        return view('livewire.pure-finance.transaction-table', [
            'transactions' => $this->filterTransactions($transactions)
        ]);
    }
}
