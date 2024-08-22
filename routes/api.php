<?php

use App\Http\Controllers\TasksController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/sanctum/token', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    $user = \App\Models\User::where('email', $request->email)->first();

    if (!$user || !\Illuminate\Support\Facades\Hash::check($request->password, $user->password)) {
        throw \Illuminate\Validation\ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.']
        ]);
    }

    $token = $user->createToken('todo_app_token')->plainTextToken;

    return response()->json([
        'token' => $token,
        'user' => $user
    ]);

});


Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/todos', [TasksController::class, 'index']);
    Route::post('/todos', [TasksController::class, 'store']);
    Route::delete('/todos/{id}', [TasksController::class, 'delete']);
});


