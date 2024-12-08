<?php

declare(strict_types=1);

use App\Models\User;
use App\Models\PureFinance\Account;
use function Pest\Livewire\livewire;
use App\Livewire\PureFinance\AccountOverview;

beforeEach(function () {
    $this->actingAs(
        User::factory()
            ->hasAccounts(Account::factory())
            ->create()
    );
});

test('can see account form', function () {
    livewire(AccountOverview::class, ['account' => Account::first()])
        ->assertSeeLivewire('pure-finance.account-form')
        ->assertHasNoErrors();
});

test('can see transactions table', function () {
    livewire(AccountOverview::class, ['account' => Account::first()])
        ->assertSeeLivewire('pure-finance.transactions-table')
        ->assertHasNoErrors();
});

test('component can render', function () {
    livewire(AccountOverview::class, ['account' => Account::first()])
        ->assertHasNoErrors();
});
