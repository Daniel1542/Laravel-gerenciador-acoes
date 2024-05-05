<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\FormulaBazin;
use App\Models\FormulaGraham;

class FormulasController extends Controller
{
    /*functions que retornam bazin e graham*/

    private function bazinIndex($dado)
    {
        $dados = [];
        foreach ($dado as $formula) {
            $precoTeto = $formula['dpa'] / ($formula['dividend_yield'] / 100);
            $dados[] = [
                'id' => $formula['id'],
                'ticker' => $formula['ticker'],
                'dpa' => $formula['dpa'],
                'dividend_yield' => $formula['dividend_yield'],
                'preco_teto' => $precoTeto,
            ];
        }
        return $dados;
    }
    private function grahamIndex($dado)
    {
        $dados = [];
        foreach ($dado as $formula) {
            $precoJusto = sqrt(22.5 * $formula['lpa'] * $formula['vpa']);
            $dados[] = [
                'id' => $formula['id'],
                'ticker' => $formula['ticker'],
                'lpa' => $formula['lpa'],
                'vpa' => $formula['vpa'],
                'preco_justo' => $precoJusto,
            ];
        }
        return $dados;
    }

    public function index()
    {
        $user = Auth::user();

        $Bazin = FormulaBazin::orderBy('ticker')
            ->where('user_id', $user->id)
            ->get();
        $Graham = FormulaGraham::orderBy('ticker')
            ->where('user_id', $user->id)
            ->get();

        $dadosBazin = $this->bazinIndex($Bazin->toArray());
        $dadosGraham = $this->grahamIndex($Graham->toArray());

        return view('formula.formulas', compact('dadosBazin', 'dadosGraham'));
    }

    public function createBazin(Request $request)
    {
        $request->validate([
            'ticker' => 'string|max:6|regex:/^[A-Z0-9]+$/',
            'dpa' => 'numeric',
            'dividend_yield' => 'numeric',
        ]);

        $user = Auth::user();

        $formula = new FormulaBazin();

        $formula-> user_id = $user->id;
        $formula-> ticker = $request->ticker;
        $formula-> dpa = $request->dpa;
        $formula-> dividend_yield = $request->dividend_yield;

        $formula->save();

        return redirect()->route('formula.index')->with('msg', 'Cadastrado com sucesso.');
    }

    public function editBazin(string $id)
    {
        $user = Auth::user();

        $formula  = FormulaBazin::where('user_id', $user->id)
            ->findOrFail($id);

        return view('formula.editarBazin', compact('formula'));
    }
    public function updateBazin(Request $request, string $id)
    {
        $request->validate([
            'ticker' => 'string|max:6|regex:/^[A-Z0-9]+$/',
            'dpa' => 'numeric',
            'dividend_yield' => 'numeric',
        ]);

        $user = Auth::user();

        $formula = FormulaBazin::where('user_id', $user->id)
            ->findOrFail($id);

        $formula->user_id = $user->id;
        $formula->ticker = $request->ticker;
        $formula->dpa = $request->dpa;
        $formula->dividend_yield = $request->dividend_yield;

        $formula->save();

        return redirect()->route('formula.index')->with('msg', 'formula atualizado com sucesso.');
    }

    public function destroyBazin(string $id)
    {
        $user = Auth::user();

        $formula = FormulaBazin::where('user_id', $user->id)
            ->findOrFail($id);

        $formula->delete();

        return redirect()->route('formula.index')->with('msg', 'formula na lista excluída com sucesso.');
    }
    public function createGraham(Request $request)
    {
        $request->validate([
            'ticker' => 'string|max:6|regex:/^[A-Z0-9]+$/',
            'lpa' => 'numeric',
            'vpa' => 'numeric',
        ]);

        $user = Auth::user();

        $formula = new FormulaGraham();

        $formula-> user_id = $user->id;
        $formula-> ticker = $request->ticker;
        $formula-> lpa = $request->lpa;
        $formula-> vpa = $request->vpa;

        $formula->save();

        return redirect()->route('formula.index')->with('msg', 'Cadastrado com sucesso.');
    }

    public function editGraham(string $id)
    {
        $user = Auth::user();

        $formula  = FormulaGraham::where('user_id', $user->id)
            ->findOrFail($id);

        return view('formula.editarGraham', compact('formula'));
    }
    public function updateGraham(Request $request, string $id)
    {
        $request->validate([
            'ticker' => 'string|max:6|regex:/^[A-Z0-9]+$/',
            'lpa' => 'numeric',
            'vpa' => 'numeric',
        ]);

        $user = Auth::user();

        $formula = FormulaGraham::where('user_id', $user->id)
            ->findOrFail($id);

        $formula-> user_id = $user->id;
        $formula-> ticker = $request->ticker;
        $formula-> lpa = $request->lpa;
        $formula-> vpa = $request->vpa;

        $formula->save();

        return redirect()->route('formula.index')->with('msg', 'formula atualizada com sucesso.');
    }
    public function destroyGraham(string $id)
    {
        $user = Auth::user();

        $ativos = FormulaGraham::where('user_id', $user->id)
            ->findOrFail($id);

        $ativos->delete();

        return redirect()->route('formula.index')->with('msg', 'formula na lista excluída com sucesso.');
    }
}
