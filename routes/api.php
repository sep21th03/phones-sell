<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\User\UserGetController;
use App\Http\Controllers\Admin\AdminController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/user/login', [UserController::class, 'login']);
Route::post('/user/register', [UserController::class, 'register']);
Route::post('/admin/login', [AdminController::class, 'postlogin']);
Route::middleware('auth:sanctum')->post('/logout', [UserController::class, 'logout']);


Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::prefix('category')->group(function () {
        Route::get('/get', [CategoryController::class, 'index'])->name('category.index');
        // Route::post('/search', [CategoryController::class, 'search'])->name('category.search');
        Route::post('/add', [CategoryController::class, 'store'])->name('category.store');
        Route::post('/edit', [CategoryController::class, 'update'])->name('category.update');
        Route::post('/delete', [CategoryController::class, 'destroy'])->name('category.destroy'); 
    });
    Route::prefix('product')->group(function () {
        Route::get('/get', [ProductController::class, 'index'])->name('product.index');
        Route::get('/filter', 'ProductController@filterProductList')->name('product.filter');
        Route::get('/get/{id}', [ProductController::class, 'show'])->name('product.show');
        Route::post('/add/color/', [ProductController::class, 'addColor'])->name('product.addColor');
        Route::post('/edit', [ProductController::class, 'update'])->name('product.update');
        Route::post('/add', [ProductController::class, 'store'])->name('product.store');
        Route::post('/delete', [ProductController::class, 'destroy'])->name('product.destroy');
        Route::post('/delete/products', [ProductController::class, 'deleteProducts'])->name('product.deleteProducts');
        Route::post('/delete/color', [ProductController::class, 'deleteProductColor'])->name('product.deleteProductColor');
        Route::get('/get/product/category={query}', [ProductController::class, 'getProductByCategory']);
    });
});
Route::post('/some-endpoint', [Controller::class, 'someFunction']);

//User
Route::get('/user/get/user', [UserGetController::class, 'get_user_list']);
Route::get('/user/get/user_by_id', [UserGetController::class, 'get_info_by_id']);

