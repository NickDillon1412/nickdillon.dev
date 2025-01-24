<?php

namespace Database\Seeders;

use App\Models\PureFinance\Transaction;
use App\Models\PureFinance\Tag;
use Illuminate\Database\Seeder;
use App\Models\User;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tag::factory()
            ->for(User::first())
            ->create([
                'name' => 'Groceries',
            ]);

        Tag::factory()
            ->for(User::first())
            ->create([
                'name' => 'Bills',
            ]);

        Tag::factory()
            ->for(User::first())
            ->create([
                'name' => 'Entertainment',
            ]);

        foreach (Transaction::get() as $transaction) {
            Tag::get()->random(2)->each(function (Tag $tag) use ($transaction): void {
                $transaction->tags()->attach($tag->id);
            });
        }
    }
}
