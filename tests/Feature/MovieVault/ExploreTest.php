<?php

declare(strict_types=1);

use App\Livewire\MovieVault\Explore;
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

it('can save new movie', function () {
    livewire(Explore::class)
        ->call('save', [
            'backdrop_path' => '/xJHokMbljvjADYdit5fK5VQsXEG.jpg',
            'id' => 157336,
            'title' => 'Interstellar',
            'original_title' => 'Interstellar',
            'overview' => 'Interstellar',
            'poster_path' => '/gEU2QniE6E77NI6lCU6MxlNBvIx.jpg',
            'media_type' => 'movie',
            'release_date' => '2014-11-05',
        ])
        ->assertDispatched('showAlertPopup')
        ->assertNoRedirect()
        ->assertHasNoErrors();
});

it('can save new tv show', function () {
    livewire(Explore::class)
        ->call('save', [
            'backdrop_path' => '/xJHokMbljvjADYdit5fK5VQsXEG.jpg',
            'id' => 1573367,
            'name' => 'Suits',
            'original_name' => 'Suits',
            'overview' => 'Suits',
            'poster_path' => '/gEU2QniE6E77NI6lCU6MxlNBvIx.jpg',
            'media_type' => 'tv',
            'first_air_date' => '2010-07-10',
        ])
        ->assertDispatched('showAlertPopup')
        ->assertNoRedirect()
        ->assertHasNoErrors();
});

it('can show popup alert when record already exists in vault', function () {
    livewire(Explore::class)
        ->call('save', [
            'id' => 1234,
            'title' => 'Test Movie',
        ])
        ->assertDispatched('showAlertPopup')
        ->assertHasNoErrors();
});

test('component can render', function () {
    livewire(Explore::class)
        ->assertHasNoErrors();
});
