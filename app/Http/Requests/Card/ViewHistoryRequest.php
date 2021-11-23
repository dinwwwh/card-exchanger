<?php

namespace App\Http\Requests\Card;

use Illuminate\Foundation\Http\FormRequest;

class ViewHistoryRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'page' => ['integer', 'min:0'],
            'search' => ['string'],
        ];
    }
}
