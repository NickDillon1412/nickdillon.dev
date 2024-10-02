<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rules\RequiredIf;

class SignUp
{
	public function handle(array $attributes): RedirectResponse
	{
		$validator = Validator::make($attributes, [
			'name' => ['required', 'string', 'max:255'],
			'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
			'password' => [new RequiredIf(!isset($attributes['github_id'])), 'confirmed', Password::defaults()],
			'github_id' => ['max:255'],
			'github_token' => [new RequiredIf(isset($attributes['github_id'])), 'max:255'],
		]);

		if ($validator->fails()) {
			return redirect(route('sign-up'))->withErrors($validator);
		}

		$user = User::create([
			'name' => $attributes['name'],
			'email' => $attributes['email'],
			'password' => $attributes['password'] ?? null,
			'github_id' => $attributes['github_id'] ?? null,
			'github_token' => $attributes['github_token'] ?? null,
		]);

		event(new Registered($user));

		Auth::login($user);

		return redirect(route('apps', absolute: false));
	}
}
