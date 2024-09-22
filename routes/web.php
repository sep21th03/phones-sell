<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\WebController;

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
Route::get('/user/login', [WebController::class, 'login_page'])->name('login_page');
Route::get('/user/register', [WebController::class, 'register'])->name('register');
Route::middleware(['auth:sanctum'])->group(function (){
    Route::get('/', [WebController::class, 'dashboard'])->name('dashboard');
});

Route::prefix('/admin')->middleware('admin')->group(function(){
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/category', [DashboardController::class, 'manager_category'])->name('admin.category.list');
    Route::get('/product', [DashboardController::class, 'manager_product'])->name('admin.product.list');
    //API 
    Route::get('/get/category', [CategoryController::class, 'index']);
    // Route::get('/get/category', [ProductController::class, 'index']);
});

Route::get('/admin/login', [AdminController::class, 'login'])->name('admin.login');
