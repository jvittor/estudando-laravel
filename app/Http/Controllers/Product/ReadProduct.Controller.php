<?php

namespace App\Http\Controllers;

use App\Models\Products;

class ReadProductController extends Controller
{
    public function read() {
        $products = Products::all();
        return response()->json(['status' => 'success', 'data' => $products]);
    }
}
