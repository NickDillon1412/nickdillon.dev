<?php

declare(strict_types=1);

use App\Enums\PureFinance\RecurringFrequency;
use App\Models\User;
use App\Models\PureFinance\Account;
use App\Models\PureFinance\Category;
use function Pest\Livewire\livewire;
use App\Models\PureFinance\Transaction;
use App\Enums\PureFinance\TransactionType;
use App\Livewire\PureFinance\TransactionForm;

beforeEach(function () {
    $user = User::factory()->create();

    if (Category::count() === 0) {
        Category::factory()->for($user)->count(5)->create();
    }

    Account::factory()
        ->for($user)
        ->has(Transaction::factory()->count(10))
        ->create();

    $this->actingAs($user);
});

it('can create a transaction', function () {
    livewire(TransactionForm::class)
        ->set('account_id', auth()->user()->accounts->first()->id)
        ->set('description', 'Test description')
        ->set('type', TransactionType::DEPOSIT)
        ->set('amount', 100)
        ->set('category_id', auth()->user()->categories->first()->id)
        ->set('date', now())
        ->set('notes', '')
        ->set('status', true)
        ->call('submit')
        ->assertHasNoErrors();
});

it('can edit a transaction', function () {
    livewire(TransactionForm::class, [
        'transaction' => auth()->user()->transactions->first()
    ])
        ->set('type', TransactionType::WITHDRAWAL)
        ->call('submit')
        ->assertHasNoErrors();
});

it('can make transaction recurring', function () {
    livewire(TransactionForm::class, [
        'transaction' => auth()->user()->transactions->first()
    ])
        ->set('date', now())
        ->set('is_recurring', true)
        ->set('frequency', RecurringFrequency::MONTHLY)
        ->set('recurring_end', now()->addMonth())
        ->call('submit')
        ->assertHasNoErrors();
});

test('component can render with transaction', function () {
    livewire(TransactionForm::class, [
        'transaction' => auth()->user()->transactions->first()
    ])
        ->assertHasNoErrors();
});

test('component can render', function () {
    livewire(TransactionForm::class)
        ->assertHasNoErrors();
});
