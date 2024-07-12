<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VarietyRequest extends FormRequest
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
            'option_1' => 'nullable',
            'option_2' => 'nullable',
            'option_3' => 'nullable',
            'option_4' => 'nullable',
            'option_5' => 'nullable',
            'option_6' => 'nullable',
            'option_7' => 'nullable',
        ];
    }
}
