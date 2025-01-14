<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Support\Str;
use App\Models\PureFinance\Account;
use Illuminate\Support\Facades\URL;
use App\Models\PureFinance\Category;
use function Pest\Livewire\livewire;
use App\Models\PureFinance\Transaction;
use App\Livewire\PureFinance\TransactionTable;

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

it('can update search', function () {
    livewire(TransactionTable::class)
        ->set('search', 'Test')
        ->assertHasNoErrors();

    expect(Str::contains(URL::current(), '?page'))
        ->toBeFalse();
});

it('can update status', function () {
    livewire(TransactionTable::class)
        ->set('status', 'cleared')
        ->assertHasNoErrors();

    expect(Str::contains(URL::current(), '?page'))
        ->toBeFalse();
});

it('can sort by account name', function () {
    livewire(TransactionTable::class)
        ->call('sortBy', 'account')
        ->assertHasNoErrors();

    expect(Str::contains(URL::current(), '?page'))
        ->toBeFalse();
});

it('can sort by category name', function () {
    livewire(TransactionTable::class)
        ->call('sortBy', 'category')
        ->assertHasNoErrors();

    expect(Str::contains(URL::current(), '?page'))
        ->toBeFalse();
});

it('can sort by type', function () {
    livewire(TransactionTable::class)
        ->call('sortBy', 'type')
        ->assertHasNoErrors();

    expect(Str::contains(URL::current(), '?page'))
        ->toBeFalse();
});

it('can sort by amount', function () {
    livewire(TransactionTable::class)
        ->call('sortBy', 'amount')
        ->assertHasNoErrors();

    expect(Str::contains(URL::current(), '?page'))
        ->toBeFalse();
});

it('can sort by description', function () {
    livewire(TransactionTable::class)
        ->call('sortBy', 'description')
        ->assertHasNoErrors();

    expect(Str::contains(URL::current(), '?page'))
        ->toBeFalse();
});

it('can sort by date', function () {
    livewire(TransactionTable::class)
        ->call('sortBy', 'date')
        ->assertHasNoErrors();

    expect(Str::contains(URL::current(), '?page'))
        ->toBeFalse();
});

it('can sort by status', function () {
    livewire(TransactionTable::class)
        ->set('sort_col', 'status')
        ->call('sortBy', 'status')
        ->assertHasNoErrors();

    expect(Str::contains(URL::current(), '?page'))
        ->toBeFalse();
});

it('can delete a transaction', function () {
    livewire(TransactionTable::class)
        ->call('delete', Transaction::first()->id)
        ->assertHasNoErrors();
});

test('component can render with account', function () {
    livewire(TransactionTable::class, ['account' => Account::first()])
        ->assertHasNoErrors();
});

test('component can render', function () {
    livewire(TransactionTable::class)
        ->assertHasNoErrors();
});
