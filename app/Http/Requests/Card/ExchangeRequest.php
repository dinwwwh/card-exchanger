<?php

namespace App\Http\Requests\Card;

use App\Models\Wallet;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ExchangeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'typeId' => ['required', 'integer', 'exists:card_types,id'],
            'serial' => ['required', 'string'],
            'code' => ['required', 'string'],

            # Wallet relation
            'wallet' => ['required', 'array'],
            'wallet.account' => ['required', 'string'],
            'wallet.type' => ['required', 'integer', Rule::in([Wallet::MOMO_TYPE])],
        ];
    }
}
