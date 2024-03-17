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
            'nome' => 'required|string|max:6|regex:/^[a-z0-9]+$/',
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
        $ativos-> valortotal = ($request->corretagem + ($request->valor * $request->quantidade));

        $ativos->save();

        return redirect('/addativos')->with('msg', 'Cadastrado com sucesso.');
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
            'nome' => 'required|string|max:6|regex:/^[a-z0-9]+$/',
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

        $dadosAtualizados['valortotal'] = $request->corretagem + ($request->valor * $request->quantidade);

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
                $nom = $movimento->nome;
                $tip = $movimento->tipo;
                $move = $movimento->movimento;
                $dataTransacao = Carbon::parse($movimento->data)->format('d/m/Y');
                $corretage = $movimento->corretagem;
                $quantidadeTotal = $movimento->quantidade;
                $valo = $movimento->valor;
                $valorFinal = $movimento->valortotal;

                $dadosAtivos[] = [
                    'nome' => $nom,
                    'tipo' => $tip,
                    'movimento' => $move,
                    'data' =>  $dataTransacao,
                    'corretagem' =>  $corretage,
                    'quantidade' =>  $quantidadeTotal,
                    'valor' => $valo,
                    'valorFinal' => $valorFinal,
                ];
            }
        }
        return view('crud.mostrarAtivo', compact('dadosAtivos'));
    }

    public function buscarativos(Request $request)
    {
        $termo = $request->input('termo');

        $ativos = MovimentoAtivos::where('nome', 'like', $termo . '%')->pluck('nome');

        return response()->json($ativos);
    }
}
