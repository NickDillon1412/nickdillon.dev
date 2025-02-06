<?php

use Illuminate\Support\Facades\Session;
use App\Livewire\Forms\LoginForm;
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

        $this->redirectIntended(navigate: true);
    }
}; ?>

<div x-data="{ showPassword: false }">
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <x-auth-card submit="login">
        <x-slot:header>
            <h1 class="flex justify-center mb-6 text-2xl font-semibold text-slate-700 dark:text-slate-100">
                Login
            </h1>
        </x-slot:header>

        <x-slot:content>
            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input wire:model="form.email" id="email" class="block w-full mt-2" type="email" name="email"
                    required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" />

                <div class="relative mt-2">
                    <input :type="showPassword ? 'text' : 'password'" id="password" name="password" wire:model="form.password" class="block w-full text-sm rounded-md shadow-sm border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600" required />

                    <button x-cloak x-on:click="showPassword = !showPassword" class="absolute inset-y-0 top-0 flex items-center end-4" type="button">
                        <flux:icon x-show="!showPassword && $wire.form.password.length" icon="eye" variant="outline" class="w-5 h-5 dark:text-slate-300" />

                        <flux:icon x-show="showPassword && $wire.form.password.length" icon="eye-slash" variant="outline" class="w-5 h-5 dark:text-slate-300" />
                    </button>
                </div>

                <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
            </div>

            <div class="flex items-center justify-between mt-4">
                <!-- Remember Me -->
                <div>
                    <label for="remember" class="flex items-center">
                        <input wire:model="form.remember" id="remember" type="checkbox"
                            class="text-indigo-600 rounded shadow-sm border-slate-300 dark:bg-slate-900 dark:border-slate-700 focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-slate-800"
                            name="remember">
                        <span class="text-sm text-slate-600 ms-2 dark:text-slate-400">
                            {{ __('Remember me') }}
                        </span>
                    </label>
                </div>

                <!-- Forgot Password -->
                @if (Route::has('password.request'))
                <a class="text-sm underline rounded-md text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-slate-800"
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