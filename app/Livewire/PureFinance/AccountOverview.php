<?php

declare(strict_types=1);

namespace App\Livewire\PureFinance;

use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use App\Models\PureFinance\Account;
use Illuminate\Contracts\View\View;
use App\Enums\PureFinance\AccountType;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;

#[Layout('layouts.app')]
class AccountOverview extends Component
{
    use WithPagination;

    public Account $account;

    public string $name;

    public AccountType $type;

    public ?float $balance = null;

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'type' => ['required', Rule::enum(AccountType::class)],
            'balance' => ['decimal:2', 'nullable'],
        ];
    }

    public function mount(): void
    {
        $this->name = $this->account->name;
        $this->type = $this->account->type;
        $this->balance = $this->account->balance;
    }

    public function update(): void
    {
        $this->account->update($this->validate());

        Notification::make()
            ->title("Account successfully updated")
            ->success()
            ->send();
    }

    public function render(): View
    {
        return view('livewire.pure-finance.account-overview');
    }
}
