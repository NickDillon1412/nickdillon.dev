<?php

namespace Database\Factories\PureFinance;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\PureFinance\TransactionType;
use App\Models\PureFinance\Category;
use App\Models\PureFinance\Account;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PureFinance\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'account_id' => Account::count() > 0
                ? Account::inRandomOrder()->first()->id
                : Account::factory(),
            'category_id' => Category::count() > 0
                ? Category::inRandomOrder()->first()->id
                : Category::factory(),
            'type' => Arr::random(TransactionType::cases()),
            'amount' => $this->faker->randomFloat(2, 0, 100),
            'description' => $this->faker->text(30),
            'date' => $this->faker->date(),
            'notes' => $this->faker->paragraph(5),
            'status' => Arr::random([true, false])
        ];
    }
}
