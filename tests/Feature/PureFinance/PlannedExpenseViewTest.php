<?php

declare(strict_types=1);

use App\Models\User;
use App\Models\PureFinance\Category;
use function Pest\Livewire\livewire;
use App\Models\PureFinance\PlannedExpense;
use App\Livewire\PureFinance\PlannedExpenseView;

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

test('component can render', function () {
    livewire(PlannedExpenseView::class, ['expense' => PlannedExpense::factory()->create()])
        ->assertHasNoErrors();
});
