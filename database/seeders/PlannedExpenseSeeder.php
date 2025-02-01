<?php

namespace Database\Seeders;

use App\Models\PureFinance\PlannedExpense;
use Illuminate\Database\Seeder;

class PlannedExpenseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PlannedExpense::factory()->create();
    }
}
