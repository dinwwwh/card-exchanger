<?php

namespace App\Models;

use App\Traits\Trackable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Wallet extends Model
{
    use
        HasFactory,
        Trackable;

    /** Wallet types */
    public const MOMO_TYPE = 1;

    protected  $fillable = [
        'account',
        'type',
    ];

    /** Card relations */
    public function cards(): HasMany
    {
        return $this->hasMany(Card::class);
    }
}
