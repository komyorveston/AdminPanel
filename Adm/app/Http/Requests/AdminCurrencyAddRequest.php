<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminCurrencyAddRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    /* Rules */
    public function rules()
    {
        return [
            'code' => 'min:3|max:3|string',
        ];
    }

    /** Translate */
    public function message()
    {
        return [
            'code.min' =>'Минимальная длина 3 символов',
            'code.max' =>'Максимальная длина 3 символов',
            'code.string' =>'Код валюты должен быть строкой',
        ];
    }
}
