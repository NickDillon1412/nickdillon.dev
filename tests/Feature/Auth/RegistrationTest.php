<?php

namespace Tests\Feature\Auth;

use Livewire\Volt\Volt;

test('registration screen can be rendered', function () {
    $response = $this->get('/sign-up');

    $response
        ->assertOk()
        ->assertSeeVolt('pages.auth.sign-up');
});

test('new users can sign up', function () {
    $component = Volt::test('pages.auth.sign-up')
        ->set('name', 'Test User')
        ->set('email', 'test@example.com')
        ->set('password', 'password')
        ->set('password_confirmation', 'password');

    $component->call('signup');

    $component->assertRedirect(route('apps', absolute: false));

    $this->assertAuthenticated();
});
