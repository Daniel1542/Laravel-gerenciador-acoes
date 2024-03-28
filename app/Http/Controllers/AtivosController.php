<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MovimentoAtivos;
use Carbon\Carbon;

class AtivosController extends Controller
{
    public function create()
    {
        return view('crud.addAtivo');
    }
    public function store(Request $request)
    {
        $request->validate([
            'tipo' => 'required|in:fundo imobiliario,acao',
            'movimento' => 'required|in:compra,venda',
            'nome' => 'required|string|max:6|regex:/^[A-Z0-9]+$/',
            'data' => 'required|date|before_or_equal:now',
            'corretagem' => 'required|numeric|gt:-1',
            'quantidade' => 'required|numeric|gt:0',
            'valor' => 'required|numeric|gt:0',
        ]);

        $ativos = new MovimentoAtivos();

        $ativos-> tipo = $request->tipo;
        $ativos-> movimento = $request->movimento;
        $ativos-> nome = $request->nome;
        $ativos-> quantidade = $request->quantidade;
        $ativos-> corretagem = $request->corretagem;
        $ativos-> valor = $request->valor;
        $ativos-> data = $request->data;
        $ativos-> valor_total = ($request->corretagem + ($request->valor * $request->quantidade));

        $ativos->save();
        
        return redirect()->route('principal.dashboard')->with('msg', 'Cadastrado com sucesso.');
    }

    public function edit(string $id)
    {
        $ativos  = MovimentoAtivos::findOrFail($id);

        return view('crud.editarAtivo', compact('ativos'));
    }
    public function update(Request $request, string $id)
    {
        $request->validate([
            'tipo' => 'required|in:fundo imobiliario,acao',
            'movimento' => 'required|in:compra,venda',
            'nome' => 'required|string|max:6|regex:/^[A-Z0-9]+$/',
            'data' => 'required|date|before_or_equal:now',
            'corretagem' => 'required|numeric|gt:-1',
            'quantidade' => 'required|numeric|gt:0',
            'valor' => 'required|numeric|gt:0',
        ]);

        $movimentos = MovimentoAtivos::findOrFail($id);

        $dadosAtualizados = $request->only([
            'tipo',
            'movimento',
            'nome',
            'data',
            'corretagem',
            'quantidade',
            'valor',
        ]);

        $dadosAtualizados['valor_total'] = $request->corretagem + ($request->valor * $request->quantidade);

        $movimentos->update($dadosAtualizados);

        return redirect()->route('movimento.index')->with('msg', 'Movimento atualizado com sucesso.');
    }

    public function destroy(string $id)
    {
        $ativos = MovimentoAtivos::findOrFail($id);

        $ativos->delete();

        return redirect()->route('movimento.index')->with('msg', 'Ativo na lista excluído com sucesso.');
    }
    public function show(Request $request)
    {
        $nome = $request->input('Nome');
        $ativo = MovimentoAtivos::where('nome', $nome)->get();

        $dadosAtivos = [];

        $movimentosAcoesAgrupados = $ativo->groupBy('nome');

        foreach ($movimentosAcoesAgrupados as $nome => $movimentos) {
            foreach ($movimentos as $movimento) {
                $nome = $movimento->nome;
                $tipo = $movimento->tipo;
                $movimento = $movimento->movimento;
                $dataTransacao = Carbon::parse($movimento->data)->format('d/m/Y');
                $corretagem = $movimento->corretagem;
                $quantidadeTotal = $movimento->quantidade;
                $valor = $movimento->valor;
                $valorFinal = $movimento->valor_total;

                $dadosAtivos[] = [
                    'nome' => $nome,
                    'tipo' => $tipo,
                    'movimento' => $movimento,
                    'data' =>  $dataTransacao,
                    'corretagem' =>  $corretagem,
                    'quantidade' =>  $quantidadeTotal,
                    'valor' => $valor,
                    'valorFinal' => $valorFinal,
                ];
            }
        }
        return view('crud.mostrarAtivo', compact('dadosAtivos'));
    }

    /*js para sugestão de busca*/

    function buscarAtivos(Request $request)
    {
        $termo = $request->input('termo');

        $ativos = MovimentoAtivos::where('nome', 'like', $termo . '%')->pluck('nome');

        return response()->json($ativos);
    }
}
