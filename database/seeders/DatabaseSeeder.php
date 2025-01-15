<?php

namespace Database\Seeders;

<<<<<<< HEAD
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
=======
>>>>>>> ac530820eb27da6531ec848ef84fc8321dc2e2c6
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([TransactionSeeder::class, TagSeeder::class]);
    }
}
