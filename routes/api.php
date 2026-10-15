<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Пинг-маршрут для проверки работоспособности API
Route::get('/ping', function () {
    return response()->json([
        'message' => 'pong',
        'time' => now()->toIso8601String(),
        'student' => config('lab.student'),
    ]);
});

// CRUD ���� (���10)
Route::name('api.')->group(function () {
    Route::apiResource('dishes', \App\Http\Controllers\Api\DishController::class);
});
