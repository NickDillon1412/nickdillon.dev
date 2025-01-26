<?php

declare(strict_types=1);

use App\Models\User;
use App\Models\PureFinance\Tag;
use function Pest\Livewire\livewire;
use App\Livewire\PureFinance\TagTable;

beforeEach(function () {
    $user = User::factory()->create();

    Tag::factory()->for($user)->count(5)->create();

    $this->actingAs($user);
});

it('can search a tag', function () {
    livewire(TagTable::class)
        ->set('search', 'Pets')
        ->assertHasNoErrors();
});

it('can delete a tag', function () {
    livewire(TagTable::class)
        ->call('delete', auth()->user()->tags->first()->id)
        ->assertHasNoErrors();
});

test('component can render', function () {
    livewire(TagTable::class)
        ->assertHasNoErrors();
});
