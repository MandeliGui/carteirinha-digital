<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PetsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', function (Request $request) {
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $user = $request->user();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type'   => 'Bearer',
        ]);
    }

    return response()->json([
        'message' => 'Unauthorized'
    ], 401
    );

});
Route::post('/register', [AuthController::class, 'register']);

Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::prefix('pets')->group(function () {
        Route::get('/', [PetsController::class, 'findAll']);
        Route::post('/novo', [PetsController::class, 'create']);
        Route::put('/editar/{id}', [PetsController::class, 'update']);
        Route::post('/alterar-foto/{id}', [PetsController::class, 'alterarFoto']);
        Route::delete('/remover-foto/{id}', [PetsController::class, 'removerFoto']);
    });
});
