<?php

declare(strict_types=1);

use App\Mail\ContactForm;
use Livewire\Volt\Component;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Mail;
use Filament\Notifications\Notification;

new class extends Component {
    #[Validate(['required', 'string', 'max:50'])]
    public string $name;

    #[Validate(['required', 'email'])]
    public string $email;

    #[Validate(['required', 'string', 'max:255'])]
    public string $message;

    public function sendEmail(): void
    {
        $this->validate();

        Mail::to('nickhds@gmail.com')->send(new ContactForm($this->name, $this->email, $this->message));

        $this->reset();

        $this->dispatch('close-modal');

        Notification::make()
            ->title("Your message has been sent!")
            ->info()
            ->send();
    }
}; ?>

<div x-init="() => document.documentElement.classList.add('dark')">
    <x-modal icon="user-circle" contact variant="pink" wire:submit="sendEmail">
        <x-slot:button>
            <div class="relative inline-flex w-full group/button">
                <div
                    class="absolute transition-all duration-1000 bg-pink-500 -inset-px rounded-xl blur-lg group-hover/button:opacity-100 group-hover/button:-inset-1 group-hover/button:duration-200 animate-pulse">
                </div>

                <button class="relative inline-flex items-center justify-center w-full px-4 py-2 text-lg font-bold text-white transition-all duration-300 ease-in-out bg-pink-500 sm:w-auto hover:-rotate-3 hover:scale-110 rounded-xl focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500"
                    role="button">
                    Send me a message!
                </button>
            </div>
        </x-slot:button>

        <x-slot:title>
            Contact Me
        </x-slot:title>

        <x-slot:body>
            <div class="space-y-4 text-left">
                <div>
                    <x-input-label for="name" :value="__('Name')" />

                    <x-text-input wire:model="name" id="name"
                        class="block w-full mt-1 focus:!border-pink-500 focus:!ring-pink-500" type="text"
                        name="name" required autofocus autocomplete="name" />

                    <x-input-error :messages="$errors->get('name')" class="mt-2 !text-pink-500" />
                </div>

                <div>
                    <x-input-label for="email" :value="__('Email')" />

                    <x-text-input wire:model="email" id="email"
                        class="block w-full mt-1 focus:!border-pink-500 focus:!ring-pink-500" type="email"
                        name="email" required autofocus autocomplete="username" />

                    <x-input-error :messages="$errors->get('email')" class="mt-2 !text-pink-500" />
                </div>

                <div>
                    <x-input-label for="message" :value="__('Message')" />

                    <textarea wire:model="message" id="message"
                        class="w-full mt-1 rounded-md shadow-sm border-slate-700 bg-slate-900 text-slate-300 focus:border-pink-500 focus:ring-pink-500"
                        name="message" required autofocus autocomplete="message" rows="5"></textarea>

                    <x-input-error :messages="$errors->get('message')" class="mt-2 !text-pink-500" />
                </div>
            </div>
        </x-slot:body>
    </x-modal>
</div>