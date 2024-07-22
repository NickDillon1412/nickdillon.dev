<?php

use Livewire\Volt\Component;

new class extends Component {
    public function with(): array
    {
        return [
            'projects' => [
                'contacts' => [
                    'url' => 'https://github.com/NickDillon1412/Contacts',
                    'image' => 'contacts.png',
                    'title' => 'Contacts App',
                    'technologies' => ['Vue.js', 'Inertia.js', 'Laravel', 'Tailwind'],
                ],
                'recipes' => [
                    'url' => 'https://github.com/NickDillon1412/Recipe-App',
                    'image' => 'recipes.png',
                    'title' => 'Recipes App',
                    'technologies' => ['Tailwind', 'Alpine.js', 'Laravel', 'Livewire'],
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
            <a href="{{ $project['url'] }}" target="_blank">
                <div
                    class="max-w-sm duration-300 ease-in-out bg-white border rounded-lg shadow-2xl border-slate-200 hover:shadow-pink-500 hover:scale-105 hover:-rotate-2">
                    <img class="rounded-t-lg" src="{{ asset($project['image']) }}" />

                    <div class="p-5">
                        <h5 class="text-2xl font-bold tracking-tight">
                            {{ $project['title'] }}
                        </h5>

                        @foreach ($project['technologies'] as $tech)
                            <ul v-for="tech in project.technologies" class="inline-block pt-3">
                                <li
                                    class="px-2 sm:px-2.5 py-0.5 sm:py-[.8px] mr-1 text-[12.5px] sm:text-sm font-semibold text-pink-600 bg-pink-200 rounded-full shadow-xs shadow-pink-200/75">
                                    {{ $tech }}
                                </li>
                            </ul>
                        @endforeach
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
