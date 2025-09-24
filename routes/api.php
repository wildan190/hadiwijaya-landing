<?php

use App\Http\Controllers\Api\v1\Admin\FaqController;
use App\Http\Controllers\Api\v1\Admin\HeroController;
use App\Http\Controllers\Api\v1\Admin\ProjectController;
use App\Http\Controllers\Api\v1\Admin\VisitorController;
use App\Http\Controllers\Api\v1\Auth\AuthController;
use App\Http\Controllers\Api\v1\BlogController;
use App\Http\Controllers\Api\v2\BlogPublicController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1/auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        // Route::get('/profile', [AuthController::class, 'profile']);
        Route::post('/logout', [AuthController::class, 'logout']);
    });
});

Route::prefix('v1/admin')
    ->middleware('auth:sanctum')
    ->group(function () {
        // Blog Routes (tanpa resource)
        Route::get('/blogs', [BlogController::class, 'index']);
        Route::post('/blogs', [BlogController::class, 'store']);
        Route::get('/blogs/{id}', [BlogController::class, 'show']);
        Route::put('/blogs/{id}', [BlogController::class, 'update']);
        Route::delete('/blogs/{id}', [BlogController::class, 'destroy']);
    });

Route::prefix('v1/admin')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::get('/visitors/summary', [VisitorController::class, 'summary']);
        Route::get('/visitors/daily', [VisitorController::class, 'daily']);
        Route::get('/visitors/top-blogs', [VisitorController::class, 'topBlogs']);

        Route::get('/heroes', [HeroController::class, 'index']);
        Route::post('/heroes', [HeroController::class, 'storeOrUpdate']);
        Route::post('/heroes/{id}', [HeroController::class, 'storeOrUpdate']);
        Route::get('/heroes/{id}', [HeroController::class, 'show']);
        Route::delete('/heroes/{id}', [HeroController::class, 'destroy']);

        Route::get('/faqs', [FaqController::class, 'index']);
        Route::post('/faqs', [FaqController::class, 'store']);
        Route::get('/faqs/{id}', [FaqController::class, 'show']);
        Route::put('/faqs/{id}', [FaqController::class, 'update']);
        Route::delete('/faqs/{id}', [FaqController::class, 'destroy']);

        Route::get('/projects', [ProjectController::class, 'index']);
        Route::post('/projects', [ProjectController::class, 'store']);
        Route::get('/projects/{id}', [ProjectController::class, 'show']);
        Route::put('/projects/{id}', [ProjectController::class, 'update']);
        Route::delete('/projects/{id}', [ProjectController::class, 'destroy']);

        Route::get('/pricing-tables', [App\Http\Controllers\Api\v1\Admin\PricingTableController::class, 'index']);
        Route::post('/pricing-tables', [App\Http\Controllers\Api\v1\Admin\PricingTableController::class, 'store']);
        Route::get('/pricing-tables/{id}', [App\Http\Controllers\Api\v1\Admin\PricingTableController::class, 'show']);
        Route::put('/pricing-tables/{id}', [App\Http\Controllers\Api\v1\Admin\PricingTableController::class, 'update']);
        Route::delete('/pricing-tables/{id}', [App\Http\Controllers\Api\v1\Admin\PricingTableController::class, 'destroy']);
    });

Route::prefix('v2')
    ->middleware('throttle:60,1')
    ->group(function () {
        Route::get('/blogs', [BlogPublicController::class, 'index']);
        Route::get('/blogs/{slug}', [BlogPublicController::class, 'show']);
        Route::get('/heroes', [App\Http\Controllers\Api\v2\HomeController::class, 'heroes']);
        Route::get('/heroes/{id}', [App\Http\Controllers\Api\v2\HomeController::class, 'hero']);
        Route::get('/faqs', [App\Http\Controllers\Api\v2\HomeController::class, 'faqs']);
        Route::get('/projects', [App\Http\Controllers\Api\v2\HomeController::class, 'projects']);
        Route::get('/pricing-tables', [App\Http\Controllers\Api\v2\HomeController::class, 'pricintTable']);
    });
