@props(['icon', 'variant'])

<div wire:ignore {{ $attributes->whereStartsWith('x-init') }} x-data="{ modalOpen: false }"
    x-on:keydown.escape.window="modalOpen = false" class="relative w-auto h-auto z-60">
    <div x-on:click="modalOpen = true" class="cursor-pointer">
        {{ $button }}
    </div>

    <div x-show="modalOpen"
        class="fixed top-0 left-0 z-[99] flex items-center justify-center w-screen h-screen text-slate-800 dark:text-slate-50"
        x-cloak>
        <div x-show="modalOpen" x-transition:enter="ease-out duration-200" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" x-on:click="modalOpen = false"
            class="absolute inset-0 w-full h-full bg-slate-900 bg-opacity-40 dark:bg-opacity-60 backdrop-blur-sm"></div>

        <div x-show="modalOpen" x-trap.inert.noscroll="modalOpen" x-transition:enter="ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-on:close-modal.window="modalOpen = false"
            class="relative w-10/12 py-6 bg-white border rounded-lg dark:bg-slate-800 sm:w-full px-7 sm:max-w-lg border-slate-200 dark:border-slate-700">
            <div class="flex items-center justify-between pb-4">
                <div class="flex items-center space-x-2">
                    <flux:icon icon="{{ $icon }}" variant="outline" @class([
                        'stroke-indigo-500' => $attributes->has('info'),
                        'stroke-red-500' => $attributes->has('delete'),
                        'stroke-pink-500' => $attributes->has('contact'),
                        '!h-8 !w-8',
                    ]) />

                    <h3 class="text-lg font-semibold">
                        {{ $title }}
                    </h3>
                </div>

                <flux:button icon="x-mark" x-on:click="modalOpen = false"
                    class="!h-8 !w-8 !border-none hover:!bg-slate-200 dark:hover:!bg-slate-700 !shadow-none" />
            </div>

            <form {{ $attributes->whereStartsWith('wire:submit') }}>
                {{ $body }}

                <div class="flex justify-end mt-5">
                    <div class="space-x-1 text-sm text-white">
                        <flux:button variant="outline" class="!px-5" x-on:click="modalOpen = false">
                            Cancel
                        </flux:button>

                        <flux:button variant="{{ $variant }}" class="!px-5" type="submit">
                            {{ $attributes->has('contact') ? 'Send' : 'Confirm' }}
                        </flux:button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
