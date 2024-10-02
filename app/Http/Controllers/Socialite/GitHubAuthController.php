<?php

declare(strict_types=1);

namespace App\Http\Controllers\Socialite;

use App\Models\User;
use App\Actions\SignUp;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Contracts\User as SocialiteUser;

class GitHubAuthController extends Controller
{
    public function create(): RedirectResponse
    {
        return Socialite::driver('github')->redirect();
    }

    public function store(SignUp $action): RedirectResponse
    {
        $github_user = Socialite::driver('github')->user();

        // If the user is signed in, associate the GitHub
        // token with their account.
        if ($user = Auth::user()) {
            return $this->login($user, $github_user);
        }

        // If, upon signing up, the GitHub token already exists in our db,
        // associate those credentials with that account.
        if ($user = User::where('github_id', $github_user->getId())->first()) {
            return $this->login($user, $github_user);
        }

        // If we already have an account for that GitHub email address, ask
        // the user to login and try again.
        if (User::where(['email' => $github_user->getEmail(), 'github_id' => null])->exists()) {
            return redirect(route('sign-up'))->withErrors([
                'email' => 'An account for this email already exists. Please login and visit your profile settings page to add Github authentication.',
            ]);
        }

        return $action->handle([
            'name' => $github_user->getName(),
            'email' => $github_user->getEmail(),
            'github_id' => $github_user->getId(),
            'github_token' => $github_user->token
        ]);
    }

    protected function login(User $user, SocialiteUser $github_user): RedirectResponse
    {
        $user->update([
            'github_id' => $github_user->getId(),
            'github_token' => $github_user->token,
        ]);

        Auth::login($user);

        return redirect(route('apps'));
    }
}
