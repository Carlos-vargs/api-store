<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Controllers\Auth\AuthController;

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

//Protected routes 
Route::group(['middleware' => ['auth:sanctum']], function () {
    
    Route::apiResource('v1/products', ProductController::class)
    ->only([
        'store', 'update', 'destroy', 
    ]);

    Route::post('/logout', [AuthController::class, 'logout']);


});

//Public routes 
Route::apiResource('v1/products', ProductController::class)
->only([
    'index', 'show',
]);

Route::get('v1/products/search/{title}', [ProductController::class, 'search']);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);