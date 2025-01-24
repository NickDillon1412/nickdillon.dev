<?php

declare(strict_types=1);

namespace App\Livewire\PureFinance;

use Livewire\Component;
use Illuminate\Validation\Rule;
use App\Models\PureFinance\Account;
use Illuminate\Contracts\View\View;
use App\Enums\PureFinance\AccountType;
use Filament\Notifications\Notification;

class AccountForm extends Component
{
    public ?Account $account = null;

    public string $name;

    public AccountType $type;

    public ?float $balance = null;

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'type' => ['required', Rule::enum(AccountType::class)],
            'balance' => ['nullable', 'decimal:0,2', 'numeric'],
        ];
    }

    public function mount(): void
    {
        if ($this->account) {
            $this->name = $this->account->name;
            $this->type = $this->account->type;
            $this->balance = $this->account->balance;
        }
    }

    public function submit(): void
    {
        $validated_data = $this->validate();

        $this->account
            ? $this->account->update($validated_data)
            : auth()->user()->accounts()->create($validated_data);

        if (!$this->account) $this->reset();

        Notification::make()
            ->title("Account successfully " . ($this->account ? "updated" : "created"))
            ->success()
            ->send();

        $this->dispatch('account-saved');
    }

    public function render(): View
    {
        return view('livewire.pure-finance.account-form');
    }
}
