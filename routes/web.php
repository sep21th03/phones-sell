<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\WebController;
use App\Http\Controllers\CKEditorController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\User\UserGetController;

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
Route::prefix('/admin')->middleware('admin')->group(function () {
    //Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    //Categpry
    Route::get('/category', [DashboardController::class, 'manager_category'])->name('category.list');
    //Product
    Route::get('/product', [DashboardController::class, 'manager_product'])->name('product.list');
    Route::get('/product/{id}', [DashboardController::class, 'detai_product'])->name('product.detail');;
    Route::get('/add/product/', [DashboardController::class, 'add_product'])->name('product.add');;

});

Route::middleware('auth:sanctum')->get('/check-session', [Controller::class, 'checkSession']);

Route::get('/ckeditor/upload', [CKEditorController::class, 'upload'])->name('ckeditor.upload');
