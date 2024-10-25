<?php

use App\Http\Controllers\CRUDManager;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

Route::post("user/register", function (Request $request) {
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:6'
    ]);

    if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
    }

    $user = new User();
    $user->name = $request->name;
    $user->email = $request->email;
    $user->password = Hash::make($request->password);

    if ($user->save()) {
        $token = $user->createToken("auth_token")->plainTextToken;
        return response()->json([
            "success" => "success",
            "data" => $user,
            "token" => $token,
            "message" => "User created successfully"
        ]);
    }

    return response()->json(["error" => "error", "message" => "Failed to create user"]);
});


Route::post("user/login", function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user) {
        Log::error('User not found', ['email' => $request->email]);
        return response()->json(["error" => "Unauthorized", "message" => "User not found"], 401);
    }

    if (!Hash::check($request->password, $user->password)) {
        Log::error('Password mismatch', ['email' => $request->email]);
        return response()->json(["error" => "Unauthorized", "message" => "Invalid credentials"], 401);
    }

    $token = $user->createToken("auth_token")->plainTextToken;

    return response()->json([
        "success" => "success",
        "data" => $user,
        "token" => $token,
        "message" => "Login successful"
    ]);
});

Route::prefix("product")->middleware("auth:sanctum")->middleware("auth:sanctum")->group(function () {
    Route::post("create", [CRUDManager::class, "create"]);
    Route::post("read", [CRUDManager::class, "read"]);
    Route::post("update/{id}", [CRUDManager::class, "update"]);
    Route::post("delete/{id}", [CRUDManager::class, "delete"]);
});