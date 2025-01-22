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
            ->for(User::first())
            ->count(4)
            ->create();

        Transaction::factory()
            ->count(500)
            ->recycle($accounts)
            ->recycle(Category::get())
            ->create();
    }
}
