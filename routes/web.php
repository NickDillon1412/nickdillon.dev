<?php

use App\Livewire\MovieVault\Explore;
use App\Livewire\MovieVault\MyVault;
use Illuminate\Support\Facades\Route;

Route::view('/', 'portfolio')->name('portfolio');

Route::view('/apps', 'apps')->name('apps');

Route::middleware(['auth'])->group(function () {
    Route::view('profile', 'profile')
        ->name('profile');

    Route::prefix('movie-vault')
        ->name('movie-vault.')
        ->group(function () {
            Route::get('my-vault', MyVault::class)->name('my-vault');

            Route::get('explore', Explore::class)->name('explore');
        });
});

require __DIR__.'/auth.php';
