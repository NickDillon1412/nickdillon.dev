<?php

namespace Database\Factories\PureFinance;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PureFinance\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->randomElement([
                'Eating Out',
                'Groceries',
                'Rent',
                'Mortgage',
                'Utilities',
                'Clothes',
                'Entertainment',
                'Travel',
                'Car Insurance',
                'Car Payment',
                'Gas',
                'Maintenance'
            ]),
        ];
    }
}
