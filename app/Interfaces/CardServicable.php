<?php

namespace App\Interfaces;

use App\Models\Card;
use App\Models\CardType;
use Illuminate\Database\Eloquent\Collection;

interface CardServicable
{
    public static function syncCardTypes(): Collection;
    public static function approve(CardType $type, Card $card): void;
}
