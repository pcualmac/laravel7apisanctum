<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UpdateProductPostRequest extends FormRequest
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
        // dd($input);
        $role = [
            'product_category_id' => [
                'required',
                'integer',
                Rule::exists('product_categories', 'product_category_id')->where(function ($query) {
                    $query->whereNull('deleted_at')
                        ->where('local', app()->getLocale());
                }),
            ],
            'product_id' => [
                'required_with:product_category_id',
                'integer',
                Rule::exists('products', 'product_id')->where('product_category_id', $input['product_category_id']),
            ],
            'price' => [
                'required',
                'regex:/^\d*(\.\d{2})?$/',
            ],
            'product_name' => 'required|string|min:3|max:100',
        ];
        // dd($role, $input);
        return $role;
    }
}
