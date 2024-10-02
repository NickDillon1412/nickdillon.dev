<?php

use Livewire\Volt\Volt;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Socialite\GitHubAuthController;

Route::prefix('github')
    ->name('github.')
    ->group(function () {
        Route::get('auth/redirect', [GitHubAuthController::class, 'create'])->name('redirect');

        Route::get('auth/callback', [GitHubAuthController::class, 'store'])->name('callback');
    });

Route::middleware('guest')->group(function () {
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
