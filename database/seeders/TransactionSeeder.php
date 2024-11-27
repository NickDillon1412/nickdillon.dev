<?php

namespace Database\Seeders;

use App\Models\PureFinance\Transaction;
use App\Models\PureFinance\Category;
use App\Models\PureFinance\Account;
use Illuminate\Database\Seeder;
use App\Models\User;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $accounts = Account::factory()
            ->for(User::factory())
            ->count(4)
            ->create();

        $categories = [
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
        ];

        $categories = collect($categories)->map(function ($name) {
            return Category::factory()->create(['name' => $name]);
        });

        Transaction::factory()
            ->count(500)
            ->recycle($accounts)
            ->recycle($categories)
            ->create();
    }
}
