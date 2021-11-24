<?php

namespace Database\Factories;

use App\Models\Wallet;
use Illuminate\Database\Eloquent\Factories\Factory;

class WalletFactory extends Factory
{
    public function definition()
    {
        return [
            'account' => '0372206223',
            'type' => Wallet::MOMO_TYPE,
        ];
    }
}
