<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Http\UploadedFile;
use App\Models\PureFinance\Account;
use App\Models\PureFinance\Category;
use function Pest\Livewire\livewire;
use App\Models\PureFinance\Transaction;
use Illuminate\Support\Facades\Storage;
use App\Livewire\PureFinance\Attachments;

beforeEach(function () {
    Storage::fake('s3');

    $user = User::factory()->create();

    if (Category::count() === 0) {
        $categories = collect([
            'Personal Income',
            'Pets',
            'Shopping',
            'Travel',
            'Utilities',
        ]);

        $categories->each(function (string $name) use ($user): void {
            Category::factory()->for($user)->create([
                'name' => $name
            ]);
        });
    }

    Account::factory()
        ->for($user)
        ->has(Transaction::factory()->state([
            'attachments' => [
                [
                    'name' => Storage::disk('s3')->putFile(
                        'attachments',
                        UploadedFile::fake()->image('test1.jpg')
                    )
                ],
                [
                    'name' => Storage::disk('s3')->putFile(
                        'attachments',
                        UploadedFile::fake()->image('test2.jpg')
                    )
                ]
            ]
        ])->count(10))
        ->create();

    $this->actingAs($user);
});

it('can load attachments', function () {
    $attachments = auth()->user()->transactions->first()->attachments;

    livewire(Attachments::class)
        ->call('loadAttachments', $attachments)
        ->assertSet('attachments', $attachments)
        ->assertHasNoErrors();
});

test('component can render', function () {
    livewire(Attachments::class)
        ->assertHasNoErrors();
});
