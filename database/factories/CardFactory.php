<?php

namespace Database\Factories;

use App\Models\CardType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Str;

class CardFactory extends Factory
{
    public function definition()
    {
        return [
            'serial' => Str::random(10),
            'code' => Str::random(10),
            'type_id' => CardType::factory(),
        ];
    }
}
