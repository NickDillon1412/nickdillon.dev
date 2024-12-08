<?php

declare(strict_types=1);

use App\Models\User;
use App\Models\PureFinance\Account;
use function Pest\Livewire\livewire;
use App\Livewire\PureFinance\AccountRow;

beforeEach(function () {
    $this->actingAs(
        User::factory()
            ->hasAccounts(Account::factory())
            ->create()
    );
});

test('can see rows', function () {
    livewire(AccountRow::class, ['account' => Account::first()])
        ->assertSee(Account::first()->title)
        ->assertHasNoErrors();
});

test('component can render', function () {
    livewire(AccountRow::class, ['account' => Account::first()])
        ->assertHasNoErrors();
});
