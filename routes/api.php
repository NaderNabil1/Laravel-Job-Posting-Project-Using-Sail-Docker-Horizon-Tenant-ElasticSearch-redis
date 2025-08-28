<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\JobPostingController;
use App\Http\Controllers\JobSearchController;
use App\Http\Middleware\SetTenant;
use Illuminate\Support\Facades\Route;

Route::middleware(['tenant'])->group(function () {
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:api')->group(function () {
        Route::apiResource('jobs', JobPostingController::class);
        Route::get('jobs/search', [JobSearchController::class, 'search']);
    });
});
