<?php

namespace App\Models\MovieVault;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vault extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'vault_id',
        'vault_type',
        'title',
        'original_title',
        'name',
        'original_name',
        'overview',
        'backdrop_path',
        'poster_path',
        'release_date',
        'first_air_date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}