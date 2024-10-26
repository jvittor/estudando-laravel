<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UpdateProductController extends Controller
{
    public function update(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required|string',
            'price' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->messages()]);
        }

        $product = Products::where('id', $id)->where('user_id', Auth::id())->first();
        if (!$product) {
            return response()->json(['status' => 'error', 'message' => 'Product not found']);
        }

        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = $request->input('price');

        if ($product->save()) {
            return response()->json(['status' => 'success', 'data' => $product, 'message' => 'Product updated successfully']);
        }
    }
}
