@props(['transaction'])

@use('App\Enums\PureFinance\TransactionType', 'TransactionType')

<div wire:key='{{ $transaction->id }}' x-data="transaction" x-on:transaction-deleted.window="resetSwipe"
    x-on:status-changed.window="resetSwipe" x-on:click.outside="resetSwipe"
    class="relative overflow-hidden last:rounded-b-xl">
    <div x-show="rightSwipe" x-transition:enter="transform duration-200" x-transition:enter-start="-translate-x-full"
        x-transition:enter-end="translate-x-0" x-transition:leave="transform duration-200"
        x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full"
        @class([
            'absolute top-0 bottom-0 left-0 flex items-center text-white border',
            'bg-emerald-400 border-emerald-500 dark:bg-emerald-600/80' => !$transaction->status,
            'bg-amber-400 border-amber-500 dark:bg-amber-600/80' =>
                $transaction->status,
        ])>
        <flux:button class="!p-0 hover:!bg-transparent" variant="ghost"
            wire:click="toggleStatus({{ $transaction->id }})">
            @if ($transaction->status)
                <flux:icon.clock-alert class="w-[44px] p-1 ease-in-out rounded-md text-amber-500 h-7" />
            @else
                <x-heroicon-o-check-circle class="w-[44px] p-1 ease-in-out rounded-md text-emerald-500 h-8" />
            @endif
        </flux:button>
    </div>

    <div x-show="leftSwipe" x-transition:enter="transform duration-200" x-transition:enter-start="translate-x-full"
        x-transition:enter-end="translate-x-0" x-transition:leave="transform duration-200"
        x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full"
        class="absolute top-0 bottom-0 right-0 flex items-center text-white bg-red-400 border border-red-500 dark:bg-red-600/80">
        <x-modal icon="information-circle" delete variant="danger" wire:submit="delete({{ $transaction->id }})">
            <x-slot:button>
                <x-heroicon-o-trash class="w-[44px] p-1 text-red-500 duration-100 ease-in-out rounded-md h-8" />
            </x-slot:button>

            <x-slot:title>
                Delete Transaction
            </x-slot:title>

            <x-slot:body>
                Are you sure you want to delete this transaction?
            </x-slot:body>
        </x-modal>
    </div>

    <a href="{{ route('pure-finance.transaction-form', $transaction->id) }}" wire:navigate @class([
        'flex flex-col px-4 py-2.5 space-y-0.5 text-sm bg-white dark:bg-slate-800 transform transition-transform duration-300',
        'border-l-2 !border-l-emerald-500' => $transaction->status === true,
        'border-l-2 !border-l-amber-500' => $transaction->status === false,
    ])
        x-bind:style="contentStyle">
        <div class="flex items-center justify-between font-medium">
            <p>
                {{ $transaction->payee }}
            </p>

            <p>
                @if (in_array($transaction->type, [TransactionType::DEBIT, TransactionType::TRANSFER, TransactionType::WITHDRAWAL]))
                    <span class="-mr-1">-</span>
                @endif

                ${{ Number::format($transaction->amount ?? 0, 2) }}
            </p>
        </div>

        <div class="flex items-center justify-between text-slate-500 dark:text-slate-300">
            <div class="flex items-center">
                <p class="max-w-[230px] truncate">
                    @if ($transaction->category->parent)
                        {{ $transaction->category->parent->name }} &rarr; {{ $transaction->category->name }}
                    @else
                        {{ $transaction->category->name }}
                    @endif
                </p>
            </div>

            <p>
                {{ Carbon\Carbon::parse($transaction->date)->format('M j, Y') }}
            </p>
        </div>

        @if ($transaction->tags)
            <div class="text-slate-500 dark:text-slate-300">
                {{ $transaction->tags->pluck('name')->implode(', ') }}
            </div>
        @endif
    </a>
</div>

@script
    <script>
        Alpine.data('transaction', () => {
            return {
                leftSwipe: false,
                rightSwipe: false,
                startX: 0,
                currentX: 0,

                get contentStyle() {
                    return `transform: translateX(${
                        this.leftSwipe ? '-44px' : 
                        this.rightSwipe ? '44px' : '0px'
                    })`;
                },

                resetSwipe() {
                    this.leftSwipe = false;
                    this.rightSwipe = false;
                },

                handleTouchStart(event) {
                    this.startX = event.touches[0].clientX;
                    this.currentX = this.startX;
                },

                handleTouchMove(event) {
                    this.currentX = event.touches[0].clientX;
                    const swipeDistance = 50;

                    if (this.startX - this.currentX > swipeDistance) {
                        this.leftSwipe = true;
                        this.rightSwipe = false;
                    } else if (this.currentX - this.startX > swipeDistance) {
                        this.rightSwipe = true;
                        this.leftSwipe = false;
                    }
                },

                init() {
                    this.$el.addEventListener('touchstart', this.handleTouchStart.bind(this));
                    this.$el.addEventListener('touchmove', this.handleTouchMove.bind(this));
                }
            };
        })
    </script>
@endscript
