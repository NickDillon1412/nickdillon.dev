<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('apps', absolute: false), navigate: true);
    }
}; ?>

<div>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <x-auth-card submit="login">
        <x-slot:header>
            <h1 class="flex justify-center mb-6 text-2xl font-semibold text-gray-700 dark:text-gray-100">
                Login
            </h1>
        </x-slot:header>

        <x-slot:content>
            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input wire:model="form.email" id="email" class="block w-full mt-1" type="email" name="email"
                    required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input wire:model="form.password" id="password" class="block w-full mt-1" type="password"
                    name="password" required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
            </div>

            <div class="flex items-center justify-between mt-4">
                <!-- Remember Me -->
                <div>
                    <label for="remember" class="flex items-center">
                        <input wire:model="form.remember" id="remember" type="checkbox"
                            class="text-indigo-600 border-gray-300 rounded shadow-sm dark:bg-gray-900 dark:border-gray-700 focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800"
                            name="remember">
                        <span class="text-sm text-gray-600 ms-2 dark:text-gray-400">
                            {{ __('Remember me') }}
                        </span>
                    </label>
                </div>

                <!-- Forgot Password -->
                @if (Route::has('password.request'))
                    <a class="text-sm text-gray-600 underline rounded-md dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                        href="{{ route('password.request') }}" wire:navigate>
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
            </div>
        </x-slot:content>

        <x-slot:link route="sign-up">
            Sign Up &rarr;
        </x-slot:link>

        <x-slot:button target="login">
            Log in
        </x-slot:button>
    </x-auth-card>
</div>
