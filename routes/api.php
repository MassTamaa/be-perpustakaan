<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BookController;
use App\Http\Controllers\API\RoleController;
use App\Http\Controllers\API\ProfileController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\BorrowController;


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

Route::prefix('v2')->group(function () {
    Route::apiResource('category', CategoryController::class);
    Route::apiResource('role', RoleController::class);
    Route::apiResource('book', BookController::class);
    Route::prefix('auth')->group(function () {
        Route::post('register', [AuthController::class, 'register']);
        Route::post('login', [AuthController::class, 'login']);
        Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api');
    });
    Route::get('me', [AuthController::class, 'getUser'])->middleware('auth:api');
    Route::post('profile', [ProfileController::class, 'store'])->middleware('auth:api');
    Route::apiResource('borrow', BorrowController::class)->middleware('auth:api');
});
