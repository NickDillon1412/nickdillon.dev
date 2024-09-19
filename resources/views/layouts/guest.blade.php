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

    @livewireStyles
</head>

<body class="font-sans antialiased text-gray-900">
    <div class="absolute top-2 right-2 bg-gray-50 sm:right-5 sm:top-5 dark:bg-gray-900">
        <x-mary-theme-toggle
            class="transition-all duration-200 ease-in-out btn btn-circle btn-ghost hover:text-slate-700 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-500 dark:hover:text-slate-200" />
    </div>

    <div class="flex flex-col items-center justify-center min-h-screen bg-gray-50 dark:bg-gray-900">
        <div class="overflow-hidden sm:w-full w-[360px] sm:max-w-md">
            {{ $slot }}
        </div>
    </div>

    @livewireScriptConfig
</body>

</html>
