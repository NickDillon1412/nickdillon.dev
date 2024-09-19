@props(['submit', 'header' => null, 'route' => null, 'link' => null])

<div
    class="w-full max-w-[30rem] p-2 flex flex-col gap-2 rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-900">
    <div class="flex flex-col p-6 bg-white shadow-sm rounded-xl md:p-8 dark:bg-gray-800">
        {{ $header }}

        <form wire:submit="{{ $submit }}">
            {{ $content }}

            <div class="flex items-center justify-between mt-4">
                <a class="text-sm text-gray-600 underline rounded-md dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                    href="{{ $link?->attributes['route'] }}" wire:navigate>
                    {{ $link }}
                </a>

                <div class="relative flex items-center space-x-9">
                    <x-loading-spinner target="{{ $button->attributes['target'] }}" class="!left-0" />

                    <x-primary-button>
                        {{ $button }}
                    </x-primary-button>
                </div>
            </div>
        </form>
    </div>
</div>
