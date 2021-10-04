<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StoreProductPostRequest extends FormRequest
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
    public function rules(Request $request)
    {
        $input = $request->input();
        $role = [
            'product_category_id' => [
                'integer',
                Rule::exists('product_categories', 'product_category_id')->where(function ($query) {
                    $query->whereNull('deleted_at');
                }),
            ],
            'price' => [
                'required',
                'regex:/^\d*(\.\d{2})?$/',
            ],
            'product_name' => 'required|string|min:3|max:100',
        ];

        return $role;
    }
}
