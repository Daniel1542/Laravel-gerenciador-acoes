<?php

use App\Http\Controllers\Api\ApiAtivoController;
use App\Http\Controllers\Api\ApiFormulaController;
use App\Http\Controllers\Api\ApiLoginController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function(){
    Route::apiResource('api-ativos', ApiAtivoController::class);
    Route::get('/api-index-bazin', [ApiFormulaController::class, 'indexBazin'])->name('api-index-bazin');
    Route::post('/api-bazin-store', [ApiFormulaController::class, 'storeBazin'])->name('api-bazin-store');
    Route::put('/api-bazin-update/{id}', [ApiFormulaController::class, 'updateBazin'])->name('api-bazin-update');
    Route::get('/api-bazin-show/{id}', [ApiFormulaController::class, 'showBazin'])->name('api-bazin-show');

    Route::get('/api-index-graham', [ApiFormulaController::class, 'indexgraham'])->name('api-index-graham');
    Route::post('/api-graham-store', [ApiFormulaController::class, 'storeGraham'])->name('api-graham-store');
    Route::put('/api-graham-update/{id}', [ApiFormulaController::class, 'updateGraham'])->name('api-graham-update');
    Route::get('/api-graham-show/{id}', [ApiFormulaController::class, 'showGraham'])->name('api-graham-show');
});

Route::post('/login', [ApiLoginController::class, 'login'])->name('api-login');