<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Controller;
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

Route::post('/user/login', [AuthController::class, 'login']);
Route::post('/user/register', [AuthController::class, 'register']);
Route::get('login/google', [AuthController::class, 'redirectToGoogle']);
Route::get('login/google/callback', [AuthController::class, 'handleGoogleCallback']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('cart', [CartController::class, 'getMyCart']);
    Route::post('cart/update', [CartController::class, 'updateMyCart']);

    Route::post('product-detail/review', [ProductController::class, 'storeProductReview']);

    Route::get('order', [OrderController::class, 'getListByUser']);
    Route::get('order/detail/{id}', [OrderController::class,'getDetailOrder']);
    Route::post('order/store', [OrderController::class,'store']);
    Route::post('order/update/{id}', [OrderController::class,'update']);
    Route::post('order/delete/{id}', [OrderController::class,'delete']);
    Route::post('order/vnpay_payment', [OrderController::class,'vnpayPayment']);

    Route::get('/user-id', [UserController::class, 'getUserId']);
    Route::get('/user', [UserController::class, 'getUsers']);
});


Route::get('category', [CategoryController::class, 'index']);
Route::get('product-list', [ProductController::class, 'index']);
Route::get('product-detail/{id}', [ProductController::class, 'show']);


Route::get('reviews', [ProductController::class, 'getReviews']);
Route::get('review/{id}', [ProductController::class, 'getReviewByProduct']);
Route::get('reviewsall', [ProductController::class, 'getReviewsAll']);

Route::post('/some-endpoint', [Controller::class, 'someFunction']);
