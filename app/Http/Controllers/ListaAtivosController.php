<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MovimentoAtivos;

class ListaAtivosController extends Controller
{
    public function index()
    {
        $movimentosAcoes = MovimentoAtivos::where('tipo', 'acao')->whereIn('movimento', ['compra', 'venda'])->get();
        $dadosAcoes = [];

        $movimentosFiis = MovimentoAtivos::where('tipo', 'fundo imobiliario')->whereIn('movimento', ['compra', 'venda'])->get();
        $dadosfiis = [];

        $movimentosAcoesAgrupados = $movimentosAcoes->groupBy('nome');
        $movimentosFissAgrupados = $movimentosFiis->groupBy('nome');

        foreach ($movimentosAcoesAgrupados as $nome => $movimentos) {
            $compras = $movimentos->where('movimento', 'compra');
            $vendas = $movimentos->where('movimento', 'venda');

            $quantidadeCompra = $compras->sum('quantidade');
            $quantidadeVenda = $vendas->sum('quantidade');

            $valorCompra = $compras->sum('valortotal');
            $valorVenda = $vendas->sum('valortotal');

            $valorCompleto =  $valorCompra - $valorVenda;

            $quantidadeTotal = $quantidadeCompra - $quantidadeVenda;

            $dadosAcoes[] = [
                'nome' => $nome,
                'quantidadeTotal' => $quantidadeTotal,
                'precoMedio'  =>  $valorCompra / $quantidadeCompra,
            ];
        }

        foreach ($movimentosFissAgrupados as $nome => $movimentos) {
            $compras = $movimentos->where('movimento', 'compra');
            $vendas = $movimentos->where('movimento', 'venda');

            $quantidadeCompra = $compras->sum('quantidade');
            $quantidadeVenda = $vendas->sum('quantidade');

            $valorCompra = $compras->sum('valortotal');
            $valorVenda = $vendas->sum('valortotal');

            $valorCompleto =  $valorCompra - $valorVenda;

            $quantidadeTotal = $quantidadeCompra - $quantidadeVenda;

            $dadosfiis[] = [
                'nome' => $nome,
                'quantidadeTotal' => $quantidadeTotal,
                'precoMedio'  =>  $valorCompra / $quantidadeCompra,
            ];
        }
        return view('crud.listaativos', compact('dadosAcoes', 'dadosfiis'));
    }
}
