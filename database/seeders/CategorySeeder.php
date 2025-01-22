<?php

namespace Database\Seeders;

use App\Models\PureFinance\Category;
use Illuminate\Database\Seeder;
use App\Models\User;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::factory()->create();

        $categories = collect([
            // 'Auto & Transport',
            'Entertainment',
            // 'Food',
            // 'Home',
            // 'Health',
            // 'Maintenance',
            // 'Personal Care',
            // 'Personal Income',
            // 'Pets',
            // 'Shopping',
            // 'Travel',
            // 'Utilities',
        ]);

        $categories->each(function (string $category) use ($user): void {
            $parent_category = Category::factory()->for($user)->create(['name' => $category]);

            Category::factory()
                ->for($user)
                ->count(2)
                ->create([
                    'parent_id' => $parent_category->id,
                ]);
        });
    }
}
