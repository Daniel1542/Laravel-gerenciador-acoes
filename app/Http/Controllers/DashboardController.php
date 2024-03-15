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
    
    public function grafico()
    {
        $acoesCount = MovimentoAtivos::where('tipo', 'acao')->distinct('nome')->count('nome');
        $fiisCount = MovimentoAtivos::where('tipo', 'fundo imobiliario')->distinct('nome')->count('nome');
        $total = $acoesCount + $fiisCount;
       
        $acoesPercent = ($acoesCount / $total) * 100;
        $fiisPercent = ($fiisCount / $total) * 100;
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

}
