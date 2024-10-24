<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class CRUDManager extends Controller
{
    function create(Request $request) 
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required|string',
            'price' => 'required|numeric',  
        ]);
        if ($validation->fails()) {
            return response()->json(['status' => 'error', 'message' => $validation->messages()]);
        }
        $product = new Products();
        $product->name = $request->input('name');
        $product->user_id = Auth::user()->id;
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        if ($product->save()) {
            return response()->json(['status' => 'success', $product,
             'message' => 'Product created successfully']);
        }
        
    }

    function read(){
        $products = Products::all();
        return response()->json(['status' => 'success', 'data' => $products]);
    }

    function update(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required|string',
            'price' => 'required|numeric',
        ]);

        if($validator->fails()){
            return response()->json(['status' => 'error', 'message' => $validator->messages()]);
        }
        $validator = $validator->validated();
        $product = Products::where('id', $id)->where('user_id', Auth::id())->first();
        if (!$product) {
            return response()->json(['status' => 'error', 'message' => 'Product not found']);
        };
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        if($product->save()){
            return response()->json(['status' => 'success', 'data' => $product,
            'message' => 'Product updated successfully']);
        }
    }
};