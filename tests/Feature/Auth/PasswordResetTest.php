<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Livewire\Volt\Volt;
use Illuminate\Support\Facades\Notification;
use Illuminate\Auth\Notifications\ResetPassword;

test('reset password link screen can be rendered', function () {
    $response = $this->get('/forgot-password');

    $response
        ->assertSeeVolt('pages.auth.forgot-password')
        ->assertStatus(200);
});

test('reset password link can be requested', function () {
    Notification::fake();

    $user = User::factory()->create();

    Volt::test('pages.auth.forgot-password')
        ->set('email', $user->email)
        ->call('sendPasswordResetLink');

    Notification::assertSentTo($user, ResetPassword::class);
});

test('reset password screen can be rendered', function () {
    Notification::fake();

    $user = User::factory()->create();

    Volt::test('pages.auth.forgot-password')
        ->set('email', $user->email)
        ->call('sendPasswordResetLink');

    Notification::assertSentTo($user, ResetPassword::class, function ($notification) {
        $response = $this->get('/reset-password/' . $notification->token);

        $response
            ->assertSeeVolt('pages.auth.reset-password')
            ->assertStatus(200);

        return true;
    });
});

test('password can be reset with valid token', function () {
    Notification::fake();

    $user = User::factory()->create();

    Volt::test('pages.auth.forgot-password')
        ->set('email', $user->email)
        ->call('sendPasswordResetLink');

    Notification::assertSentTo($user, ResetPassword::class, function ($notification) use ($user) {
        $component = Volt::test('pages.auth.reset-password', ['token' => $notification->token])
            ->set('email', $user->email)
            ->set('password', 'Password')
            ->set('password_confirmation', 'Password');

        $component->call('resetPassword');

        $component
            ->assertRedirect('/login')
            ->assertHasNoErrors();

        return true;
    });
});
