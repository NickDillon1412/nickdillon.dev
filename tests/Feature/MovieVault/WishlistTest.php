<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Support\Str;
use App\Models\MovieVault\Vault;
use Illuminate\Support\Facades\URL;
use App\Livewire\MovieVault\Wishlist;

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
        ->assertHasNoErrors()
        ->assertNoRedirect();
});

it('can select genres', function () {
    livewire(Wishlist::class)
        ->set('selected_genres', ['Comedy', 'Crime'])
        ->assertHasNoErrors();
});

test('component can render', function () {
    livewire(Wishlist::class)
        ->assertHasNoErrors();
});
