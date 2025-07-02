<?php

use App\Http\Controllers\Api\TaskController;
use Illuminate\Support\Facades\Route;

Route::apiResource('tasks', TaskController::class);
Route::patch('tasks/{task}/toggle', [TaskController::class, 'toggle']);
