@props(['submit', 'header' => null, 'route' => null, 'link' => null])

<div
    class="w-full max-w-[30rem] p-2 flex flex-col gap-2 rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-100/50 dark:bg-slate-900">
    <div class="flex flex-col p-6 bg-white shadow-sm rounded-xl md:p-8 dark:bg-slate-800">
        {{ $header }}

        <form wire:submit="{{ $submit }}">
            {{ $content }}

            <div class="flex items-center justify-between mt-4">
                <a class="text-sm underline rounded-md text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-slate-800"
                    href="{{ $link?->attributes['route'] }}" wire:navigate>
                    {{ $link }}
                </a>

                <div class="relative flex items-center space-x-9">
                    <flux:button variant="primary" class="w-auto !px-4 text-xs uppercase" type="submit">
                        {{ $button }}
                    </flux:button>
                </div>
            </div>
        </form>

        @if (request()->routeIs(['login', 'sign-up']))
            <flux:separator text="or" class="my-8" />

            <div class="flex items-center space-x-2">
                <flux:button variant="outline" href="{{ route('auth.redirect', 'github') }}" class="w-full">
                    <x-bi-github class="w-5 h-5" />

                    Continue with GitHub
                </flux:button>
            </div>
        @endif
    </div>
</div>
