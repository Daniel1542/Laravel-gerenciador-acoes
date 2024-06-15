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
                $dpa = $formula['lpa'] * $formula['payout'] / 100;

                $dados[] = [
                    'id' => $formula['id'],
                    'user_id' => $formula['user_id'],
                    'ticker' => $formula['ticker'],
                    'lpa' => $formula['lpa'],
                    'dpa' => $dpa,
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
    public function storeBazin(Request $request)
    {
        $request->validate([
            'ticker' => 'string|max:6|regex:/^[A-Z0-9]+$/',
            'lpa' => 'numeric',
            'payout' => 'numeric',
            'yield_projetado' => 'numeric',
        ]);
        try {
            $user = $request->user();
            $formulaBazin = new FormulaBazin();

            $formulaBazin->user_id = $user->id;
            $formulaBazin->ticker = $request->ticker;
            $formulaBazin->lpa = $request->lpa;
            $formulaBazin->payout = $request->payout;
            $formulaBazin->yield_projetado = $request->yield_projetado;
            $formulaBazin->save();

            return response()->json(['message' => 'Cadastrada com sucesso'], 201);
        } catch (\Exception $e) {
            return response()->json(['Erro ao criar formula' => $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateBazin(Request $request, string $id)
    {
        $request->validate([
            'ticker' => 'string|max:6|regex:/^[A-Z0-9]+$/',
            'lpa' => 'numeric',
            'payout' => 'numeric',
            'yield_projetado' => 'numeric',
        ]);
        try {
            $user = $request->user();
            $formula = FormulaBazin::where('user_id', $user->id)
                        ->findOrFail($id);

            $formula->user_id = $user->id;
            $formula->ticker = $request->ticker;
            $formula->lpa = $request->lpa;
            $formula->payout = $request->payout;
            $formula->yield_projetado = $request->yield_projetado;
            $formula->save();

            return response()->json('Formula atualizada com sucesso', 200);
        } catch (\Exception $e) {
            return response()->json(['Erro ao atualizar formula' => $e->getMessage()], 500);
        }
    }
    /**
     * Display the specified resource.
     */
    public function showBazin(Request $request, string $id)
    {
        try {
            $user = $request->user();
            $formula = FormulaBazin::where('user_id', $user->id)->findOrFail($id);

            return response()->json($formula);
        } catch (\Exception $e) {
            return response()->json(['Formula não encontrada' => $e->getMessage()], 500);
        }
    }
    public function destroyBazin(Request $request, string $id)
    {
        try {
            $user = $request->user();
            $formula = FormulaBazin::where('user_id', $user->id)
                ->findOrFail($id);

            $formula->delete();
            return response()->json(['message' => 'Deletada com sucesso'], 200);
        } catch (\Exception $e) {
            return response()->json(['Formula não encontrada' => $e->getMessage()], 500);
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function indexGraham(Request $request)
    {
        try {
            $user = $request->user();
            $graham = FormulaGraham::orderBy('ticker')
                    ->where('user_id', $user->id)
                    ->get();

            foreach ($graham as $formula) {
                $precoJusto = sqrt(22.5 * $formula['lpa'] * $formula['vpa']);

                $dados[] = [
                    'id' => $formula['id'],
                    'user_id' => $formula['user_id'],
                    'ticker' => $formula['ticker'],
                    'lpa' => $formula['lpa'],
                    'vpa' => $formula['vpa'],
                    'preco_justo' => $precoJusto,
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
    public function storeGraham(Request $request)
    {
        $request->validate([
            'ticker' => 'string|max:6|regex:/^[A-Z0-9]+$/',
            'lpa' => 'numeric',
            'vpa' => 'numeric',
        ]);
        try {
            $user = $request->user();
            $formulaGraham = new FormulaGraham();

            $formulaGraham->user_id = $user->id;
            $formulaGraham->ticker = $request->ticker;
            $formulaGraham->lpa = $request->lpa;
            $formulaGraham->vpa = $request->vpa;
            $formulaGraham->save();

            return response()->json(['message' => 'Cadastrada com sucesso'], 201);
        } catch (\Exception $e) {
            return response()->json(['Erro ao criar formula' => $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateGraham(Request $request, string $id)
    {
        $request->validate([
            'ticker' => 'string|max:6|regex:/^[A-Z0-9]+$/',
            'lpa' => 'numeric',
            'vpa' => 'numeric',
        ]);
        try {
            $user = $request->user();
            $FormulaGraham = FormulaGraham::where('user_id', $user->id)
                        ->findOrFail($id);

            $FormulaGraham->user_id = $user->id;
            $FormulaGraham->ticker = $request->ticker;
            $FormulaGraham->lpa = $request->lpa;
            $FormulaGraham->vpa = $request->vpa;
            $FormulaGraham->save();

            return response()->json('Formula atualizada com sucesso', 200);
        } catch (\Exception $e) {
            return response()->json(['Erro ao atualizar formula' => $e->getMessage()], 500);
        }
    }
    /**
     * Display the specified resource.
     */
    public function showGraham(Request $request, string $id)
    {
        try {
            $user = $request->user();
            $ativo = FormulaGraham::where('user_id', $user->id)->findOrFail($id);

            return response()->json($ativo);
        } catch (\Exception $e) {
            return response()->json(['Formula não encontrada' => $e->getMessage()], 500);
        }
    }
    public function destroyGraham(Request $request, string $id)
    {
        try {
            $user = $request->user();
            $formula = FormulaGraham::where('user_id', $user->id)
                ->findOrFail($id);

            $formula->delete();

            return response()->json(['message' => 'Deletada com sucesso'], 200);
        } catch (\Exception $e) {
            return response()->json(['Formula não encontrada' => $e->getMessage()], 500);
        }
    }
}
