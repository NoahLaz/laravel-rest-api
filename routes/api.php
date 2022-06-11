<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::post('/products', [ProductController::class, 'store']);

    Route::get('/products/{product}', [ProductController::class, 'show']);

    Route::put('/products/{product}', [ProductController::class, 'update']);

    Route::delete('/products/{product}', [ProductController::class, 'destroy']);

    ///**

    Route::post('/logout', [UserController::class, 'logout']);
});

Route::get('/products', [ProductController::class, 'index']);

Route::get('/products/search/{name}', [ProductController::class, 'search']);

// Route::resource('products', 'ProductController');

// USER ROUTES

Route::post('/register', [UserController::class, 'register']);

Route::post('/login', [UserController::class, 'login']);
