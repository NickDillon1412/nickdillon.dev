<?php

declare(strict_types=1);

namespace App\Console\Commands\PureFinance;

use App\Models\User;
use Illuminate\Console\Command;
use App\Actions\PureFinance\CreateDefaultCategories;

class CreateDefaultCategoriesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create-default-categories';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create default categories for all users';

    /**
     * Execute the console command.
     */
    public function handle(CreateDefaultCategories $action): void
    {
        User::query()
            ->with('categories')
            ->get()
            ->each(function (User $user) use ($action): void {
                $action->handle($user);
            });
    }
}
