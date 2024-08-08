<?php

use App\Http\Controllers\TasksController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


//Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/todos', [TasksController::class, 'index']);
    Route::post('/todos', [TasksController::class, 'store']);
    Route::delete('/todos/{id}', [TasksController::class, 'delete']);
//});


