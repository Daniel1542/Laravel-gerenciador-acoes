<?php

use App\Http\Controllers\Api\ApiAtivoController;
use App\Http\Controllers\Api\ApiFormulaController;
use App\Http\Controllers\Api\ApiLoginController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function(){
    Route::apiResource('api-ativos', ApiAtivoController::class);
    Route::get('/api-indexBazin', [ApiFormulaController::class, 'indexBazin'])->name('api-indexBazin');
    Route::post('/api-bazin-store', [ApiFormulaController::class, 'storeBazin'])->name('api-bazin-store');

});


Route::post('/login', [ApiLoginController::class, 'login'])->name('api-login');