<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class CRUDManager extends Controller
{
    function create(Request $request) 
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required|email',
            'price' => 'required',
            
        ]);
    }
};