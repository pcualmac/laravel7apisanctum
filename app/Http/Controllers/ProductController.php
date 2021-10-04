<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\DeleteProductPostRequest;
use App\Http\Requests\Product\StoreProductPostRequest;
use App\Http\Requests\Product\UpdateProductPostRequest;
use App\ProductCategory;
use App\Products;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $product = Products::whereHas('product_category', function ($query) {
            $query->where('local', app()->getLocale());
        })->get();

        return response()->json([
            'status_code' => 200,
            'data' => $product->toArray(),
        ]);
    }

    public function store(StoreProductPostRequest $request)
    {
        $input = $request->input();
        // dd($input);
        $product = Products::create($input);
        $product_category = ProductCategory::where('product_category_id', $product->product_category_id)->first();

        return response()->json([
            'status_code' => 200,
            'data' => $product,
            'local' => app()->getLocale(),
        ]);
    }

    public function destroy(DeleteProductPostRequest $request)
    {
        $input = $request->input();
        $product = Products::where('product_id', $input['product_id'])->delete();
        $data = Products::withTrashed()->where('product_id', $input['product_id'])->first();
        return response()->json([
            'status_code' => 200,
            'data' => $data,
            'local' => app()->getLocale(),
        ]);

    }

    public function update(UpdateProductPostRequest $request)
    {
        $input = $request->input();
        $product_to_be_update = Products::where('product_id', $input['product_id'])->update($input);
        $product_new = Products::where('product_id', $input['product_id'])->first();
        return response()->json([
            'status_code' => 200,
            'data' => $product_new,
            'local' => app()->getLocale(),
        ]);
    }
}
