<?php

namespace App\Models;

use App\Models\PureFinance\Tag;
use App\Models\MovieVault\Vault;
use App\Models\PureFinance\Account;
use App\Models\PureFinance\Category;
use App\Models\PureFinance\Transaction;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected static function booted(): void
    {
        // static::creating(function (User $user) {
        //     $categories = collect([
        //         'Paycheck',
        //         'Mortgage',
        //         'Rent',
        //         'Groceries',
        //         'Gas',
        //         'Electric'
        //     ]);

        //     $categories->each(function (string $category) use ($user): void {
        //         $user->categories()->create(['name' => $category]);
        //     });
        // });
    }

    public function vaults(): HasMany
    {
        return $this->hasMany(Vault::class);
    }

    public function accounts(): HasMany
    {
        return $this->hasMany(Account::class);
    }

    public function transactions(): HasManyThrough
    {
        return $this->hasManyThrough(Transaction::class, Account::class);
    }

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }

    public function tags(): HasMany
    {
        return $this->hasMany(Tag::class);
    }
}
