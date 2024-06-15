<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FormulaBazin;
use App\Models\FormulaGraham;

class ApiFormulaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function indexBazin(Request $request)
    {
        try {
            $user = $request->user();
            $bazin = FormulaBazin::orderBy('ticker')
                    ->where('user_id', $user->id)
                    ->get();
            
            foreach ($bazin as $formula) {
                $precoTeto = $formula['lpa'] * $formula['payout'] / ($formula['yield_projetado'] / 100);
                $dividendoAcao = $formula['lpa'] * $formula['payout'] / 100;
    
                $dados[] = [
                    'id' => $formula['id'],
                    'user_id' => $formula['user_id'],
                    'ticker' => $formula['ticker'],
                    'lpa' => $formula['lpa'],
                    'dpa' => $dividendoAcao,
                    'payout' => $formula['payout'],
                    'yield_projetado' => $formula['yield_projetado'],
                    'preco_teto' => $precoTeto,
                ];
            }
            return response()->json($dados);
            
        } catch (\Exception $e) {
            return response()->json(['Erro ao mostrar formulas' => $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function createBazin(Request $request)
    {
        $request->validate([
            'ticker' => 'string|max:6|regex:/^[A-Z0-9]+$/',
            'lpa' => 'numeric',
            'payout' => 'numeric',
            'yield_projetado' => 'numeric',
        ]);
        try {
            $user = $request->user();
            $FormulaBazin = new FormulaBazin();

            $FormulaBazin->user_id = $user->id;
            $FormulaBazin->ticker = $request->ticker;
            $FormulaBazin->lpa = $request->lpa;
            $FormulaBazin->payout = $request->payout;
            $FormulaBazin->yield_projetado = $request->yield_projetado;
            $FormulaBazin->save();

            return response()->json(['message' => 'Cadastrado com sucesso'], 201);
        } catch (\Exception $e) {
            return response()->json(['Erro ao criar formula' => $e->getMessage()], 500);
        }   
    }
}
