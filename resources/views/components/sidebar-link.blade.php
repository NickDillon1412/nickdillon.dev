@props(['route'])

<li
    class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0 bg-[linear-gradient(135deg,var(--tw-gradient-stops))]
    @if (in_array(Request::segment(1), [$route])) {{ 'from-indigo-500/[0.12] dark:from-indigo-500/[0.24] to-indigo-500/[0.04]' }} @endif">
    <a class="block text-slate-800 dark:text-slate-100 truncate transition @if (!in_array(Request::segment(1), [$route])) {{ 'hover:text-slate-900 dark:hover:text-white' }} @endif"
        href="{{ route($route) }}">
        <div class="flex items-center">
            <div
                class="@if (in_array(Request::segment(1), [$route])) {{ 'text-indigo-500' }} @else{{ 'text-slate-400 dark:text-slate-500' }} @endif w-5 h-5 -ml-0.5 shrink-0">
                {{ $slot }}
            </div>

            <span
                class="ml-3 text-sm font-medium duration-200 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100">
                {{ Str::title($route) }}
            </span>
        </div>
    </a>
</li>
