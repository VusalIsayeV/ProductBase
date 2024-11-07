<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'ProductName' => 'required|string|max:255',
            'Unit' => 'required|string',
            'Status' => 'required|string',
            'Barcode' => 'required|string|unique:register',
            'BaseId' => 'required|exists:base,id',
            'Count' => 'required|integer|min:1',
        ];
    }
}
