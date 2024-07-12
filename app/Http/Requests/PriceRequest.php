<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PriceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // 'product_id' => 'required|exists:products,id',
            'price_1' => 'nullable',
            'price_2' => 'nullable',
            'price_3' => 'nullable',
            'price_4' => 'nullable',
            'price_5' => 'nullable',
            'price_6' => 'nullable',
            'price_7' => 'nullable',
        ];
    }
}
