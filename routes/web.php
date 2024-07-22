<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'portfolio')->name('portfolio');

Route::view('/apps', 'apps')->name('apps');

Route::middleware(['auth'])->group(function () {
    Route::view('dashboard', 'dashboard')
        ->name('dashboard');

    Route::view('profile', 'profile')
        ->name('profile');
});

require __DIR__.'/auth.php';
