<?php

namespace App\Models\PureFinance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use App\Models\PureFinance\Category;

class PlannedExpense extends Model
{
    /** @use HasFactory<\Database\Factories\PureFinance\PlannedSpendingFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'category_id',
        'monthly_amount'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
