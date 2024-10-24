<?php

use App\Http\Controllers\CRUDManager;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

Route::any("user/register", function () {
    $faker = Faker\Factory::create();
    $user = new User();
    $user->name = $faker->name;
    $user->email = $faker->email;
    $user->password = Hash::make('password');
    if($user->save()) {
        $token = $user ->createToken("auth_token")->plainTextToken;
        return response() ->json(["sucess" => "sucess", "data" => $user, 
        "token" => $token,
        "message" => "User created successfully"]);
    }
    return response()->json(["error" => "error", "message" => "Failed to create user"]);
});


Route::prefix("product")->middleware("auth:sanctum")->middleware("auth:sanctum")->group(function () {
    Route::post("create", [CRUDManager::class, "create"]);
    Route::post("read", [CRUDManager::class, "read"]);
    Route::post("update/{id}", [CRUDManager::class, "update"]);
});