<?php

declare(strict_types=1);

namespace App\Livewire\PureFinance;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Layout;
use Illuminate\Validation\Rule;
use Illuminate\Support\Collection;
use App\Models\PureFinance\Account;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\PureFinance\Transaction;
use Filament\Notifications\Notification;
use App\Enums\PureFinance\TransactionType;
use App\Enums\PureFinance\RecurringFrequency;
use App\Rules\PureFinance\FrequencyIntervalRule;
use Livewire\Features\SupportRedirects\Redirector;
use App\Actions\PureFinance\CreateRecurringTransactions;

#[Layout('layouts.app')]
class TransactionForm extends Component
{
    public ?Account $account = null;

    public ?Transaction $transaction = null;

    public Collection $accounts;

    public array $categories = [];

    public ?int $account_id = null;

    public ?int $transfer_to = null;

    public string $payee = '';

    public array $transaction_types = [];

    public TransactionType $type;

    public float $amount;

    public int $category_id;

    public string $date = '';

    public array $user_tags = [];

    public array $tags = [];

    public string $notes = '';

    public ?array $attachments = [];

    public bool $status = false;

    public bool $is_recurring = false;

    public ?RecurringFrequency $frequency = null;

    public ?string $recurring_end = null;

    protected function rules(): array
    {
        return [
            'account_id' => ['required', 'int'],
            'payee' => ['required', 'string'],
            'type' => ['required', Rule::enum(TransactionType::class)],
            'transfer_to' => ['nullable', 'int'],
            'amount' => ['required', 'decimal:0,2', 'numeric'],
            'category_id' => ['required', 'int'],
            'date' => ['required', 'date'],
            'tags' => ['nullable', 'array'],
            'notes' => ['nullable', 'string'],
            'attachments' => ['nullable', 'array'],
            'status' => ['required', 'boolean'],
            'is_recurring' => ['required', 'boolean'],
            'frequency' => [
                'nullable',
                'required_if:is_recurring,true',
                Rule::enum(RecurringFrequency::class)
            ],
            'recurring_end' => array_filter([
                'nullable',
                'date',
                $this->is_recurring ?
                    new FrequencyIntervalRule($this->date, $this->recurring_end, $this->frequency) :
                    null,
            ]),
        ];
    }

    protected function messages(): array
    {
        return [
            'category_id.required' => 'The category field is required.'
        ];
    }

    public function mount(): void
    {
        $this->date = now()->timezone('America/Chicago')->format('n/d/Y');

        $this->getAccounts()
            ->getCategories()
            ->getTransactionTypes()
            ->getUserTags();

        if ($this->account) {
            $this->account_id = $this->account->id;
        }

        if ($this->transaction) {
            $this->account_id = $this->transaction->account->id;
            $this->payee = $this->transaction->payee;
            $this->type = $this->transaction->type;
            $this->transfer_to = $this->transaction->transfer_to;
            $this->amount = $this->transaction->amount;
            $this->category_id = $this->transaction->category_id;
            $this->date = $this->transaction->date->format('n/d/Y');
            $this->tags = $this->transaction->tags->toArray();
            $this->notes = $this->transaction->notes;
            $this->status = $this->transaction->status;
            $this->is_recurring = $this->transaction->is_recurring;
            $this->frequency = $this->transaction->frequency;
            $this->recurring_end = $this->transaction->recurring_end?->format('n/d/Y');
        }
    }

    public function getAccounts(): self
    {
        $this->accounts = auth()
            ->user()
            ->accounts()
            ->select(['id', 'name'])
            ->orderBy('name')
            ->get();

        return $this;
    }

    #[On('category-saved')]
    public function getCategories(): self
    {
        $this->categories = auth()
            ->user()
            ->categories()
            ->with('children')
            ->select(['id', 'name', 'parent_id'])
            ->whereNull('parent_id')
            ->orderBy('name')
            ->get()
            ->toArray();

        return $this;
    }

    public function getTransactionTypes(): self
    {
        $this->transaction_types = collect(TransactionType::cases())
            ->sortBy('value')
            ->values()
            ->all();

        return $this;
    }

    #[On('tag-saved')]
    public function getUserTags(): self
    {
        $this->user_tags = auth()
            ->user()
            ->tags()
            ->select(['id', 'name'])
            ->orderBy('name')
            ->get()
            ->toArray();

        return $this;
    }

    #[On('file-uploaded')]
    public function pushToAttachments(array $file): void
    {
        $this->attachments[] = $file;
    }

    #[On('file-deleted')]
    public function deleteAttachment(string $file_name): void
    {
        if ($this->transaction) {
            $this->transaction->attachments = collect($this->transaction->attachments)
                ->reject(fn(array $attachment): bool => $attachment['name'] === $file_name)
                ->values()
                ->all();

            $this->transaction->save();
        }
    }

    private function handleTransfer(Account $account, int|float $amount): void
    {
        $account->increment('balance', $amount);
    }

    public function submit(CreateRecurringTransactions $action): RedirectResponse|Redirector
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

        $current_tags = collect($this->tags)->pluck('id')->toArray();

        if ($this->transaction) {
            $this->transaction->tags()->sync($current_tags);

            $this->transaction->update($validated_data);
        } else {
            $new_transaction = auth()->user()->transactions()->create($validated_data);

            $new_transaction->tags()->sync($current_tags);
        }

        if ($this->transfer_to) {
            $this->handleTransfer(Account::find($this->transfer_to), $this->amount);
        }

        $action->handle($this->transaction ?: $new_transaction);

        Notification::make()
            ->title("Transaction successfully " . ($this->transaction ? "updated" : "created"))
            ->success()
            ->send();

        return redirect()->route('pure-finance.index');
    }

    public function render(): View
    {
        return view('livewire.pure-finance.transaction-form');
    }
}
