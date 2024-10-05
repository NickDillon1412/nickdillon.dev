<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;
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
			'password' => [new RequiredIf(!isset($attributes['provider_id'])), 'confirmed', Password::defaults()],
			'provider' => ['string'],
			'provider_id' => ['max:255'],
			'provider_token' => [new RequiredIf(isset($attributes['provider_id'])), 'max:255'],
		]);

		if ($validator->fails()) return redirect(route('sign-up'))->withErrors($validator);

		$user = User::create([
			'name' => $attributes['name'],
			'email' => $attributes['email'],
			'password' => $attributes['password'] ?? null,
			'provider' => $attributes['provider'] ?? null,
			'provider_id' => $attributes['provider_id'] ?? null,
			'provider_token' => $attributes['provider_token'] ?? null,
		]);

		event(new Registered($user));

		Auth::login($user);

		return redirect(route('apps', absolute: false));
	}
}
