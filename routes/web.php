<?php

use Illuminate\Support\Facades\Route;
use App\Mail\Manda;
use Illuminate\Support\Facades\Mail;
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

Route::get('/dashboard', [DashboardController::class, 'dash'])
->name('principal.dashboard')->middleware('auth');

Route::get('/graficoAcoes', [DashboardController::class, 'graficoAcoes'])
->name('principal.graficoAcoes')->middleware('auth');

Route::get('/graficoFiis', [DashboardController::class, 'graficoFiis'])
->name('principal.graficoFiis')->middleware('auth');

Route::get('/graficoTotal', [DashboardController::class, 'graficoTotal'])
->name('principal.graficoTotal')->middleware('auth');

/*opcoes*/

Route::get('/opcoes', [ImpostoRendaController::class, 'opcoes'])
->name('imposto.opcoes')->middleware('auth');

Route::get('/opcoes-move', [MovimentoAtivosController::class, 'opcoesmove'])
->name('movimento.opcoesmove')->middleware('auth');

/*ativos*/

Route::get('/ativos/show', [AtivosController::class, 'show'])
->name('ativos.show')->middleware('auth');

Route::get('/ativos/{id}/edit', [AtivosController::class, 'edit'])
->name('ativos.edit')->middleware('auth');

Route::delete('/ativos/{id}', [AtivosController::class, 'destroy'])
->name('ativos.destroy')->middleware('auth');

/*busca ativos*/

Route::get('/buscar-ativos', [AtivosController::class, 'buscarAtivos'])
->name('ativos.buscarAtivos')->middleware('auth');

/*formulas bazin*/

Route::post('/criar-bazin', [FormulasController::class, 'storeBazin'])
->name('formula.storeBazin')->middleware('auth');

Route::get('/bazin/{id}/edit', [FormulasController::class, 'editBazin'])
->name('formula.editBazin')->middleware('auth');

Route::delete('/bazin/{id}/delete', [FormulasController::class, 'destroyBazin'])
->name('formula.destroyBazin')->middleware('auth');

Route::put('/bazin/{id}', [FormulasController::class, 'updateBazin'])
->name('formula.updateBazin')->middleware('auth');

/*formulas graham*/

Route::post('/criar-graham', [FormulasController::class, 'storeGraham'])
->name('formula.storeGraham')->middleware('auth');

Route::get('/graham/{id}/edit', [FormulasController::class, 'editGraham'])
->name('formula.editGraham')->middleware('auth');

Route::delete('/graham/{id}/delete', [FormulasController::class, 'destroyGraham'])
->name('formula.destroyGraham')->middleware('auth');

Route::put('/graham/{id}', [FormulasController::class, 'updateGraham'])
->name('formula.updateGraham')->middleware('auth');

/*Excel formula*/

Route::get('/excel-planilha', [FormulasController::class, 'opcoesFormula'])
->name('formula.opcoesFormula')->middleware('auth');

/*PDF*/

Route::get('/export-Movimento-Pdf/{data_ini}/{data_fi}', [MovimentoAtivosController::class, 'exportMovimentoPdf'])
->name('movimento.exportMovimentoPdf')->middleware('auth');

Route::get('/export-Ir-Pdf/{data_ini}', [ImpostoRendaController::class, 'exportIrPdf'])
->name('imposto.exportIrPdf')->middleware('auth');

/*Excel movimentos*/

Route::get('/export-Excel/{data_ini}/{data_fi}/{tip}', [MovimentoAtivosController::class, 'exportMovimentoExcel'])
->name('movimento.exportMovimentoExcel')->middleware('auth');

/*Excel imposto*/

Route::get('/export-Ativos-Excel/{data_ini}/{tip}', [ImpostoRendaController::class, 'exportAtivosExcel'])
->name('imposto.exportAtivosExcel')->middleware('auth');

/*email*/

Route::get('/email', function () {
    Mail::to('admim@gmail.com')->send(new Manda());
    return view('welcome');
});

/*User*/

Route::get('/cadastro', [UserController::class, 'create'])->name('user.create');
Route::post('/auth', [LoginController::class, 'auth'])->name('auth');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');
Route::get('/', [UserController::class, 'index'])->name('user.index');
