<?php

use Livewire\Volt\Component;

new class extends Component {
    public function with(): array
    {
        return [
            'projects' => [
                'movie-vault' => [
                    'url' => route('movie-vault.my-vault'),
                    'image' => 'movie-vault.png',
                    'title' => 'Movie Vault',
                    'technologies' => ['Tailwind', 'Alpine.js', 'Laravel', 'Livewire'],
                ],
                'neovim' => [
                    'url' => 'https://github.com/NickDillon1412/dotfiles',
                    'image' => 'neovim.png',
                    'title' => 'Neovim Config',
                    'technologies' => ['Neovim', 'Lua'],
                ],
            ],
        ];
    }
}; ?>

<div class="flex flex-col items-center justify-center p-4 mt-24 mb-3 sm:mt-32 text-slate-50">
    <h1 class="w-7/12 mx-auto mb-8 text-3xl font-semibold text-center sm:mb-6">
        A couple of my projects:
    </h1>

    <div class="flex flex-col px-3 space-y-8 sm:space-y-0 sm:space-x-8 sm:flex-row text-slate-800">
        @foreach ($projects as $project)
            <a href="{{ $project['url'] }}">
                <div
                    class="max-w-sm duration-300 ease-in-out bg-white border rounded-lg shadow-2xl border-slate-200 hover:shadow-pink-500 hover:scale-105 hover:-rotate-2">
                    <img class="object-cover w-full h-48 rounded-t-lg sm:h-56" src="{{ asset($project['image']) }}" />

                    <div class="p-4 space-y-1">
                        <h5 class="text-2xl font-bold tracking-tight">
                            {{ $project['title'] }}
                        </h5>

                        <ul>
                            @foreach ($project['technologies'] as $tech)
                                <li
                                    class="inline-block px-2 sm:px-2.5 py-0.5 sm:py-[.8px] mr-1 text-[12.5px] sm:text-sm font-semibold text-pink-600 bg-pink-200 rounded-full shadow-xs shadow-pink-200/75">
                                    {{ $tech }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </a>
        @endforeach
    </div>

    <a class="mt-6 font-medium text-pink-400 duration-300 ease-in-out hover:text-pink-300 hover:scale-110"
        href="{{ route('apps') }}" wire:navigate>
        View All <span class="inline"> &rarr;</span>
    </a>
</div>
