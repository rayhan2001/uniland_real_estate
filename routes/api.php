<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Auth\AgentAuthController;
use App\Http\Controllers\Auth\UserAuthController;
use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\SubCategory\SubCategoryController;
use App\Http\Controllers\Setting\SettingController;
use App\Http\Controllers\Propertie\PropertieController;
use App\Http\Controllers\Slider\SliderController;
use Illuminate\Support\Facades\Artisan;

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
        Route::post('update', [CategoryController::class, 'update']);
        Route::delete('delete/{id}', [CategoryController::class, 'destroy']);
        Route::get('get-all-categories', [CategoryController::class, 'allCategory']);
    });

    Route::prefix('sub-category')->group(function () {
        Route::post('store', [SubCategoryController::class, 'store']);
        Route::post('update', [SubCategoryController::class, 'update']);
        Route::delete('delete/{id}', [SubCategoryController::class, 'destroy']);
        Route::get('get-all-sub-categories', [SubCategoryController::class, 'allSubCategory']);
    });

    Route::prefix('settings')->group(function () {
        Route::get('site-info', [SettingController::class, 'getSiteInfo']);
        Route::post('site-info/update', [SettingController::class, 'updateSiteInfo']);
        Route::get('contact-info', [SettingController::class, 'getContactInfo']);
        Route::post('contact-info/update', [SettingController::class, 'updateContactInfo']);
        Route::get('social-info', [SettingController::class, 'getSocialInfo']);
        Route::post('social-info/update', [SettingController::class, 'updateSocialInfo']);
        Route::get('mail-config', [SettingController::class, 'mailInfo']);
        Route::post('mail-config/update', [SettingController::class, 'updateMailConfig']);
    });

    Route::prefix('properties')->group(function () {
        Route::post('store', [PropertieController::class, 'store']);
        Route::post('update', [PropertieController::class, 'update']);
        Route::delete('delete/{id}', [PropertieController::class, 'destroy']);
        Route::get('get-regular-properties', [PropertieController::class, 'allData']);
    });

    Route::prefix('sliders')->group(function () {
        Route::post('store', [SliderController::class, 'store']);
        Route::post('update', [SliderController::class, 'update']);
        Route::delete('delete/{id}', [SliderController::class, 'destroy']);
        Route::get('get-slider-data', [SliderController::class, 'allData']);
    });
});

Route::get('case-clear', function () {
    Artisan::call('optimize:clear');
    return "Cleared!";
});

