<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\User\UserGetController;
use App\Http\Controllers\Admin\AdminController;

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

Route::post('/user/login', [UserController::class, 'login']);
Route::get('/login', [UserController::class, 'login']);
Route::post('/user/register', [UserController::class, 'register']);
Route::get('/register', [UserController::class, 'register']);
Route::post('/admin/login', [AdminController::class, 'postlogin']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::prefix('category')->group(function () {
        Route::post('/get/category', [CategoryController::class, 'index']);
        Route::post('/get/search', [CategoryController::class, 'search']);
        Route::post('/add/category', [CategoryController::class, 'store']);
        Route::post('/edit/category', [CategoryController::class, 'update']);
        Route::post('/delete/category', [CategoryController::class, 'destroy']);
    });
    Route::prefix('product')->group(function () {
        Route::post('/get/product', [ProductController::class, 'index']);
        Route::get('/get/product', [ProductController::class, 'index']);
        Route::post('/get/product/{id}', [ProductController::class, 'show']);
        Route::post('/add/color/', [ProductController::class, 'addColor']);
        Route::post('/edit/product', [ProductController::class, 'update']);

    });
});
//User
Route::get('/user/get/user', [UserGetController::class, 'get_user_list']);
Route::get('/user/get/user_by_id', [UserGetController::class, 'get_info_by_id']);

Route::get('/get/category', [CategoryController::class, 'index']);
Route::get('/get/product', [ProductController::class, 'index']);
Route::get('/get/product/{id}', [ProductController::class, 'show']);
Route::post('/get/product', [ProductController::class, 'index']);
