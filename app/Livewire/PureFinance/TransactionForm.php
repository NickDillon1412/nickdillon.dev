<?php

declare(strict_types=1);

namespace App\Livewire\PureFinance;

use Livewire\Component;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Illuminate\Support\Collection;
use Illuminate\Contracts\View\View;
use App\Models\PureFinance\Category;
use Illuminate\Http\RedirectResponse;
use App\Models\PureFinance\Transaction;
use Filament\Notifications\Notification;
use App\Enums\PureFinance\TransactionType;
use Livewire\Features\SupportRedirects\Redirector;

#[Layout('layouts.app')]
class TransactionForm extends Component
{
    public ?Transaction $transaction = null;

    public Collection $accounts;

    public Collection $categories;

    public int $account_id;

    public string $description = '';

    public TransactionType $type;

    public float $amount;

    public int $category_id;

    public string $date = '';

    public string $notes = '';

    public array $files = [];

    public bool $status = false;

    protected function rules(): array
    {
        return [
            'account_id' => ['required', 'int'],
            'description' => ['required', 'string'],
            'type' => ['required', Rule::enum(TransactionType::class)],
            'amount' => ['required'],
            'category_id' => ['required', 'int'],
            'date' => ['required', 'date'],
            'notes' => ['nullable', 'string'],
            'status' => ['required', 'boolean'],
        ];
    }

    public function mount(): void
    {
        if ($this->transaction) {
            $this->account_id = $this->transaction->account_id;
            $this->description = $this->transaction->description;
            $this->type = $this->transaction->type;
            $this->amount = $this->transaction->amount;
            $this->category_id = $this->transaction->category_id;
            $this->date = $this->transaction->date;
            $this->notes = $this->transaction->notes;
            $this->status = $this->transaction->status;
        }
    }

    public function submit(): RedirectResponse|Redirector
    {
        $validated_data = $this->validate();

        $this->transaction
            ? $this->transaction->update($validated_data)
            : auth()->user()->transactions()->create($validated_data);

        Notification::make()
            ->title("Transaction successfully " . ($this->transaction ? "updated" : "created"))
            ->success()
            ->send();

        return redirect()->route('pure-finance.index');
    }

    public function render(): View
    {
        $this->accounts = auth()->user()->accounts->pluck('name', 'id');

        $this->categories = Category::pluck('name', 'id');

        return view('livewire.pure-finance.transaction-form');
    }
}
