<div>
    <!-- Sidebar backdrop (mobile only) -->
    <div :class="sidebarOpen ? 'opacity-100' : 'opacity-0 pointer-events-none'" aria-hidden="true"
        class="fixed inset-0 z-40 transition-opacity duration-200 bg-slate-900 bg-opacity-30 lg:z-auto lg:hidden"
        x-cloak>
    </div>

    <!-- Sidebar -->
    <div @click.outside="sidebarOpen = false" @keydown.escape.window="sidebarOpen = false"
        :class="sidebarOpen ? 'translate-x-0 rounded-tr-3xl' : '-translate-x-64'"
        class="absolute top-0 left-0 z-40 flex flex-col w-64 h-screen p-4 overflow-y-scroll transition-all duration-200 ease-in-out bg-white no-scrollbar shrink-0 dark:bg-slate-800 lg:static lg:left-auto lg:top-auto lg:w-[72px] lg:translate-x-0 lg:overflow-y-auto lg:sidebar-expanded:!w-64 2xl:!w-64 rounded-br-3xl border-r border-slate-100 dark:border-slate-700"
        id="sidebar">

        <!-- Sidebar header -->
        <div class="flex items-center justify-center w-full mt-4 mb-10">
            <a aria-current="page"
                class="absolute flex space-x-1 router-link-active router-link-exact-active text-slate-700 dark:text-slate-50"
                href="{{ route('portfolio') }}">
                <x-heroicon-o-home class="w-6 h-6" />

                <span x-show="sidebarExpanded" class="text-xl font-bold">
                    {{ config('app.name') }}
                </span>
            </a>
        </div>

        <!-- Links -->
        <div class="space-y-8">
            <!-- Pages group -->
            <div>
                <h3 class="pl-1 text-xs font-semibold uppercase text-slate-500" :class="{ '!pl-3': sidebarExpanded }">
                    <span class="block">Apps</span>
                </h3>

                <ul class="mt-2 space-y-2">
                    <x-sidebar-link route="dashboard">
                        <x-heroicon-m-computer-desktop />
                    </x-sidebar-link>

                    <x-sidebar-link route="profile">
                        <x-heroicon-o-user-circle />
                    </x-sidebar-link>
                </ul>
            </div>
        </div>

        <div class="justify-end hidden pt-3 mt-auto lg:inline-flex 2xl:hidden">
            <div class="w-12 py-2 pl-4 pr-3">
                <button class="text-slate-400 hover:text-slate-500 dark:text-slate-500 dark:hover:text-slate-400"
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
