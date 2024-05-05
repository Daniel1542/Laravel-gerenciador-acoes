<?php

use App\Http\Controllers\Api\AtivoController;
use App\Http\Controllers\Api\LoginController;
use Illuminate\Support\Facades\Route;

Route::apiResource('MovimentoAtivos', AtivoController::class);

Route::post('/login', [LoginController::class, 'login']);
