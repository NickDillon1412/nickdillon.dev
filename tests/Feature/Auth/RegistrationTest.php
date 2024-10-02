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
        ->set('password', 'password')
        ->set('password_confirmation', 'password');

    $component->call('signup');

    $component->assertRedirect(route('apps', absolute: false));

    $this->assertAuthenticated();
});

describe('Register Using Github', function () {
    test('redirect to Github for authorization', function () {
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
        $user = User::factory()->create();

        // and that user is signed in
        $this->actingAs($user);

        $github_user = fakeGithubUser();

        // if they grant authorization to Github
        $this->get('github/auth/callback');

        // their user record should be updated with github_id credentials.
        expect($user->refresh()->github_id)->toBe($github_user->getId());

        expect($user->github_token)->toBe($github_user->token);
    });

    test('login existing account', function () {
        $user = User::factory()->create(['github_id' => 'id123', 'github_token' => 'oldtoken123']);

        $github_user = fakeGithubUser(['github_token' => 'newtoken123']);

        $this->get('github/auth/callback')->assertRedirect(route('apps'));

        $this->assertAuthenticated();

        expect($user->refresh()->github_id)->toBe($github_user->getId());

        expect($user->refresh()->github_token)->toBe($github_user->token);
    });

    test('existing account with same email address requires login.', function () {
        User::factory()->create(['email' => 'test@example.com', 'github_id' => null]);

        fakeGithubUser(['email' => 'test@example.com']);

        $this->get('github/auth/callback')
            ->assertInvalid(['email' => 'An account for this email already exists. Please login and visit your profile settings page to add Github authentication.'])
            ->assertRedirect(route('sign-up'));
    });
});

function fakeGithubUser(array $attributes = []): SocialiteUser
{
    $fake_github_user = (new SocialiteUser)->map(attributes: array_merge([
        'id' => 'id123',
        'name' => 'Test User',
        'email' => 'test@example.com',
        'token' => 'newtoken123',
    ], $attributes));

    Socialite::shouldReceive('driver->user')->once()->andReturn($fake_github_user);

    return $fake_github_user;
}
