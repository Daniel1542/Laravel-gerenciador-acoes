<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AtivosController;
use App\Http\Controllers\ListaAtivosController;
use App\Http\Controllers\ImpostoRendaController;
use App\Http\Controllers\MovimentoAtivosController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FormulasController;

Route::resource('ativos', AtivosController::class)->middleware('auth');
Route::resource('user', UserController::class);
Route::resource('lista', ListaAtivosController::class)->middleware('auth');
Route::resource('movimento', MovimentoAtivosController::class)->middleware('auth');
Route::resource('imposto', ImpostoRendaController::class)->middleware('auth');
Route::resource('formula', FormulasController::class)->middleware('auth');

/*dashboard*/

Route::get('/dashboard', [DashboardController::class, 'dash'])->name('principal.dashboard')->middleware('auth');
Route::get('/graficoAcoes', [DashboardController::class, 'graficoAcoes'])->name('principal.graficoAcoes')->middleware('auth');
Route::get('/graficoFiis', [DashboardController::class, 'graficoFiis'])->name('principal.graficoFiis')->middleware('auth');
Route::get('/graficoTotal', [DashboardController::class, 'graficoTotal'])->name('principal.graficoTotal')->middleware('auth');

/*opcoes*/

Route::get('/opcoes', [ImpostoRendaController::class, 'opcoes'])->name('imposto.opcoes')->middleware('auth');
Route::get('/opcoes-move', [MovimentoAtivosController::class, 'opcoesmove'])->name('movimento.opcoesmove')->middleware('auth');

/*ativos*/

Route::get('/ativos/show', [AtivosController::class, 'show'])->name('ativos.show')->middleware('auth');
Route::get('/ativos/{id}/edit', [AtivosController::class, 'edit'])->name('ativos.edit')->middleware('auth');
Route::delete('/ativos/{id}', [AtivosController::class, 'destroy'])->name('ativos.destroy')->middleware('auth');

/*busca ativos*/

Route::get('/buscar-ativos', [AtivosController::class, 'buscarAtivos'])->name('ativos.buscarAtivos')->middleware('auth');

/*formulas*/

Route::post('/criar-Bazin', [FormulasController::class, 'createBazin'])->name('formula.createBazin')->middleware('auth');
Route::get('/bazin/{id}/edit', [FormulasController::class, 'editBazin'])->name('formula.editBazin')->middleware('auth');
Route::delete('/bazin/{id}/delete', [FormulasController::class, 'destroyBazin'])->name('formula.destroyBazin')->middleware('auth');
Route::put('/formula/{id}', [FormulasController::class, 'updateBazin'])->name('formula.updateBazin')->middleware('auth');

Route::post('/criar-Graham', [FormulasController::class, 'createGraham'])->name('formula.createGraham')->middleware('auth');
Route::get('/Graham/{id}/edit', [FormulasController::class, 'editGraham'])->name('formula.editGraham')->middleware('auth');
Route::delete('/Graham/{id}/delete', [FormulasController::class, 'destroyGraham'])->name('formula.destroyGraham')->middleware('auth');
Route::put('/formula/{id}', [FormulasController::class, 'updateGraham'])->name('formula.updateGraham')->middleware('auth');

/*PDF*/

Route::get('/export-Movimento-Pdf/{data_ini}/{data_fi}/{tip}', [MovimentoAtivosController::class, 'exportMovimentoPdf'])->name('movimento.exportMovimentoPdf')->middleware('auth');
Route::get('/export-Ir-Pdf/{data_ini}/{tip}', [ImpostoRendaController::class, 'exportIrPdf'])->name('imposto.exportIrPdf')->middleware('auth');

/*Excel*/

Route::get('/export-Excel/{data_ini}/{data_fi}/{tip}', [MovimentoAtivosController::class, 'exportMovimentoExcel'])->name('movimento.exportMovimentoExcel')->middleware('auth');
Route::get('/export-Ativos-Excel/{data_ini}/{tip}', [ImpostoRendaController::class, 'exportAtivosExcel'])->name('imposto.exportAtivosExcel')->middleware('auth');

/*User*/

Route::get('/cadastro', [UserController::class, 'create'])->name('user.create');
Route::post('/auth', [LoginController::class, 'auth'])->name('auth');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');
Route::get('/', [UserController::class, 'index'])->name('user.index');
