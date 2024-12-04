<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StatisController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Static Pages Routes
Route::get('/pages', [StatisController::class, 'index']);
Route::get('/pages/{slug}', [StatisController::class, 'show']);
Route::post('/pages', [StatisController::class, 'store']);
Route::put('/pages/{id}', [StatisController::class, 'update']);
Route::delete('/pages/{id}', [StatisController::class, 'destroy']);
