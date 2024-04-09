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
            'tipo' => 'in:fundo imobiliario,acao',
            'movimento' => 'in:compra,venda',
            'nome' => 'string|max:6|regex:/^[A-Z0-9]+$/',
            'data' => 'date|before_or_equal:now',
            'corretagem' => 'numeric|gt:-1',
            'quantidade' => 'numeric|gt:0',
            'valor' => 'numeric|gt:0',
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

        return redirect()->route('movimento.index')->with('msg', 'Cadastrado com sucesso.');
    }

    public function edit(string $id)
    {
        $ativos  = MovimentoAtivos::findOrFail($id);

        return view('crud.editarAtivo', compact('ativos'));
    }
    public function update(Request $request, string $id)
    {
        $request->validate([
            'tipo' => 'in:fundo imobiliario,acao',
            'movimento' => 'in:compra,venda',
            'nome' => 'string|max:6|regex:/^[A-Z0-9]+$/',
            'data' => 'date|before_or_equal:now',
            'corretagem' => 'numeric|gt:-1',
            'quantidade' => 'numeric|gt:0',
            'valor' => 'numeric|gt:0',
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
        $ativos = MovimentoAtivos::where('nome', $nome)->get();

        $dadosAtivos = [];

        $movimentosAcoesAgrupados = $ativos->groupBy('nome');

        foreach ($ativos as $ativo) {
            $dadosAtivos[] = [
                'nome' => $ativo->nome,
                'tipo' => $ativo->tipo,
                'movimento' => $ativo->movimento,
                'data' => Carbon::parse($ativo->data)->format('d/m/Y'),
                'corretagem' => $ativo->corretagem,
                'quantidade' => $ativo->quantidade,
                'valor' => $ativo->valor,
                'valorFinal' => $ativo->valor_total,
            ];
        }
        return view('crud.mostrarAtivo', compact('dadosAtivos'));
    }

    /*js para sugestão de busca*/

    public function buscarAtivos(Request $request)
    {
        $termo = $request->input('termo');

        $ativos = MovimentoAtivos::where('nome', 'like', $termo . '%')->pluck('nome');

        return response()->json($ativos);
    }
}
