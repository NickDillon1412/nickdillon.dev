@use('App\Services\PureFinanceService', 'PureFinanceService')

<div x-cloak x-data="{
    attachmentsModalOpen: false,
    clearAttachments() {
        $nextTick(() => {
            $wire.attachments = [];
        });
    }
}" x-on:open-attachments.window="attachmentsModalOpen = true; $wire.loadAttachments()"
    x-on:keydown.escape.window="attachmentsModalOpen = false; clearAttachments()" class="relative w-auto h-auto z-60">
    <div class="fixed inset-0 z-[99] transition-opacity bg-slate-900 bg-opacity-40 dark:bg-opacity-60 backdrop-blur-sm"
        x-show="attachmentsModalOpen" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-out duration-100" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" aria-hidden="true" style="display: none;">
    </div>

    <div id="attachmentsModalOpen-modal"
        class="fixed inset-0 z-[99] flex items-center justify-center px-4 my-4 overflow-hidden sm:px-6" role="dialog"
        aria-modal="true" x-show="attachmentsModalOpen" x-transition:enter="transition ease-in-out duration-200"
        x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in-out duration-200" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-4" style="display: none;">
        <div class="w-full max-w-2xl min-h-[300px] max-h-[600px] xl:max-h-[800px] overflow-auto bg-white border rounded-lg shadow-lg dark:bg-slate-800 text-slate-800 dark:text-slate-100 border-slate-200 dark:border-slate-700"
            x-on:click.outside="attachmentsModalOpen = false; clearAttachments()"
            x-on:keydown.escape.window="attachmentsModalOpen = false; clearAttachments()"
            x-trap.inert.noscroll="attachmentsModalOpen">
            <div
                class="px-5 sticky top-0 py-2.5 border-b bg-white dark:bg-slate-800 border-slate-200 dark:border-slate-700">
                <div class="flex items-center justify-between">
                    <h1 class="text-lg font-semibold">
                        Attachments
                    </h1>

                    <flux:button icon="x-mark" x-on:click="attachmentsModalOpen = false; clearAttachments()"
                        class="!h-8 !w-8 !-mr-2 !border-none hover:!bg-slate-100 dark:hover:!bg-slate-700 !shadow-none" />
                </div>
            </div>

            <div x-cloak wire:loading.flex wire:target='loadAttachments'
                class="flex justify-center text-center py-[165px] sm:py-[200px]">
                <x-large-loading-spinner />
            </div>

            <div x-cloak wire:loading.remove wire:target='loadAttachments'
                class="flex flex-col justify-center p-5 space-y-5">
                @foreach ($attachments as $attachment)
                    <img src="{{ PureFinanceService::getS3Path($attachment['name']) }}" alt="{{ $attachment['name'] }}"
                        class="rounded-md max-h-[550px]" />
                @endforeach
            </div>
        </div>
    </div>
</div>
