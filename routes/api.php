<?php

use App\Http\Controllers\API\TaskController;
use App\Http\Controllers\API\UserController;
use Illuminate\Support\Facades\Route;

Route::post('login', [UserController::class, 'login']);
Route::post('register', [UserController::class, 'register']);
Route::post('logout', [UserController::class, 'logout'])->middleware('auth:sanctum');

Route::group(['prefix' => 'tasks', 'middleware' => 'auth:sanctum'], function () {
    Route::get('/', [TaskController::class, 'index']);
    Route::get('/{id}', [TaskController::class, 'view']);
    Route::post('add', [TaskController::class, 'add']);
    Route::get('edit/{id}', [TaskController::class, 'edit']);
    Route::post('update/{id}', [TaskController::class, 'update']);
    Route::delete('delete/{id}', [TaskController::class, 'delete']);
});
