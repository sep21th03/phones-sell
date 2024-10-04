<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
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

Route::post('/user/login', [AuthController::class, 'login']);
Route::post('/user/register', [AuthController::class, 'register']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('user/info', [UserController::class, 'index']);
});


Route::get('category', [CategoryController::class, 'index']);
Route::get('product-list', [ProductController::class, 'index']);
Route::get('product-detail/{id}', [ProductController::class, 'show']);

Route::post('/some-endpoint', [Controller::class, 'someFunction']);
