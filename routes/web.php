<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\WebController;
use App\Http\Controllers\CKEditorController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\UserController;

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

Route::get('/login', [WebController::class, 'login_page'])->name('login_page');
Route::get('/register', [WebController::class, 'register'])->name('register');
Route::get('/admin/login', [AdminController::class, 'login'])->name('auth.login');
// Route::middleware(['auth:sanctum'])->group(function () {
//     Route::get('/', [WebController::class, 'dashboard'])->name('dashboard');
// });
Route::get('/', function () {
    return redirect('/admin');
});
Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    //Dashboard
    Route::prefix('/admin')->get('/', [DashboardController::class, 'index'])->name('dashboard');
    //Category
    Route::prefix('category')->group(function () {
        Route::get('/', [DashboardController::class, 'manager_category'])->name('category.list');
        Route::get('/get', [CategoryController::class, 'index'])->name('category.index');
        Route::post('/add', [CategoryController::class, 'store'])->name('category.store');
        Route::post('/edit', [CategoryController::class, 'update'])->name('category.update');
        Route::post('/delete', [CategoryController::class, 'destroy'])->name('category.destroy'); 
    });
    //Product
    Route::prefix('product')->group(function () {
        Route::get('/', [DashboardController::class, 'manager_product'])->name('product.list');
        Route::get('/get', [ProductController::class, 'index'])->name('product.index');
        Route::get('/{id}', [DashboardController::class, 'detai_product'])->name('product.detail');;
        Route::get('/add/product/', [DashboardController::class, 'add_product'])->name('product.add');
        Route::get('/get/{id}', [ProductController::class, 'show'])->name('product.show');
        Route::post('/add/color/', [ProductController::class, 'addColor'])->name('product.addColor');
        Route::post('/edit', [ProductController::class, 'update'])->name('product.update');
        Route::post('/add', [ProductController::class, 'store'])->name('product.store');
        Route::post('/delete', [ProductController::class, 'destroy'])->name('product.destroy');
        Route::post('/delete/products', [ProductController::class, 'deleteProducts'])->name('product.deleteProducts');
        Route::post('/delete/color', [ProductController::class, 'deleteProductColor'])->name('product.deleteProductColor');
        Route::get('/get/category={query}', [ProductController::class, 'getProductsByCategory']);
    });
    Route::prefix('user')->group(function () {
        Route::get('/', [DashboardController::class, 'manager_user'])->name('user.list');
        Route::get('/get', [UserController::class, 'index'])->name('user.index');
        Route::post('/edit', [UserController::class, 'update'])->name('user.update');
    });
});

Route::middleware('auth:sanctum')->get('/check-session', [Controller::class, 'checkSession']);

Route::get('/ckeditor/upload', [CKEditorController::class, 'upload'])->name('ckeditor.upload');
