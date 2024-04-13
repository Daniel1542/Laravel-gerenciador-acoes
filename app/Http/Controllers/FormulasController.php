<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\MovimentoAtivos;
use App\Models\FormulaBazin;
use App\Models\FormulaGraham;

class FormulasController extends Controller
{
    private function bazinIndex($dado)
    {
        $dados = [];
        foreach ($dado as $formula) {
            $precoTeto = $formula['dpa'] / $formula['dividend_yield'];
            $dados[] = [
                'id' => $formula['id'],
                'nome' => $formula['nome'],
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
                'nome' => $formula['nome'],
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

        $Bazin = FormulaBazin::orderBy('nome')
            ->where('user_id', $user->id)
            ->get();
        $Graham = FormulaGraham::orderBy('nome')
            ->where('user_id', $user->id)
            ->get();

        $dadosBazin = $this->bazinIndex($Bazin->toArray());
        $dadosGraham = $this->grahamIndex($Graham->toArray());

        return view('formula.formulas', compact('dadosBazin', 'dadosGraham'));
    }

    public function createBazin(Request $request)
    {
        $request->validate([
            'nome' => 'string|max:6|regex:/^[A-Z0-9]+$/',
            'dpa' => 'numeric',
            'dividend_yield' => 'numeric',
        ]);

        $user = Auth::user();

        $formula = new FormulaBazin();

        $formula-> user_id = $user->id;
        $formula-> nome = $request->nome;
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

        return view('formula.editarFormula', compact('formula'));
    }
    public function updateBazin(Request $request, string $id)
    {
        $request->validate([
            'nome' => 'string|max:6|regex:/^[A-Z0-9]+$/',
            'dpa' => 'numeric',
            'dividend_yield' => 'numeric',
        ]);

        $user = Auth::user();

        $formula = FormulaBazin::where('user_id', $user->id)
            ->findOrFail($id);

        $formula->user_id = $user->id;
        $formula->nome = $request->nome;
        $formula->dpa = $request->dpa;
        $formula->dividend_yield = $request->dividend_yield;

        $formula->save();

        return redirect()->route('formula.index')->with('msg', 'formula atualizado com sucesso.');
    }

    public function destroyBazin(string $id)
    {
        $user = Auth::user();

        $ativos = FormulaBazin::where('user_id', $user->id)
            ->findOrFail($id);

        $ativos->delete();

        return redirect()->route('movimento.index')->with('msg', 'Ativo na lista excluído com sucesso.');
    }
    public function createGraham(Request $request)
    {
        $request->validate([
            'nome' => 'string|max:6|regex:/^[A-Z0-9]+$/',
            'dpa' => 'numeric',
            'dividend_yield' => 'numeric',
        ]);

        $user = Auth::user();

        $ativos = new FormulaGraham();

        $ativos-> user_id = $user->id;
        $ativos-> nome = $request->nome;
        $ativos-> dpa = $request->dpa;
        $ativos-> dividend_yield = $request->dividend_yield;

        $ativos->save();

        return redirect()->route('formula.index')->with('msg', 'Cadastrado com sucesso.');
    }

    public function editGraham(string $id)
    {
        $user = Auth::user();

        $ativos  = FormulaGraham::where('user_id', $user->id)
            ->findOrFail($id);

        return view('crud.editarAtivo', compact('ativos'));
    }
    public function updateGraham(Request $request, string $id)
    {
        $request->validate([
            'nome' => 'string|max:6|regex:/^[A-Z0-9]+$/',
            'dpa' => 'numeric',
            'dividend_yield' => 'numeric',
        ]);

        $user = Auth::user();

        $movimentos = FormulaGraham::where('user_id', $user->id)
            ->findOrFail($id);

        $dadosAtualizados = $request->only([
            'tipo',
            'movimento',
            'nome',
            'corretagem',
            'quantidade',
            'valor',
        ]);

        $dadosAtualizados['valor_total'] = $request->corretagem + ($request->valor * $request->quantidade);

        $movimentos->update($dadosAtualizados);

        return redirect()->route('movimento.index')->with('msg', 'Movimento atualizado com sucesso.');
    }

    public function destroyGraham(string $id)
    {
        $user = Auth::user();

        $ativos = FormulaGraham::where('user_id', $user->id)
            ->findOrFail($id);

        $ativos->delete();

        return redirect()->route('movimento.index')->with('msg', 'Ativo na lista excluído com sucesso.');
    }
}
