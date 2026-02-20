<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\EmployeeController;
use App\Http\Controllers\Api\V1\DepartmentController;
use App\Http\Controllers\Api\V1\UserController;

Route::prefix('v1')->group(function () {
    // Public routes
    Route::post('register', [UserController::class, 'register']);
    Route::post('login', [UserController::class, 'login']);

    // Protected routes
    Route::middleware('auth:api')->group(function () {
        Route::post('logout', [UserController::class, 'logout']);

        Route::apiResource('employees', EmployeeController::class);
        Route::apiResource('departments', DepartmentController::class);
    });
});