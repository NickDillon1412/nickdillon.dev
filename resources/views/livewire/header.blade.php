<?php

use Livewire\Volt\Component;

new class extends Component {
    //
}; ?>

<div class="fixed w-full z-10 px-3.5 py-3 sm:py-3.5 border-b sm:px-10 border-slate-700 backdrop-blur-2xl text-slate-50">
    <nav class="flex items-center justify-between mx-auto xl:max-w-5xl">
        <a href="{{ route('portfolio') }}" wire:navigate>
            <h1
                class="text-3xl font-semibold tracking-tighter uppercase duration-300 ease-in-out hover:text-pink-500 hover:scale-110">
                Nick Dillon
            </h1>
        </a>

        @livewire('socials')
    </nav>
</div>
