<?php

declare(strict_types=1);

use App\Livewire\MovieVault\Wishlist;
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
    livewire(Wishlist::class)
        ->set('search', 'Suits')
        ->assertHasNoErrors();

    expect(Str::contains(URL::current(), '?page'))
        ->toBeFalse();
});

it('can add a record to vault', function () {
    livewire(Wishlist::class)
        ->call('addToVault', Vault::first())
        ->assertDispatched('showAlertPopup')
        ->assertHasNoErrors()
        ->assertNoRedirect();
});

test('component can render', function () {
    livewire(Wishlist::class)
        ->assertHasNoErrors();
});