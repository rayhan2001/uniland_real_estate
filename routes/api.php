<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Auth\AgentAuthController;
use App\Http\Controllers\Auth\UserAuthController;
use App\Http\Controllers\Category\CategoryController;

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

// User Routes
Route::post('register', [UserAuthController::class, 'register']);
Route::post('login', [UserAuthController::class, 'login']);
Route::middleware('auth:api', 'user')->group(function () {
    Route::post('logout', [UserAuthController::class, 'logout']);
    Route::get('user/dashboard', function () {
        return response()->json(['message' => 'Welcome, User!']);
    });
});

// Agent Routes
Route::post('agent/register', [AgentAuthController::class, 'register']);
Route::post('agent/login', [AgentAuthController::class, 'login']);
Route::middleware('auth:agent')->group(function () {
    Route::post('agent/logout', [AgentAuthController::class, 'logout']);
    Route::get('agent/dashboard', function () {
        return response()->json(['message' => 'Welcome, Agent!']);
    });
});

// Admin Routes
Route::post('admin/register', [AdminAuthController::class, 'register']);
Route::post('admin/login', [AdminAuthController::class, 'login']);
Route::middleware('auth:admin', 'admin')->group(function () {
    Route::post('admin/logout', [AdminAuthController::class, 'logout']);
    Route::get('admin/dashboard', function () {
        return response()->json(['message' => 'Welcome, Admin!']);
    });
    Route::prefix('category')->group(function () {
        Route::post('store', [CategoryController::class, 'store']);
        Route::post('update/{id}', [CategoryController::class, 'update']);
        Route::delete('delete/{id}', [CategoryController::class, 'destroy']);
        Route::get('get-all-categories', [CategoryController::class, 'allCategory']);
    });
});

