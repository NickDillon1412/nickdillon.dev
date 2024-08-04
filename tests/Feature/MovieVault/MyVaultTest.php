<?php

declare(strict_types=1);

use App\Livewire\MovieVault\MyVault;
use App\Models\MovieVault\Vault;
use App\Models\User;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

use function Pest\Laravel\actingAs;
use function Pest\Livewire\livewire;

beforeEach(function () {
    actingAs(
        User::factory()
            ->hasVaults(1)
            ->create()
    );
});

it('can update search', function () {
    livewire(MyVault::class)
        ->set('search', 'Suits')
        ->assertHasNoErrors();

    expect(Str::contains(URL::current(), '?page'))
        ->toBeFalse();
});

it('can add to wishlist', function () {
    livewire(MyVault::class)
        ->call('addToWishlist', Vault::first())
        ->assertDispatched('showAlertPopup')
        ->assertHasNoErrors();

    $this->assertDatabaseCount('vaults', 1);
});

it('can delete a vault record', function () {
    livewire(MyVault::class)
        ->call('delete', Vault::first())
        ->assertDispatched('showAlertPopup')
        ->assertHasNoErrors();

    $this->assertDatabaseCount('vaults', 0);
});

test('component can render', function () {
    livewire(MyVault::class)
        ->assertHasNoErrors();
});
