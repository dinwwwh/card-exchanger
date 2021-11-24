<?php

namespace Database\Factories;

use App\Models\CardType;
use App\Models\User;
use App\Models\Wallet;
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
            'wallet_id' => Wallet::factory(),
        ];
    }

    /** Define the approving card */
    public function approving()
    {
        return $this->state([
            'approver_id' => User::Factory(),
        ]);
    }

    /** Define a card that error approved */
    public function errorApproved()
    {
        return $this->state([
            'approver_id' => User::Factory(),
            'approved_at' => now()->subMinute(),
            'received_value' => 0,
            'description' => 'Thẻ cào sai thông tin'
        ]);
    }

    /** Define a card that success approved */
    public function successApproved()
    {
        return $this->state([
            'approver_id' => User::Factory(),
            'approved_at' => now()->subMinute(),
            'received_value' => 10000,
            'description' => 'Nạp thẻ thành công'
        ]);
    }
}
