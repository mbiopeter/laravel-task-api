<?php

use App\Http\Controllers\Api\TaskController;
use Illuminate\Support\Facades\Route;

Route::prefix('tasks')->group(function () {
    Route::post('/', [TaskController::class, 'store']);
    Route::get('/', [TaskController::class, 'index']);
    Route::patch('/{id}/status', [TaskController::class, 'updateStatus']);
    Route::delete('/{id}', [TaskController::class, 'destroy']);
    Route::get('/report', [TaskController::class, 'report']);
});