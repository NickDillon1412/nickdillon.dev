<?php

use Livewire\Volt\Component;

new class extends Component {
    public function with(): array
    {
        return [
            'socials' => [
                'x' => [
                    'link' => 'https://twitter.com/NickDillon1412',
                    'icon' => 'fab-x-twitter',
                ],
                'github' => [
                    'link' => 'https://github.com/NickDillon1412',
                    'icon' => 'fab-github',
                ],
                'linkedIn' => [
                    'link' => 'https://www.linkedin.com/in/nickdillon12/',
                    'icon' => 'fab-linkedin',
                ],
            ],
        ];
    }
}; ?>

<div class="flex space-x-3">
    @foreach ($socials as $social)
        <div class="ml-0 duration-300 ease-in-out hover:scale-125">
            <a href="{{ $social['link'] }}">
                <x-dynamic-component :component="$social['icon']"
                    class="w-6 h-6 text-white duration-300 ease-in-out hover:text-pink-500" />
            </a>
        </div>
    @endforeach
</div>
