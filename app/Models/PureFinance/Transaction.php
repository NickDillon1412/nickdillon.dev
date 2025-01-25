<?php

namespace App\Models\PureFinance;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Actions\PureFinance\RecalculateAccountBalance;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Enums\PureFinance\RecurringFrequency;
use App\Enums\PureFinance\TransactionType;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    /** @use HasFactory<\Database\Factories\PureFinance\TransactionFactory> */
    use HasFactory;

    protected $fillable = [
        'account_id',
        'category_id',
        'type',
        'amount',
        'description',
        'date',
        'notes',
        'attachments',
        'status',
        'is_recurring',
        'frequency',
        'recurring_end',
        'parent_id'
    ];

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
        $action = app(RecalculateAccountBalance::class);

        static::created(function (Transaction $transaction) use ($action): void {
            $action->handle($transaction->account);
        });

        static::updated(function (Transaction $transaction) use ($action): void {
            $action->handle($transaction->account);
        });

        static::deleted(function (Transaction $transaction) use ($action): void {
            $action->handle($transaction->account);
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

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Transaction::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Transaction::class, 'parent_id');
    }
}
