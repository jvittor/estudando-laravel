<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Products;

class ReadProductController extends Controller
{
    public function read() {
        $products = Products::all();
        return response()->json(['status' => 'success', 'data' => $products]);
    }
}
