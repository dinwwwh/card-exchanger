<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CardTypeFactory extends Factory
{
    public function definition()
    {
        return [
            'value' => 10000,
            'telco' => 'VIETTEL',
            'fees' => 20,
            'penalty' => 30,
        ];
    }
}
