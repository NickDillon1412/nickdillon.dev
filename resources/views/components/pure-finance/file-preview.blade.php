@props(['file'])
@use('App\Services\PureFinanceService', 'PureFinanceService')

<div x-cloak x-data="{ filePreviewModalOpen: false }" x-on:keydown.escape.window="filePreviewModalOpen = false"
    class="relative w-auto h-auto z-60">
    <div x-on:click="filePreviewModalOpen = true" class="cursor-pointer">
        <img src="{{ PureFinanceService::getS3Path($file['name']) }}" alt="{{ $file['name'] }}"
            class="w-8 h-8 rounded-md " />
    </div>

    <div class="fixed inset-0 z-[99] transition-opacity bg-slate-900 bg-opacity-40 dark:bg-opacity-60 backdrop-blur-sm"
        x-show="filePreviewModalOpen" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-out duration-100" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" aria-hidden="true" style="display: none;">
    </div>

    <div id="filePreviewModalOpen-modal"
        class="fixed inset-0 z-[99] flex items-center justify-center px-4 my-4 overflow-hidden sm:px-6" role="dialog"
        aria-modal="true" x-show="filePreviewModalOpen" x-transition:enter="transition ease-in-out duration-200"
        x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in-out duration-200" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-4" style="display: none;">
        <div class="w-full max-w-xl max-h-full overflow-auto bg-white border rounded-lg shadow-lg dark:bg-slate-800 text-slate-800 dark:text-slate-100 border-slate-200 dark:border-slate-700"
            x-on:click.outside="filePreviewModalOpen = false" x-on:keydown.escape.window="filePreviewModalOpen = false"
            x-trap.inert.noscroll="filePreviewModalOpen">
            <div class="px-5 py-2.5 border-b border-slate-200 dark:border-slate-700">
                <div class="flex items-center justify-between">
                    <div class="text-lg font-semibold">
                        {{ $file['name'] }}
                    </div>

                    <flux:button icon="x-mark" x-on:click="filePreviewModalOpen = false"
                        class="!h-8 !w-8 !-mr-2 !border-none hover:!bg-slate-100 dark:hover:!bg-slate-700 !shadow-none" />
                </div>
            </div>

            <div class="flex justify-center p-5">
                <img src="{{ PureFinanceService::getS3Path($file['name']) }}" alt="{{ $file['name'] }}"
                    class="rounded-md max-h-[550px]" />
            </div>
        </div>
    </div>
</div>
