@props(['route'])

<li class="px-1.5 rounded-md last:mb-0 text-slate-700 hover:text-indigo-600 dark:text-slate-400 dark:hover:text-indigo-400
@if (request()->routeIs($route)) bg-indigo-50 dark:bg-slate-700 @endif"
    :class="{ '!px-2': sidebarExpanded }">
    <a href="{{ route($route) }}" wire:navigate
        class="inline-flex items-center space-x-2 text-sm font-medium w-full py-1.5
        @if (request()->routeIs($route)) text-indigo-600 dark:text-indigo-400 @endif">
        <div
            class="@if (request()->routeIs($route)) text-indigo-600 dark:text-indigo-400
            @else text-slate-400 dark:text-slate-500 @endif w-6 h-6">
            {{ $slot }}
        </div>

        <span x-show="sidebarExpanded">{{ Str::title($route) }}</span>
    </a>
</li>
