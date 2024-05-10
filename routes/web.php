<?php

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CookieController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Products routes
Route::get('/', [ProductController::class, 'index']);
// Route::get('/hash', function(){
//     dd(bcrypt(''));
// });
Route::get('/all', [ProductController::class, 'index2']);
// Route::get('/adminpage/products/create', [ProductController::class, 'create']);
// Route::get('/adminpage/products/edit/{id}', [ProductController::class, 'edit']);
Route::get('/products/{id}', [ProductController::class, 'show']);
Route::post('/products', [ProductController::class, 'store']);
Route::put('/products/{id}', [ProductController::class, 'update']);
Route::delete('/products/{id}', [ProductController::class, 'destroy']);

//Cart
Route::get('/cart', [CartController::class, 'index']);
Route::get('/cart/increment/{id}', [CartController::class, 'increaseQuantity']);
Route::get('/cart/decrement/{id}', [CartController::class, 'decreaseQuantity']);
Route::delete('/cart/delete/{id}', [CartController::class, 'removeFromCart']);
Route::get('/cart/add/{id}', [CartController::class, 'addToCart']);

Route::get('/customerinfo', [CustomerController::class, 'create']);
Route::post('/customer/new', [CustomerController::class, 'new']);
Route::post('/customer/save', [CustomerController::class, 'saveCustomerDetails']);
Route::post('/sendmail', [CustomerController::class, 'sendContactMail']);

Route::get('/checkout', [OrderController::class, 'create']);
Route::post('/order/new', [OrderController::class, 'new']);

Route::get('/stk/initiate', [PaymentController::class, 'initiateSTK']);
Route::get('/stk/callback', [PaymentController::class, 'stkCallback']);
Route::get('/pesapal/callback', [CardController::class, 'callback']);

//Admin
// Route::get('/adminpage', [AdminController::class, 'index']);
// Route::get('/adminpage/registeradmin', [UserController::class, 'create']);
// Route::post('/users', [UserController::class, 'store']);
// Route::get('/admin/login', [UserController::class, 'login']);
// Route::post('/admin/authenticate', [UserController::class, 'authenticate']);
