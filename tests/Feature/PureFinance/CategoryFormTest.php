<?php

declare(strict_types=1);

use App\Models\User;
use App\Models\PureFinance\Category;
use function Pest\Livewire\livewire;
use App\Livewire\PureFinance\CategoryForm;

beforeEach(function () {
    $user = User::factory()->create();

    if (Category::count() === 0) {
        $categories = collect([
            'Personal Income',
            'Pets',
            'Shopping',
            'Travel',
            'Utilities',
        ]);

        $categories->each(function (string $name) use ($user): void {
            Category::factory()->for($user)->create([
                'name' => $name
            ]);
        });
    }

    $this->actingAs($user);
});

it('can create a category', function () {
    livewire(CategoryForm::class)
        ->set('name', 'Test category')
        ->call('submit')
        ->assertDispatched('category-saved')
        ->assertHasNoErrors();
});

it('can create a child category', function () {
    $parent_category = User::first()->categories->whereNull('parent_id')->first();

    livewire(CategoryForm::class)
        ->set('parent_id', $parent_category->id)
        ->set('name', 'Dog Food')
        ->call('submit')
        ->assertDispatched('category-saved')
        ->assertHasNoErrors();
});

it('cannot create a duplicate category', function () {
    livewire(CategoryForm::class)
        ->set('name', 'Personal Income')
        ->call('submit')
        ->assertNotDispatched('category-saved')
        ->assertHasErrors();
});

it('can edit a category', function () {
    livewire(CategoryForm::class, [
        'category' => auth()->user()->categories->first()->toArray()
    ])
        ->set('name', 'Test category updated')
        ->call('submit')
        ->assertDispatched('category-saved')
        ->assertHasNoErrors();
});

test('component can render', function () {
    livewire(CategoryForm::class)
        ->assertHasNoErrors();
});
