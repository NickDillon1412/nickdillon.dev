<div x-data="{ modalOpen: false }" @keydown.escape.window="modalOpen = false" class="relative w-auto h-auto z-60">
    <div @click="modalOpen=true" class="cursor-pointer">
        {{ $slot }}
    </div>

    <template x-teleport="body">
        <div x-show="modalOpen"
            class="fixed top-0 left-0 z-[99] flex items-center justify-center w-screen h-screen text-slate-800 dark:text-slate-50"
            x-cloak>
            <div x-show="modalOpen" x-transition:enter="ease-out duration-200" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="modalOpen=false"
                class="absolute inset-0 w-full h-full bg-black bg-opacity-40 dark:bg-opacity-60">
            </div>

            <div x-show="modalOpen" x-trap.inert.noscroll="modalOpen" x-transition:enter="ease-out duration-200"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="relative w-10/12 py-6 bg-white border rounded-lg dark:bg-slate-800 sm:w-full px-7 sm:max-w-lg border-slate-200 dark:border-slate-600/50">
                <div @class([
                    'stroke-indigo-500' => $attributes->has('info'),
                    'stroke-[#ff2825]' => $attributes->has('delete'),
                    'flex items-center pb-4',
                ])>
                    <svg xmlns="http://www.w3.org/2000/svg" @class([
                        '-rotate-180' => $attributes->has('info'),
                        'icon icon-tabler icon-tabler-alert-circle',
                    ]) width="30" height="30"
                        viewBox="0 0 24 24" stroke-width="1.5" fill="none" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
                        <path d="M12 8v4" />
                        <path d="M12 16h.01" />
                    </svg>

                    <h3 class="ml-2 text-lg font-semibold">
                        {{ $title }}
                    </h3>

                    <button @click="modalOpen=false"
                        class="absolute top-0 right-0 flex items-center justify-center w-8 h-8 mt-5 mr-5 rounded-full text-slate-600 hover:text-slate-800 hover:bg-slate-50 dark:hover:bg-slate-900 dark:text-slate-50">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="relative ml-5">
                    <p>
                        {{ $body }}
                    </p>
                </div>

                <div class="flex justify-end mt-5">
                    <div class="space-x-1 text-sm text-white">
                        <button @click="modalOpen=false"
                            class="inline-flex items-center justify-center px-4 py-1 font-medium leading-6 whitespace-no-wrap transition duration-300 ease-in-out bg-white border rounded-md shadow-sm text-slate-600 border-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 dark:text-slate-50 hover:bg-slate-100 dark:border-slate-600">
                            Cancel
                        </button>

                        <button @click="modalOpen=false" {{ $attributes->whereStartsWith('wire:click') }}
                            @class([
                                'bg-indigo-500 border-indigo-500 hover:border-indigo-600 hover:bg-indigo-600' => $attributes->has(
                                    'info'),
                                'bg-red-500 border-red-500 hover:border-red-600 hover:bg-red-600' => $attributes->has(
                                    'delete'),
                                'inline-flex items-center justify-center px-4 py-1 font-medium leading-6 text-white whitespace-no-wrap transition duration-300 ease-in-out rounded-md shadow-sm border',
                            ])>
                            Confirm
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </template>
</div>
