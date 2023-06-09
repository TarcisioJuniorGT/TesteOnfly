<?php

/**
 * @OA\OpenApi(
 *     @OA\Info(
 *         version="1.0",
 *         title="Minha API",
 *         description="Descrição da minha API"
 *     )
 * )
 */

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\UserController;

Route::post('login', [AuthController::class, 'login']);
Route::apiResource('users', UserController::class)->only('store');

Route::group(['middleware' => ['jwt.auth']], function () {
    Route::apiResource('expenses', ExpenseController::class);
    Route::apiResource('users', UserController::class)->only('update');
});
