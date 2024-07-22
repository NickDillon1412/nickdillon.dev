@props(['title', 'route'])

@php
    $route_contains = request()->routeIs(Str::beforeLast($route, '.') . '.*');
@endphp

<li @class([
    'pl-3.5 pr-3 py-2 rounded-lg last:mb-0 bg-[linear-gradient(135deg,var(--tw-gradient-stops))]',
    'from-indigo-500/[0.12] dark:from-indigo-500/[0.24] to-indigo-500/[0.04]' => $route_contains,
])>
    <a @class([
        'block text-slate-800 dark:text-slate-100 truncate transition',
        'hover:text-slate-900 dark:hover:text-white' => !$route_contains,
    ])" href="{{ route($route) }}">
        <div class="flex items-center">
            <div @class([
                'w-5 h-5 shrink-0 text-slate-400 dark:text-slate-500',
                '!text-indigo-500' => $route_contains,
            ])>
                {{ $slot }}
            </div>

            <span
                class="ml-2 text-sm font-medium duration-200 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100">
                {{ $title }}
            </span>
        </div>
    </a>
</li>
