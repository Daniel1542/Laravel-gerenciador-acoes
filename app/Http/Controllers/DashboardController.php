<?php

namespace App\Http\Controllers;
use App\Models\MovimentoAtivos;

class DashboardController extends Controller
{
    public function dash()
    {
        $acoesCount = MovimentoAtivos::where('tipo', 'acao')->distinct('nome')->count('nome');
        $fiisCount = MovimentoAtivos::where('tipo', 'fundo imobiliario')->distinct('nome')->count('nome');

        return view('principal.dashboard', compact('acoesCount', 'fiisCount'));
    }
    
    public function graficoPorcentagem()
    {
        $acoesCount = MovimentoAtivos::where('tipo', 'acao')->distinct('nome')->count('nome');
        $fiisCount = MovimentoAtivos::where('tipo', 'fundo imobiliario')->distinct('nome')->count('nome');
        $total = $acoesCount + $fiisCount;
       
        $acoesPercent = ($acoesCount / $total) * 100;
        $fiisPercent = ($fiisCount / $total) * 100;

        $acoesPercent = floatval($acoesPercent);
        $fiisPercent = floatval($fiisPercent);

        $data = [
            'labels' => ['Ações', 'Fundos Imobiliários'],
            'datasets' => [
                [
                    'data' => [$acoesPercent, $fiisPercent],
                    'backgroundColor' => ['#FF6384', '#36A2EB'],
                ]
            ]
        ];
    
        return response()->json($data);   

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

    
    public function graficoTotal()
    {
        $movimentosAcoes = MovimentoAtivos::where('tipo', 'acao')
        ->whereIn('movimento', ['compra', 'venda'])
        ->get();

        $dadosAcoes = [];

        $movimentosAcoesAgrupados = $movimentosAcoes->groupBy('nome');

        foreach ($movimentosAcoesAgrupados as $nome => $movimentos) {
            $compras = $movimentos->where('movimento', 'compra');
            $vendas = $movimentos->where('movimento', 'venda');

            $valorCompra = $compras->sum('valortotal');
            $valorVenda = $vendas->sum('valortotal');

            $valorCompleto =  $valorCompra - $valorVenda;

            $dadosAcoes[] = [
                'nome' => $nome,
                'valorTotal'  =>  $valorCompleto,
            ];
        }

        $labels = [];
        foreach ($dadosAcoes as $acao) {
            $labels[] = $acao['nome'];
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
   
}
