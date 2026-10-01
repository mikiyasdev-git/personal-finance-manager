<?php

use App\Http\Controllers\Api\AccountController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BudgetController;
use App\Http\Controllers\Api\ReportController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('accounts', AccountController::class);
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('transactions', TransactionController::class);
    Route::apiResource('budgets', BudgetController::class);
    Route::get('/reports/summary', [ReportController::class, 'summary']);
    Route::get('/reports/transactions', [ReportController::class, 'transactions']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
});
