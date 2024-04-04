<?php

namespace App\Http\Controllers;
use App\Models\MovimentoAtivos;

class DashboardController extends Controller
{

    /*funcoes dos graficos*/

    function funcoesGraficos($dado)
    {
        $dados=[];
        $labels = [];

        foreach ($dado as $nome => $movimentos) {
            $compras = $movimentos->where('movimento', 'compra');
            $vendas = $movimentos->where('movimento', 'venda');

            $valorCompra = $compras->sum('valor_total');
            $valorVenda = $vendas->sum('valor_total');

            $valorCompleto =  $valorCompra - $valorVenda;

            $dados[] = [
                'nome' => $nome,
                'valorTotal'  =>  $valorCompleto,
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
        return $data;
    }

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

    /*graficos*/

    /*acoes*/

    public function graficoAcoes()
    {
        $movimentosAcoes = MovimentoAtivos::where('tipo', 'acao')
        ->whereIn('movimento', ['compra', 'venda'])
        ->get();

        $dadosAtivos = $this->funcoesGraficos($movimentosAcoes->groupBy('nome'));
        
        return response()->json($dadosAtivos);  
    }

    /*fiis*/

    public function graficoFiis()
    {
        $movimentosFiis = MovimentoAtivos::where('tipo', 'fundo imobiliario')
        ->whereIn('movimento', ['compra', 'venda'])
        ->get();

        $dadosAtivos = $this->funcoesGraficos($movimentosFiis->groupBy('nome'));

        return response()->json($dadosAtivos);  
    }

    /*total*/

    public function graficoTotal()
    {
        $movimentos = MovimentoAtivos::whereIn('tipo', ['acao', 'fundo imobiliario'])
            ->whereIn('movimento', ['compra', 'venda'])
            ->get();
    
            $dadosAtivos = $this->funcoesGraficos($movimentos->groupBy('nome'));

            return response()->json($dadosAtivos);  
    }    
   
}
