<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use App\Actions\SignUp;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Contracts\User as SocialiteUser;

class SocialiteController extends Controller
{
    public function create(string $provider): RedirectResponse
    {
        return Socialite::driver($provider)->redirect();
    }

    public function store(string $provider, SignUp $action): RedirectResponse
    {
        $socialite_user = Socialite::driver($provider)->user();

        // If, upon signing up, the provider ID already exists in our db,
        // associate those credentials with that account.
        if ($user = User::where('provider_id', $socialite_user->getId())->first()) {
            return $this->login($user, $socialite_user, $provider);
        }

        // If we already have an account with that provider email address,
        // go ahead and login the user.
        if ($user = User::where('email', $socialite_user->getEmail())->first()) {
            return $this->login($user, $socialite_user, $provider);
        }

        return $action->handle([
            'name' => $socialite_user->getName(),
            'email' => $socialite_user->getEmail(),
            'provider' => $provider,
            'provider_id' => $socialite_user->getId(),
            'provider_token' => $socialite_user->token
        ]);
    }

    private function login(User $user, SocialiteUser $socialite_user, string $provider): RedirectResponse
    {
        $user->update([
            'provider' => $provider,
            'provider_id' => $socialite_user->getId(),
            'provider_token' => $socialite_user->token,
        ]);

        Auth::login($user);

        return redirect(route('apps'));
    }
}
