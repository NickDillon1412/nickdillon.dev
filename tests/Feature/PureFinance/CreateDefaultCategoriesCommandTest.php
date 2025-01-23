<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Support\Facades\Artisan;

it('creates the default categories for a user', function () {
    User::factory()->create();

    $exit_code = Artisan::call('create-default-categories');

    $this->assertEquals(0, $exit_code);
});
