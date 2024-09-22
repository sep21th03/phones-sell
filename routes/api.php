<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\CategoryController;
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
Route::post('/user/register', [UserController::class, 'register']);
Route::post('/admin/login', [AdminController::class, 'postlogin'])->name('admin.postlogin');

Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::prefix('category')->group(function () {
        Route::post('/get/category', [CategoryController::class, 'index']);
        Route::post('/get/search', [CategoryController::class, 'search']);
        Route::post('/add/category', [CategoryController::class, 'store']);
        Route::post('/edit/category', [CategoryController::class, 'update']);
        Route::post('/delete/category', [CategoryController::class, 'destroy']);
    });
});
