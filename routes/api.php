<?php

use App\Http\Controllers\Api\ApiAtivoController;
use App\Http\Controllers\Api\ApiFormulaController;
use App\Http\Controllers\Api\ApiLoginController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function(){
    /*ativos*/

    Route::apiResource('api-ativos', ApiAtivoController::class);

    /*formulas bazin*/

    Route::get('/api-bazin-index', [ApiFormulaController::class, 'indexBazin'])->name('api-bazin-index');
    Route::post('/api-bazin-store', [ApiFormulaController::class, 'storeBazin'])->name('api-bazin-store');
    Route::put('/api-bazin-update/{id}', [ApiFormulaController::class, 'updateBazin'])->name('api-bazin-update');
    Route::get('/api-bazin-show/{id}', [ApiFormulaController::class, 'showBazin'])->name('api-bazin-show');
    Route::delete('/api-bazin-destroy/{id}', [ApiFormulaController::class, 'destroyBazin'])->name('api-bazin-destroy');

    /*formulas graham*/

    Route::get('/api-graham-index', [ApiFormulaController::class, 'indexgraham'])->name('api-graham-index');
    Route::post('/api-graham-store', [ApiFormulaController::class, 'storeGraham'])->name('api-graham-store');
    Route::put('/api-graham-update/{id}', [ApiFormulaController::class, 'updateGraham'])->name('api-graham-update');
    Route::get('/api-graham-show/{id}', [ApiFormulaController::class, 'showGraham'])->name('api-graham-show');
    Route::delete('/api-graham-destroy/{id}', [ApiFormulaController::class, 'destroyGraham'])->name('api-graham-destroy');
});

Route::post('/login', [ApiLoginController::class, 'login'])->name('api-login');