<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Http\UploadedFile;
use App\Models\PureFinance\Account;
use App\Models\PureFinance\Category;
use function Pest\Livewire\livewire;
use App\Models\PureFinance\Transaction;
use App\Enums\PureFinance\TransactionType;
use App\Enums\PureFinance\RecurringFrequency;
use App\Livewire\PureFinance\TransactionForm;

beforeEach(function () {
    $this->withoutDefer();

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
        ->has(Transaction::factory()->count(10))
        ->create();

    $this->actingAs($user);
});

it('can create a transaction', function () {
    livewire(TransactionForm::class)
        ->set('account_id', auth()->user()->accounts->first()->id)
        ->set('payee', 'Test payee')
        ->set('type', TransactionType::DEPOSIT)
        ->set('amount', 100)
        ->set('category_id', auth()->user()->categories->first()->id)
        ->set('date', now())
        ->set('notes', '')
        ->set('status', true)
        ->call('submit')
        ->assertHasNoErrors();
});

it('can edit a transaction', function () {
    livewire(TransactionForm::class, [
        'transaction' => auth()->user()->transactions->first()
    ])
        ->set('type', TransactionType::WITHDRAWAL)
        ->call('submit')
        ->assertHasNoErrors();
});

it('can make transaction recurring by month', function () {
    livewire(TransactionForm::class, [
        'transaction' => auth()->user()->transactions->first()
    ])
        ->set('date', now())
        ->set('is_recurring', true)
        ->set('frequency', RecurringFrequency::MONTHLY)
        ->set('recurring_end', now()->addMonth())
        ->call('submit')
        ->assertHasNoErrors();
});

it('can make transaction recurring by year', function () {
    livewire(TransactionForm::class, [
        'transaction' => auth()->user()->transactions->first()
    ])
        ->set('date', now())
        ->set('is_recurring', true)
        ->set('frequency', RecurringFrequency::YEARLY)
        ->set('recurring_end', now()->addYear())
        ->call('submit')
        ->assertHasNoErrors();
});

it('can see validation error if end date is before start date', function () {
    livewire(TransactionForm::class, [
        'transaction' => auth()->user()->transactions->first()
    ])
        ->set('date', now())
        ->set('is_recurring', true)
        ->set('frequency', RecurringFrequency::MONTHLY)
        ->set('recurring_end', now()->subWeek())
        ->call('submit')
        ->assertSee('The end date must be after the start date.')
        ->assertHasErrors();
});

it('can push to attachments', function () {
    $file = UploadedFile::fake()->image('pure-finance/files/logo.png');

    livewire(TransactionForm::class)
        ->call('pushToAttachments', [
            'name' => 'logo.png',
            'size' => $file->getSize()
        ])
        ->assertHasNoErrors();
});

it('can delete an attachment', function () {
    $file = UploadedFile::fake()->image('pure-finance/files/logo.png');

    livewire(TransactionForm::class, [
        'transaction' => auth()->user()->transactions->first()
    ])
        ->call('deleteAttachment', 'logo.png')
        ->assertHasNoErrors();
});

it('can transfer from one account to another', function () {
    livewire(TransactionForm::class)
        ->set('account_id', auth()->user()->accounts->first()->id)
        ->set('payee', 'Test payee')
        ->set('type', TransactionType::TRANSFER)
        ->set('transfer_to', auth()->user()->accounts->last()->id)
        ->set('amount', 100)
        ->set('category_id', auth()->user()->categories->first()->id)
        ->set('date', now())
        ->set('notes', '')
        ->set('status', true)
        ->call('submit')
        ->assertHasNoErrors();
});

test('component can render with transaction', function () {
    livewire(TransactionForm::class, [
        'transaction' => auth()->user()->transactions->first()
    ])
        ->assertHasNoErrors();
});

test('component can render with account and transaction', function () {
    livewire(TransactionForm::class, [
        'account' => auth()->user()->accounts->first(),
        'transaction' => auth()->user()->transactions->first()
    ])
        ->assertHasNoErrors();
});

test('component can render', function () {
    livewire(TransactionForm::class)
        ->assertHasNoErrors();
});
