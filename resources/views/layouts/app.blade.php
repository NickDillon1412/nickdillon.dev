<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body :class="{ 'sidebar-expanded': sidebarExpanded }" class="antialiased bg-slate-100 text-slate-600 dark:bg-slate-900"
    x-data="{
        sidebarOpen: false,
        sidebarExpanded: localStorage.getItem('sidebar-expanded') == 'true'
    }" x-init="$watch('sidebarExpanded', value => localStorage.setItem('sidebar-expanded', value))">
    <script>
        if (localStorage.getItem('sidebar-expanded') == 'true') {
            document.querySelector('body').classList.add('sidebar-expanded');
        } else {
            document.querySelector('body').classList.remove('sidebar-expanded');
        }
    </script>

    <div class="flex h-screen overflow-hidden">
        <x-sidebar />

        <div class="relative flex flex-col flex-1 overflow-x-hidden overflow-y-auto">
            <livewire:layout.navigation />

            <main>
                {{ $slot }}
            </main>
        </div>
    </div>
</body>

</html>
