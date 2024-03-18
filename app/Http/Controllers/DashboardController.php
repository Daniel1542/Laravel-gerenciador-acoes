<?php

namespace App\Http\Controllers;
use App\Models\MovimentoAtivos;

class DashboardController extends Controller
{
    public function dash()
    {
        $acoesCount = MovimentoAtivos::where('tipo', 'acao')->distinct('nome')->count('nome');
        $fiisCount = MovimentoAtivos::where('tipo', 'fundo imobiliario')->distinct('nome')->count('nome');
        $total = $acoesCount + $fiisCount;
       
        $acoesPercent = ($acoesCount / $total) * 100;
        $fiisPercent = ($fiisCount / $total) * 100;

        return view('principal.dashboard', compact('acoesCount', 'fiisCount','acoesPercent','fiisPercent'));
    }

    function gerarCoresAleatorias($quantidade)
    {
        $cores = [];
        for ($i = 0; $i < $quantidade; $i++) {
            $cores[] = $this->gerarCorAleatoria();
        }
        return $cores;
    }

    function gerarCorAleatoria()
    {
        return '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
    }

    /*acoes*/

    public function graficoAcoes()
    {
        $movimentosAcoes = MovimentoAtivos::where('tipo', 'acao')
        ->whereIn('movimento', ['compra', 'venda'])
        ->get();

        $movimentoAcao = $movimentosAcoes->groupBy('nome');

        foreach ($movimentoAcao as $nome => $movimentos) {
            $compras = $movimentos->where('movimento', 'compra');
            $vendas = $movimentos->where('movimento', 'venda');

            $valorCompra = $compras->sum('valortotal');
            $valorVenda = $vendas->sum('valortotal');

            $valorCompleto =  $valorCompra - $valorVenda;

            $dadosAcoes[] = [
                'nome' => $nome,
                'valorTotal'  =>  $valorCompleto,
            ];
            $labels[] = $nome;
        }

        $data = [
            'labels' => $labels,
            'datasets' => [
                [
                    'data' => array_column($dadosAcoes, 'valorTotal'),
                    'backgroundColor' => $this->gerarCoresAleatorias(50), 
                ]
            ]
        ];
        
        return response()->json($data);  
    }

    /*fiis*/

    public function graficoFiis()
    {
        $movimentosFiis = MovimentoAtivos::where('tipo', 'fundo imobiliario')
        ->whereIn('movimento', ['compra', 'venda'])
        ->get();

        $movimentosFiisAgrupados = $movimentosFiis->groupBy('nome');

        foreach ($movimentosFiisAgrupados as $nome => $movimentos) {
            $compras = $movimentos->where('movimento', 'compra');
            $vendas = $movimentos->where('movimento', 'venda');

            $valorCompra = $compras->sum('valortotal');
            $valorVenda = $vendas->sum('valortotal');

            $valorCompleto =  $valorCompra - $valorVenda;

            $dadosFiis[] = [
                'nome' => $nome,
                'valorTotal'  =>  $valorCompleto,
            ];
            $labels[] = $nome;
        }
        $data = [
            'labels' => $labels,
            'datasets' => [
                [
                    'data' => array_column($dadosFiis, 'valorTotal'),
                    'backgroundColor' => $this->gerarCoresAleatorias(50), 
                ]
            ]
        ];

        return response()->json($data);  
    }

    /*total*/

    public function graficoTotal()
    {
        $movimentosAcoes = MovimentoAtivos::whereIn('tipo', ['acao', 'fundo imobiliario'])
            ->whereIn('movimento', ['compra', 'venda'])
            ->get();
    
        $movimentosAgrupados = $movimentosAcoes->groupBy('nome');
    
        $dados = [];
    
        foreach ($movimentosAgrupados as $nome => $movimentos) {
            $compras = $movimentos->where('movimento', 'compra');
            $vendas = $movimentos->where('movimento', 'venda');
    
            $valorCompra = $compras->sum('valortotal');
            $valorVenda = $vendas->sum('valortotal');
    
            $valorTotal = $valorCompra - $valorVenda;
    
            $dados[] = [
                'nome' => $nome,
                'valorTotal' => $valorTotal,
            ];
            $labels[] = $nome;
        }
        $data = [
            'labels' => $labels,
            'datasets' => [
                [
                    'data' => array_column($dados, 'valorTotal'),
                    'backgroundColor' => $this->gerarCoresAleatorias(50), 
                ]
            ]
        ];
    
        return response()->json($data);
    }    
   
}
