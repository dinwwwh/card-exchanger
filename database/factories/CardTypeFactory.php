<?php

namespace Database\Factories;

use App\Models\User;
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

    /**
     * Define the approving card
     *
     */
    public function approving()
    {
        return $this->state([
            'approver_id' => User::Factory(),
        ]);
    }

    /**
     * Define a card that error approved
     *
     */
    public function errorApproved()
    {
        return $this->state([
            'approver_id' => User::Factory(),
            'approved_at' => now()->subMinute(),
            'received_value' => 0,
            'description' => 'Thẻ cào sai thông tin'
        ]);
    }

    /**
     * Define a card that success approved
     *
     */
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
