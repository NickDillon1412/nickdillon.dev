<?php

declare(strict_types=1);

use Livewire\Volt\Component;

new class extends Component {
    public function with(): array
    {
        return [
            'technologies' => [
                'tallStack' => [
                    'tailwindcss' => [
                        'url' => 'https://tailwindcss.com',
                        'image' => 'tailwindcss.svg',
                        'title' => 'Tailwind CSS',
                    ],
                    'alpinejs' => [
                        'url' => 'https://alpinejs.dev/',
                        'image' => 'alpinejs.svg',
                        'title' => 'Alpine.js',
                    ],
                    'laravel' => [
                        'url' => 'https://laravel.com',
                        'image' => 'laravel.svg',
                        'title' => 'Laravel',
                    ],
                    'livewire' => [
                        'url' => 'https://livewire.laravel.com/',
                        'image' => 'livewire.svg',
                        'title' => 'Livewire',
                    ],
                ],
                'other' => [
                    'filament' => [
                        'url' => 'https://filamentphp.com/',
                        'image' => 'filament-logo.svg',
                        'title' => 'Filament',
                    ],
                    'vuejs' => [
                        'url' => 'https://vuejs.org/',
                        'image' => 'vue.svg',
                        'title' => 'Vue.js',
                    ],
                    'inertiajs' => [
                        'url' => 'https://inertiajs.com/',
                        'image' => 'inertia.svg',
                        'title' => 'Inertia.js',
                    ],
                ],
            ],
        ];
    }
}; ?>

<div class="flex flex-col items-center justify-center mt-32 sm:mt-40 text-slate-50">
    <h1 class="w-9/12 mb-3 text-3xl font-semibold text-center">
        My favorite technologies:
    </h1>

    <div class="p-4 space-y-8 md:space-y-12">
        @foreach ($technologies as $stack => $items)
        <div class="grid grid-cols-2 gap-8 md:flex md:justify-center md:space-x-2 flex:space-y-4 md:space-y-0">
            @foreach ($items as $technology)
            <div
                class="p-2 duration-300 hover:shadow-2xl hover:ease-in-out hover:scale-125 hover:shadow-pink-500 hover:bg-slate-50 hover:text-slate-800 hover:rounded hover:-rotate-3 w-36">
                <a href="{{ $technology['url'] }}" target="_blank">
                    <div class="flex justify-center mb-1 5">
                        <img src="{{ asset($technology['image']) }}" />
                    </div>

                    <div class="text-center">
                        <h1 class="text-xl font-semibold shadow-indigo-400/50">
                            {{ $technology['title'] }}
                        </h1>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
        @endforeach
    </div>
</div>