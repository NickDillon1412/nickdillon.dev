<?php

namespace Database\Factories\PureFinance;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\PureFinance\AccountType;
use Illuminate\Support\Arr;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Account>
 */
class AccountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'type' => Arr::random(AccountType::cases()),
            'name' => Arr::random(['Cash', 'Checking', 'Credit Card', 'Savings']),
            'balance' => $this->faker->randomFloat(2, 500, 50000),
            'initial_balance' => 100000,
        ];
    }
}
