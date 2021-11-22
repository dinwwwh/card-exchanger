<?php

namespace App\Models;

use App\Traits\Trackable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Card extends Model
{
    use
        HasFactory,
        Trackable;

    protected $hidden = [
        'code'
    ];
    protected  $fillable = [
        'serial',
        'code',
        'type_id',
        'approver_id',
        'approver_at',
        'description',
        'received_value',
        'paid_at',
        'wallet_id',
    ];
    protected $casts = [
        'approver_at' => 'datetime',
    ];
    protected $with = [
        'type'
    ];

    /** Booted hook */
    protected static function booted()
    {
        static::created(function (self $card) {
            $card->type->invokeCallback($card);
        });
    }

    /** Card type relation */
    public function type(): BelongsTo
    {
        return $this->belongsTo(CardType::class, 'type_id');
    }

    /** Wallet relation */
    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class);
    }
}
