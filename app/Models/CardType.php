<?php

namespace App\Models;

use App\Traits\Callbackable;
use App\Traits\Trackable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CardType extends Model
{
    use
        HasFactory,
        Trackable,
        Callbackable;

    protected  $fillable = [
        'telco',
        'value',
        'fees',
        'penalty',
    ];

    /** Card relations */
    public function cards(): HasMany
    {
        return $this->hasMany(Card::class);
    }
}
