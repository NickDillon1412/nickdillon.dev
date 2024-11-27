<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Livewire\Volt\Volt;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as SocialiteUser;

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
        ->set('password', 'Password')
        ->set('password_confirmation', 'Password');

    $component->call('signup');

    $component->assertRedirect(route('apps', absolute: false));

    $this->assertAuthenticated();
});

describe('Register Using OAuth Provider', function () {
    test('redirect to github for authorization', function () {
        Socialite::shouldReceive('driver->redirect')->once();

        $this->get('github/auth/redirect');

        expect(true)->toBeTrue();
    });

    test('register successfully', function () {
        $fake_github_user = (new SocialiteUser)->map(attributes: [
            'id' => 'id123',
            'name' => 'Test User',
            'email' => 'test@example.com',
            'token' => 'token123',
        ]);

        Socialite::shouldReceive('driver->user')->once()->andReturn($fake_github_user);

        $this->get('github/auth/callback')->assertRedirect(route('apps'));

        $this->assertAuthenticated();
    });

    test('validator fails', function () {
        $fake_github_user = (new SocialiteUser)->map(attributes: [
            'id' => 'id123',
            'name' => 'Test User',
            'email' => null,
            'token' => 'token123',
        ]);

        Socialite::shouldReceive('driver->user')->once()->andReturn($fake_github_user);

        $this->get('github/auth/callback')->assertRedirect(route('sign-up'));
    });

    test('add Github credentials to existing account.', function () {
        // given I have a user
        $user = User::factory()->create(['email' => 'test@example.com']);

        $github_user = fakeOAuthUser();

        // if they grant authorization to Github
        $this->get('github/auth/callback')->assertRedirect(route('apps'));

        $this->assertAuthenticated();

        // their user record should be updated with github_id credentials.
        expect($user->refresh()->provider_id)->toBe($github_user->getId());

        expect($user->provider_token)->toBe($github_user->token);
    });

    test('login existing account', function () {
        $user = User::factory()->create(['provider_id' => 'id123', 'provider_token' => 'oldtoken123']);

        $github_user = fakeOAuthUser(['provider_token' => 'newtoken123']);

        $this->get('github/auth/callback')->assertRedirect(route('apps'));

        $this->assertAuthenticated();

        expect($user->refresh()->provider_id)->toBe($github_user->getId());

        expect($user->refresh()->provider_token)->toBe($github_user->token);
    });
});

function fakeOAuthUser(array $attributes = []): SocialiteUser
{
    $fake_provider_user = (new SocialiteUser)->map(attributes: array_merge([
        'id' => 'id123',
        'name' => 'Test User',
        'email' => 'test@example.com',
        'token' => 'newtoken123',
    ], $attributes));

    Socialite::shouldReceive('driver->user')->once()->andReturn($fake_provider_user);

    return $fake_provider_user;
}
