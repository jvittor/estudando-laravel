<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Support\Facades\Auth;

class DeleteProductController extends Controller
{
    public function delete($id) {
        if (Products::where('id', $id)->where('user_id', Auth::id())->delete()) {
            return response()->json(['status' => 'success', 'message' => 'Product deleted successfully']);
        }

        return response()->json(['status' => 'error', 'message' => 'Product not found or not authorized to delete']);
    }
}
