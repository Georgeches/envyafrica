<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/orders', [ApiController::class, 'getOrders']);
Route::get('/customers', [ApiController::class, 'getCustomers']);
Route::get('/products', [ApiController::class, 'getProducts']);
Route::get('/categories', [ApiController::class, 'getCategories']);
Route::get('/users', [ApiController::class, 'getUsers']);

Route::get('/orders/{id}', [ApiController::class, 'getOrder']);
Route::get('/customers/{id}', [ApiController::class, 'getCustomer']);
Route::get('/products/{id}', [ApiController::class, 'getProduct']);
Route::get('/categories/{id}', [ApiController::class, 'getCategory']);
Route::get('/users/{id}', [ApiController::class, 'getUser']);