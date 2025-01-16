<?php

declare(strict_types=1);

use App\Models\User;
use App\Models\PureFinance\Account;
use function Pest\Livewire\livewire;
use App\Livewire\PureFinance\Accounts;

beforeEach(function () {
    $this->actingAs(User::factory()->create());
});

test('can see accounts', function () {
    Account::factory()
        ->for(User::first())
        ->create();

    livewire(Accounts::class)
        ->assertSee(Account::first()->title)
        ->assertHasNoErrors();

    $this->assertDatabaseCount('accounts', 1);
});

test('no accounts found', function () {
    livewire(Accounts::class)
        ->assertDontSee(Account::first()?->title)
        ->assertSee('No accounts found...')
        ->assertHasNoErrors();

    $this->assertDatabaseCount('accounts', 0);
});

test('component can render', function () {
    livewire(Accounts::class)
        ->assertHasNoErrors();
});
