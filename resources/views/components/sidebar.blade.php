<div class="min-w-fit">
    <div class="fixed inset-0 z-40 transition-opacity duration-200 bg-slate-900 bg-opacity-30 lg:hidden lg:z-auto"
        :class="sidebarOpen ? 'opacity-100' : 'opacity-0 pointer-events-none'" aria-hidden="true" x-cloak>
    </div>

    <div id="sidebar"
        class="flex fixed min-h-screen border-r border-slate-200 dark:border-slate-700 lg:!flex flex-col z-40 left-0 top-0 lg:static lg:left-auto lg:top-auto lg:translate-x-0 overflow-y-scroll lg:overflow-y-auto no-scrollbar w-64 lg:w-20 lg:sidebar-expanded:!w-64 2xl:sidebar-expanded:!w-64 shrink-0 bg-white dark:bg-slate-800 p-4 transition-all duration-200 ease-in-out
        {{ $variant === 'v2' ? 'border-r border-slate-200 dark:border-slate-700' : 'shadow-sm' }}"
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-64'" @click.outside="sidebarOpen = false"
        @keydown.escape.window="sidebarOpen = false" x-trap.inert.noscroll="sidebarOpen">
        <div class="flex justify-between pr-3 mb-10 sm:px-2">
            <button class="mt-1 text-slate-500 lg:hidden hover:text-slate-400" @click.stop="sidebarOpen = !sidebarOpen"
                aria-controls="sidebar" :aria-expanded="sidebarOpen">
                <span class="sr-only">Close sidebar</span>

                <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10.7 18.7l1.4-1.4L7.8 13H20v-2H7.8l4.3-4.3-1.4-1.4L4 12z" />
                </svg>
            </button>

            <a class="flex items-center justify-center w-full mt-1 space-x-1 text-slate-700 dark:text-slate-50"
                href="{{ route('portfolio') }}" wire:navigate>
                <x-heroicon-o-home class="w-6 h-6" />

                <span x-cloak x-show="sidebarExpanded || sidebarOpen" class="text-xl font-bold">
                    {{ config('app.name') }}
                </span>
            </a>
        </div>

        <div class="space-y-8">
            <div>
                <h3 class="pl-3 text-xs font-semibold uppercase text-slate-400 dark:text-slate-500">
                    <span class="hidden w-6 text-center lg:block lg:sidebar-expanded:hidden" aria-hidden="true">
                        •••
                    </span>

                    <span class="lg:hidden lg:sidebar-expanded:block 2xl:sidebar-expanded:block">
                        Apps
                    </span>
                </h3>

                <ul class="mt-3">
                    <x-sidebar-link title="Movie Vault" route="movie-vault.my-vault">
                        <x-heroicon-o-film />
                    </x-sidebar-link>

                    <li x-data="{ showPureFinance: '{{ request()->routeIs('pure-finance.*') }}' }" @class([
                        'mt-2 pl-3.5 pr-3 py-2 rounded-lg last:mb-0 bg-[linear-gradient(135deg,var(--tw-gradient-stops))]',
                        'from-indigo-500/[0.12] dark:from-indigo-500/[0.24] to-indigo-500/[0.04]' => request()->routeIs(
                            'pure-finance.*'),
                    ])>
                        <a href="#" class="flex items-center justify-between">
                            <div class="flex items-center text-sm">
                                <x-heroicon-o-credit-card @class([
                                    'w-5 h-5 shrink-0 text-slate-400 dark:text-slate-500',
                                    '!text-indigo-500' => request()->routeIs('pure-finance.*'),
                                ]) />

                                <span @class([
                                    'text-slate-800 dark:text-slate-100 truncate transition ml-2 text-sm font-medium duration-200 lg:opacity-0 lg:sidebar-expanded:opacity-100 3xl:opacity-100',
                                    'hover:text-slate-900 dark:hover:text-white' => !request()->routeIs(
                                        'pure-finance.*'),
                                ])">
                                    Pure Finance
                                </span>
                            </div>

                            <button x-on:click="showPureFinance = !showPureFinance">
                                <svg :class="showPureFinance ? 'rotate-180' : 'rotate-0'"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="2.5" stroke="currentColor" @class([
                                        'transition-transform duration-200 ease-in-out transform size-4',
                                        'hover:text-slate-900 dark:hover:text-white' => !request()->routeIs(
                                            'pure-finance.*'),
                                    ])">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                </svg>
                            </button>
                        </a>

                        <div x-cloak x-show="showPureFinance" x-collapse class="flex flex-col mt-2 space-y-2 pl-7">
                            <a href="{{ route('pure-finance.index') }}" wire:navigate @class([
                                'text-slate-800 dark:text-slate-100 truncate transition text-sm font-medium duration-200 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100',
                                'hover:text-slate-900 dark:hover:text-white' => !request()->routeIs(
                                    'pure-finance.*'),
                                '!text-indigo-500' => request()->routeIs('pure-finance.index'),
                            ])">
                                Dashboard
                            </a>

                            <a href="{{ route('pure-finance.categories') }}" wire:navigate
                                @class([
                                    'text-slate-800 dark:text-slate-100 truncate transition text-sm font-medium duration-200 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100',
                                    'hover:text-slate-900 dark:hover:text-white' => !request()->routeIs(
                                        'pure-finance.*'),
                                    '!text-indigo-500' => request()->routeIs('pure-finance.categories'),
                                ])">
                                Categories
                            </a>

                            <a href="{{ route('pure-finance.tags') }}" wire:navigate @class([
                                'text-slate-800 dark:text-slate-100 truncate transition text-sm font-medium duration-200 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100',
                                'hover:text-slate-900 dark:hover:text-white' => !request()->routeIs(
                                    'pure-finance.*'),
                                '!text-indigo-500' => request()->routeIs('pure-finance.tags'),
                            ])">
                                Tags
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <div class="justify-end hidden pt-3 mt-auto lg:inline-flex">
            <div class="w-12 py-2 pl-4 pr-3">
                <button
                    class="transition-colors text-slate-400 hover:text-slate-500 dark:text-slate-500 dark:hover:text-slate-400"
                    @click="sidebarExpanded = !sidebarExpanded">

                    <span class="sr-only">Expand / collapse sidebar</span>

                    <svg class="fill-current text-slate-400 shrink-0 dark:text-slate-500 sidebar-expanded:rotate-180"
                        xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                        <path
                            d="M15 16a1 1 0 0 1-1-1V1a1 1 0 1 1 2 0v14a1 1 0 0 1-1 1ZM8.586 7H1a1 1 0 1 0 0 2h7.586l-2.793 2.793a1 1 0 1 0 1.414 1.414l4.5-4.5A.997.997 0 0 0 12 8.01M11.924 7.617a.997.997 0 0 0-.217-.324l-4.5-4.5a1 1 0 0 0-1.414 1.414L8.586 7M12 7.99a.996.996 0 0 0-.076-.373Z" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>
