<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\BascetController;
use App\Http\Controllers\ProductController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::post("/register", [AuthController::class, "signUp"]);
Route::post("/login", [AuthController::class, "signIn"]);

Route::group(['middleware' => 'user'], function(){
    Route::post("/logout", [AuthController::class, "logout"]);
    
    Route::get('/products', [ProductController::class, 'all']);

    Route::get('/cart/{product_id}', [BascetController::class, 'store']);
    Route::get('/cart', [BascetController::class,'all']);
    Route::delete('/cart/{id}',[BascetController::class, 'destroy']);   

    Route::post('/order', [OrderController::class, 'store']);

    Route::get('/order',[OrderController::class, 'all']);
});

Route::group(['middleware' => 'admin'], function(){
    Route::post('/product', [ProductController::class, 'store']);
});