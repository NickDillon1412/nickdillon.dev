<?php

declare(strict_types=1);

use App\Livewire\MovieVault\VaultDetails;
use App\Models\MovieVault\Vault;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Livewire\livewire;

beforeEach(function () {
    actingAs(
        User::factory()
            ->hasVaults(1)
            ->create()
    );
});

it('can delete a record from vault', function () {
    $vault = Vault::first();

    livewire(VaultDetails::class, ['vault' => $vault])
        ->set('previous_url', '/test')
        ->call('delete', $vault)
        ->assertHasNoErrors()
        ->assertRedirect(route('movie-vault.my-vault'));
});

test('component can render', function () {
    livewire(VaultDetails::class, ['vault' => Vault::first()])
        ->set('previous_url', '/test')
        ->assertHasNoErrors();
});