<?php

namespace App\Http\Controllers;

use App\Models\MovimentoAtivos;

class ListaAtivosController extends Controller
{
    private function mostrarTudo($movimento)
    {

        foreach ($movimento as $nome => $movimentos) {
            $compras = $movimentos->where('movimento', 'compra');
            $vendas = $movimentos->where('movimento', 'venda');

            $quantidadeCompra = $compras->sum('quantidade');
            $quantidadeVenda = $vendas->sum('quantidade');

            $valorCompra = $compras->sum('valor_total');
            $valorVenda = $vendas->sum('valor_total');

            $valorCompleto =  $valorCompra - $valorVenda;

            $quantidadeTotal = $quantidadeCompra - $quantidadeVenda;

            if ($quantidadeCompra != 0) {
                $precoMedio = $valorCompra / $quantidadeCompra;
            } else {
                $precoMedio = 0;
            }

            if ($quantidadeTotal != 0) {
                $porcentagem = $valorCompleto / $quantidadeTotal;
            } else {
                $porcentagem = 0;
            }

            $dados[] = [
                'nome' => $nome,
                'quantidadeTotal' => $quantidadeTotal,
                'precoMedio'  =>  $precoMedio,
                'valorTotal'  =>  $valorCompleto,
                'porcentagem'  =>  $porcentagem,
            ];
        }
        return $dados;
    }

    public function index()
    {
        $movimentosAcoes = MovimentoAtivos::where('tipo', 'acao')
        ->whereIn('movimento', ['compra', 'venda'])
        ->get();
        $dadosAcoes = [];

        $movimentosFiis = MovimentoAtivos::where('tipo', 'fundo imobiliario')
        ->whereIn('movimento', ['compra', 'venda'])
        ->get();
        $dadosfiis = [];

        $dadosAcoes = $this->mostrarTudo($movimentosAcoes->groupBy('nome'));

        $dadosfiis = $this->mostrarTudo($movimentosFiis->groupBy('nome'));

        return view('crud.listaativos', compact('dadosAcoes', 'dadosfiis'));
    }
}
