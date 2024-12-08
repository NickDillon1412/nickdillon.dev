<?php

declare(strict_types=1);

use App\Models\User;
use App\Models\PureFinance\Account;
use function Pest\Livewire\livewire;
use App\Enums\PureFinance\AccountType;
use App\Livewire\PureFinance\AccountForm;

beforeEach(function () {
    $this->actingAs(
        User::factory()
            ->hasAccounts(Account::factory())
            ->create()
    );
});

it('can create an account', function () {
    livewire(AccountForm::class)
        ->set('name', 'Checking Account')
        ->set('type', AccountType::CHECKING)
        ->call('submit')
        ->assertHasNoErrors();

    $this->assertDatabaseCount('accounts', 2);
});

it('can update an account', function () {
    livewire(AccountForm::class, ['account' => Account::first()])
        ->set('name', 'Updated name')
        ->call('submit')
        ->assertHasNoErrors();

    $this->assertDatabaseCount('accounts', 1);
});

test('component can render', function () {
    livewire(AccountForm::class)
        ->assertHasNoErrors();
});
