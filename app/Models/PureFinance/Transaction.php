<?php

namespace App\Models\PureFinance;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Enums\PureFinance\RecurringFrequency;
use App\Enums\PureFinance\TransactionType;
use Illuminate\Database\Eloquent\Model;
use function Illuminate\Support\defer;

class Transaction extends Model
{
    /** @use HasFactory<\Database\Factories\PureFinance\TransactionFactory> */
    use HasFactory;

    protected $fillable = [
        'account_id',
        'category_id',
        'type',
        'transfer_to',
        'amount',
        'payee',
        'date',
        'notes',
        'attachments',
        'status',
        'is_recurring',
        'frequency',
        'recurring_end',
        'parent_id'
    ];

    protected $with = ['category', 'category.parent', 'tags'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'type' => TransactionType::class,
            'date' => 'date',
            'attachments' => 'array',
            'status' => 'bool',
            'is_recurring' => 'bool',
            'frequency' => RecurringFrequency::class,
            'recurring_end' => 'date',
        ];
    }

    protected static function booted(): void
    {
        static::created(function (Transaction $transaction): void {
            $transaction->recalculateAccountBalance();
        });

        static::updated(function (Transaction $transaction): void {
            $transaction->recalculateAccountBalance();
        });

        static::deleted(function (Transaction $transaction): void {
            if ($transaction->account) {
                $transaction->recalculateAccountBalance();
            }
        });
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    protected function recalculateAccountBalance(): void
    {
        defer(function (): void {
            $total_credits = $this->account->transactions()
                ->whereIn('type', [TransactionType::CREDIT, TransactionType::DEPOSIT])
                ->sum('amount');

            $total_debits = $this->account->transactions()
                ->whereIn('type', [
                    TransactionType::DEBIT,
                    TransactionType::TRANSFER,
                    TransactionType::WITHDRAWAL
                ])
                ->sum('amount');

            $this->account->update(['balance' => $total_credits - $total_debits]);
        });
    }
}
