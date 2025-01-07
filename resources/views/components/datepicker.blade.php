@props(['field'])

<div class="relative w-full mt-1 flatpickr" wire:ignore x-ref="datepicker" x-data="datepicker">
    <input wire:model="{{ $field }}"
        class="w-full font-medium rounded-lg shadow-sm form-input datepicker pl-9 text-slate-500 hover:text-slate-600 border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 place-items-start"
        placeholder="Select a date" required autocomplete="{{ $field }}" type="text" id="{{ $field }}"
        data-input />

    <div class="absolute inset-0 right-auto flex items-center pointer-events-none" data-toggle>
        <svg class="w-4 h-4 ml-3 fill-current text-slate-500" viewBox="0 0 16 16">
            <path
                d="M15 2h-2V0h-2v2H9V0H7v2H5V0H3v2H1a1 1 0 00-1 1v12a1 1 0 001 1h14a1 1 0 001-1V3a1 1 0 00-1-1zm-1 12H2V6h12v8z">
            </path>
        </svg>
    </div>

    <div x-cloak x-show="$wire.date" class="absolute inset-0 left-auto flex items-center mr-4">
        <button type="button" x-on:click="flatpickr.clear()" class="focus:outline-none">
            <x-heroicon-s-x-mark
                class="w-6 h-6 p-0.5 -mr-2 text-red-500 duration-100 ease-in-out rounded-md hover:bg-slate-200 dark:hover:bg-slate-700" />
        </button>
    </div>
</div>

@script
    <script>
        Alpine.data('datepicker', () => {
            return {
                flatpickr: null,

                init() {
                    this.flatpickr = flatpickr(this.$refs.datepicker, {
                        wrap: true,
                        dateFormat: 'n/d/Y',
                        monthSelectorType: 'static',
                        defaultDate: this.$wire.get('{{ $field }}'),
                        prevArrow: '<svg class="fill-current" width="7" height="11" viewBox="0 0 7 11"><path d="M5.4 10.8l1.4-1.4-4-4 4-4L5.4 0 0 5.4z" /></svg>',
                        nextArrow: '<svg class="fill-current" width="7" height="11"><path d="M1.4 10.8L0 9.4l4-4-4-4L1.4 0l5.4 5.4z" /></svg>',
                    });
                },
            }
        });
    </script>
@endscript
