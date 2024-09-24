<?php

declare(strict_types=1);

use App\Models\User;
use App\Models\MovieVault\Vault;
use App\Livewire\MovieVault\VaultDetails;

use function Pest\Laravel\actingAs;
use function Pest\Livewire\livewire;

beforeEach(function () {
    actingAs(
        User::factory()
            ->hasVaults(1)
            ->create()
    );
});

it('can add to vault', function () {
    livewire(VaultDetails::class, ['vault' => Vault::first()])
        ->call('addToVault', Vault::first())
        ->assertHasNoErrors()
        ->assertRedirect(route('movie-vault.my-vault'));

    $this->assertDatabaseCount('vaults', 1);
});

it('can add to wishlist', function () {
    livewire(VaultDetails::class, ['vault' => Vault::first()])
        ->call('addToWishlist', Vault::first())
        ->assertHasNoErrors()
        ->assertRedirect(route('movie-vault.wishlist'));

    $this->assertDatabaseCount('vaults', 1);
});

it('can delete a record', function () {
    livewire(VaultDetails::class, ['vault' => Vault::first()])
        ->set('previous_url', '/my-vault')
        ->call('delete', Vault::first())
        ->assertHasNoErrors()
        ->assertRedirect(route('movie-vault.my-vault'));
});

test('component can render', function () {
    livewire(VaultDetails::class, ['vault' => Vault::first()])
        ->set('previous_url', '/test')
        ->assertHasNoErrors();
});
