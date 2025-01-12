<?php

declare(strict_types=1);

namespace App\Livewire\PureFinance;

use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Illuminate\Support\Collection;
use Illuminate\Contracts\View\View;
use App\Models\PureFinance\Category;
use Illuminate\Http\RedirectResponse;
use App\Models\PureFinance\Transaction;
use Filament\Notifications\Notification;
use App\Enums\PureFinance\TransactionType;
use App\Enums\PureFinance\RecurringFrequency;
use App\Rules\PureFinance\FrequencyIntervalRule;
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

    public ?array $attachments = [];

    public bool $status = false;

    public bool $is_recurring = false;

    public RecurringFrequency $frequency;

    public string $recurring_end = '';

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
            'attachments' => ['nullable', 'array'],
            'status' => ['required', 'boolean'],
            'is_recurring' => ['required', 'boolean'],
            'frequency' => ['nullable', 'required_if:is_recurring,true', Rule::enum(RecurringFrequency::class)],
            'recurring_end' => [
                'nullable',
                'date',
                new FrequencyIntervalRule(
                    $this->date,
                    $this->recurring_end,
                    $this->frequency
                ),
            ],
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
            $this->date = $this->transaction->date->format('n/d/Y');
            $this->notes = $this->transaction->notes;
            $this->status = $this->transaction->status;
            $this->is_recurring = $this->transaction->is_recurring;
            $this->frequency = $this->transaction->frequency;
            $this->recurring_end = $this->transaction->recurring_end->format('n/d/Y');
        }
    }

    #[On('file-uploaded')]
    public function pushToAttachments(array $file): void
    {
        $this->attachments[] = $file;
    }

    public function submit(): RedirectResponse|Redirector
    {
        $validated_data = $this->validate();

        if ($this->transaction) {
            $validated_data['attachments'] = [
                ...$this->transaction->attachments ?? [],
                ...$this->attachments ?? []
            ];
        } else {
            $validated_data['attachments'] = $this->attachments;
        }

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
