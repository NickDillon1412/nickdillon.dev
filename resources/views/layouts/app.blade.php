<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @filamentStyles
    @fluxStyles
    @livewireStyles
</head>

<body @class([
    'antialiased bg-slate-100 text-slate-600 dark:bg-slate-900 dark:text-slate-400 font-inter min-h-screen',
    '!bg-[#18192c] bg-dots text-slate-50' => request()->routeIs('portfolio'),
]) x-data="{
    sidebarOpen: false,
    sidebarExpanded: localStorage.getItem('sidebar-expanded') == 'true'
}" :class="{
    'sidebar-expanded': sidebarExpanded
}"
    x-init="$watch('sidebarExpanded', value => localStorage.setItem('sidebar-expanded', value))">
    <script>
        if (localStorage.getItem('sidebar-expanded') == 'true') {
            document.querySelector('body').classList.add('sidebar-expanded');
        } else {
            document.querySelector('body').classList.remove('sidebar-expanded');
        }
    </script>

    <div class="flex min-h-screen overflow-hidden sm:overflow-visible sm:h-screen">
        @if (!request()->routeIs('portfolio'))
            <x-sidebar :variant="$attributes['sidebarVariant']" />
        @endif

        <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden @if ($attributes['background']) {{ $attributes['background'] }} @endif"
            x-ref="contentarea">
            @if (!request()->routeIs('portfolio'))
                <livewire:layout.navigation />
            @endif

            <main class="overflow-y-auto grow">
                {{ $slot }}
            </main>
        </div>
    </div>

    @livewire('notifications')

    @filamentScripts
    @fluxScripts
    @livewireScriptConfig
</body>

</html>
