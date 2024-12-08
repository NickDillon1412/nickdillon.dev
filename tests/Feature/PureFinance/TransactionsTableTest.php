<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Support\Str;
use App\Models\PureFinance\Account;
use Illuminate\Support\Facades\URL;
use function Pest\Livewire\livewire;
use App\Models\PureFinance\Transaction;
use App\Livewire\PureFinance\TransactionsTable;

beforeEach(function () {
    $this->actingAs(
        User::factory()
            ->hasAccounts(
                Account::factory()
                    ->hasTransactions(
                        Transaction::factory()->count(100)
                    )
            )
            ->create()
    );
});

it('can update search', function () {
    livewire(TransactionsTable::class)
        ->set('search', 'Test')
        ->assertHasNoErrors();

    expect(Str::contains(URL::current(), '?page'))
        ->toBeFalse();
});

it('can update status', function () {
    livewire(TransactionsTable::class)
        ->set('status', 'cleared')
        ->assertHasNoErrors();

    expect(Str::contains(URL::current(), '?page'))
        ->toBeFalse();
});

it('can sort by account name', function () {
    livewire(TransactionsTable::class)
        ->call('sortBy', 'account')
        ->assertHasNoErrors();

    expect(Str::contains(URL::current(), '?page'))
        ->toBeFalse();
});

it('can sort by category name', function () {
    livewire(TransactionsTable::class)
        ->call('sortBy', 'category')
        ->assertHasNoErrors();

    expect(Str::contains(URL::current(), '?page'))
        ->toBeFalse();
});

it('can sort by amount', function () {
    livewire(TransactionsTable::class)
        ->call('sortBy', 'amount')
        ->assertHasNoErrors();

    expect(Str::contains(URL::current(), '?page'))
        ->toBeFalse();
});

it('can sort by description', function () {
    livewire(TransactionsTable::class)
        ->call('sortBy', 'description')
        ->assertHasNoErrors();

    expect(Str::contains(URL::current(), '?page'))
        ->toBeFalse();
});

it('can sort by date', function () {
    livewire(TransactionsTable::class)
        ->call('sortBy', 'date')
        ->assertHasNoErrors();

    expect(Str::contains(URL::current(), '?page'))
        ->toBeFalse();
});

it('can sort by status', function () {
    livewire(TransactionsTable::class)
        ->set('sort_col', 'status')
        ->call('sortBy', 'status')
        ->assertHasNoErrors();

    expect(Str::contains(URL::current(), '?page'))
        ->toBeFalse();
});

test('component can render with account', function () {
    livewire(TransactionsTable::class, ['account' => Account::first()])
        ->assertHasNoErrors();
});

test('component can render', function () {
    livewire(TransactionsTable::class)
        ->assertHasNoErrors();
});
