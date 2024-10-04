<?php

use Livewire\Volt\Volt;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SocialiteController;

Route::middleware('guest')->group(function () {
    Route::controller(SocialiteController::class)
        ->name('auth.')
        ->group(function () {
            Route::get("{provider}/auth/redirect", 'create')->name('redirect');

            Route::get('{provider}/auth/callback', 'store')->name('callback');
        });

    Volt::route('sign-up', 'pages.auth.sign-up')
        ->name('sign-up');

    Volt::route('login', 'pages.auth.login')
        ->name('login');

    Volt::route('forgot-password', 'pages.auth.forgot-password')
        ->name('password.request');

    Volt::route('reset-password/{token}', 'pages.auth.reset-password')
        ->name('password.reset');
});

Route::middleware('auth')->group(function () {
    Volt::route('confirm-password', 'pages.auth.confirm-password')
        ->name('password.confirm');
});
