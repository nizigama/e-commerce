<?php

use App\Http\Controllers\Auth\AuthenticationController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CatalogController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix("v1")->group(function () {

    Route::prefix("auth")->group(function () {

        Route::post("register", [AuthenticationController::class, "register"]);
        Route::post("login", [AuthenticationController::class, "login"]);
        Route::get("logout", [AuthenticationController::class, "logout"]);
    });

    Route::prefix("catalog")->group(function () {

        Route::get("list", [CatalogController::class, "index"]);
    });

    Route::prefix("cart")->group(function () {

        Route::get("", [CartController::class, "index"]);
        Route::post("", [CartController::class, "store"]);
        Route::delete("{itemID}", [CartController::class, "destroy"])->whereNumber("itemID");
    });
});
