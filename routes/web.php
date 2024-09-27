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
// Route::get('/login', [WebController::class, 'login_page'])->name('login_page');
// Route::get('/register', [WebController::class, 'register'])->name('register');
Route::get('/admin/login', [AdminController::class, 'login'])->name('admin.login');
Route::middleware(['auth:sanctum'])->group(function (){
    // Route::get('/', [WebController::class, 'dashboard'])->name('dashboard');
});

Route::prefix('/admin')->middleware('admin')->group(function(){
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/category', [DashboardController::class, 'manager_category'])->name('admin.category.list');
    Route::get('/product', [DashboardController::class, 'manager_product'])->name('admin.product.list');
    Route::get('/product/{id}', [DashboardController::class, 'detai_product'])->name('admin.product.detail');;
    //API 
    Route::get('/get/category', [CategoryController::class, 'index']);
});


Route::post('ckeditor/upload', [CKEditorController::class, 'upload'])->name('ckeditor.upload');
Route::get('/some-endpoint', [Controller::class, 'someFunction']);
Route::get('/get/category', [CategoryController::class, 'index']);
Route::get('/user/get/user', [UserGetController::class, 'get_user_list']);

Route::get('http://127.0.0.1:53293/login.html', function () {
    return redirect()->away('http://127.0.0.1:53293/index.html'); 
})->middleware('guest');
