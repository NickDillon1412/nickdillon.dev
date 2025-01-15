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
            ->hasVaults(Vault::factory())
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
