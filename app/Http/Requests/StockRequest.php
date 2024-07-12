<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StockRequest extends FormRequest
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
            'stock_1' => 'nullable',
            'stock_2' => 'nullable',
            'stock_3' => 'nullable',
            'stock_4' => 'nullable',
            'stock_5' => 'nullable',
            'stock_6' => 'nullable',
            'stock_7' => 'nullable',
        ];
    }
}
