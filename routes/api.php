<?php

use App\Http\Controllers\Api\ApiAtivoController;
use App\Http\Controllers\Api\ApiLoginController;
use Illuminate\Support\Facades\Route;

Route::apiResource('api-ativo', ApiAtivoController::class);

Route::middleware('auth:sanctum')->group(function(){
    Route::get('/ativos', [ApiAtivoController::class, 'index']);

});


Route::post('/login', [ApiLoginController::class, 'login'])->name('api-login');
Route::middleware('auth:sanctum')->get('/teste', [ApiLoginController::class, 'teste']);
