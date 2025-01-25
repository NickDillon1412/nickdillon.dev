<?php

declare(strict_types=1);

use App\Models\User;
use App\Models\PureFinance\Tag;
use function Pest\Livewire\livewire;
use App\Livewire\PureFinance\TagForm;

beforeEach(function () {
    $user = User::factory()->create();

    Tag::factory()->for($user)->count(5)->create();

    $this->actingAs($user);
});

it('can create a tag', function () {
    livewire(TagForm::class)
        ->set('name', 'Test tag')
        ->call('submit')
        ->assertDispatched('tag-saved')
        ->assertHasNoErrors();
});

it('can edit a tag', function () {
    livewire(TagForm::class)
        ->call('loadTag', auth()->user()->tags->first()->toArray())
        ->set('name', 'Test tag updated')
        ->call('submit')
        ->assertDispatched('tag-saved')
        ->assertHasNoErrors();
});

test('component can render', function () {
    livewire(TagForm::class)
        ->assertHasNoErrors();
});
