<?php

namespace App\Models\PureFinance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /** @use HasFactory<\Database\Factories\PureFinance\CategoryFactory> */
    use HasFactory;

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }
}
