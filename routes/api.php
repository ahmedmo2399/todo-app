<?php
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\TaskController;
use App\Http\Controllers\API\CategoryController;

// Auth routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Protected Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', fn () => new UserResource(Auth::user()));
    Route::apiResource('tasks', TaskController::class);
    Route::get('tasks/status', [TaskController::class, 'filterByStatus']);
    Route::post('tasks/{task}/restore', [TaskController::class, 'restore']);
    Route::get('categories', [CategoryController::class, 'index']);
    Route::apiResource('categories', CategoryController::class);
});

Route::get('tasks/search', [TaskController::class, 'search']);
