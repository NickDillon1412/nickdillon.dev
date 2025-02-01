<?php

use App\Actions\PureFinance\CreateDefaultCategories;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use App\Models\User;

new #[Layout('layouts.guest')] class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function signup(CreateDefaultCategories $action): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered($user = User::create($validated)));

        $action->handle($user);

        Auth::login($user);

        $this->redirect(route('apps', absolute: false), navigate: true);
    }
}; ?>

<div x-data="{ showPassword: false, showPasswordConfirmation: false }">
    <x-auth-card submit="signup">
        <x-slot:header>
            <h1 class="flex justify-center mb-6 text-2xl font-semibold text-slate-700 dark:text-slate-100">
                Sign Up
            </h1>
        </x-slot:header>

        <x-slot:content>
            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input wire:model="name" id="name" class="block w-full mt-2" type="text" name="name" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input wire:model="email" id="email" class="block w-full mt-2" type="email" name="email" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" />

                <div class="relative mt-2">
                    <input :type="showPassword ? 'text' : 'password'" id="password" name="password" wire:model="password" class="block w-full rounded-md shadow-sm sm:text-sm border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600" autocomplete="new-password" required />

                    <button x-cloak x-on:click="showPassword = !showPassword" class="absolute inset-y-0 top-0 flex items-center end-4" type="button">
                        <flux:icon x-show="!showPassword && $wire.password.length" icon="eye" variant="outline" class="w-5 h-5 dark:text-slate-300" />

                        <flux:icon x-show="showPassword && $wire.password.length" icon="eye-slash" variant="outline" class="w-5 h-5 dark:text-slate-300" />
                    </button>
                </div>

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

                <div class="relative mt-2">
                    <input :type="showPasswordConfirmation ? 'text' : 'password'" id="password_confirmation" name="password_confirmation" wire:model="password_confirmation" class="block w-full rounded-md shadow-sm sm:text-sm border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600" autocomplete="new-password" required />

                    <button x-cloak x-on:click="showPasswordConfirmation = !showPasswordConfirmation" class="absolute inset-y-0 top-0 flex items-center end-4" type="button">
                        <flux:icon x-show="!showPasswordConfirmation && $wire.password_confirmation.length" icon="eye" variant="outline" class="w-5 h-5 dark:stroke-slate-300" />

                        <flux:icon x-show="showPasswordConfirmation && $wire.password_confirmation.length" icon="eye-slash" variant="outline" class="w-5 h-5 dark:stroke-slate-300" />
                    </button>
                </div>

                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>
        </x-slot:content>

        <x-slot:link route="login">
            Already signed up?
        </x-slot:link>

        <x-slot:button target="signup">
            Sign Up
        </x-slot:button>
    </x-auth-card>
</div>