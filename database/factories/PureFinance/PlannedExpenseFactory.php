<?php

namespace Database\Factories\PureFinance;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\PureFinance\Category;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PureFinance\PlannedSpending>
 */
class PlannedExpenseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => Category::first()->name,
            'category_id' => Category::first(),
            'monthly_amount' => $this->faker->randomFloat(2, 0, 100)
        ];
    }
}
