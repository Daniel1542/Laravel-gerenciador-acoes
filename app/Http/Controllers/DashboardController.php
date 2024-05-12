<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\MovimentoAtivos;

class DashboardController extends Controller
{
    /*funcoes dos graficos*/

    private function funcoesGraficos($dado)
    {
        $dados = [];
        $labels = [];

        foreach ($dado as $nome => $movimentos) {
            $compras = $movimentos->where('movimento', 'compra');
            $vendas = $movimentos->where('movimento', 'venda');

            $valorCompra = $compras->sum('valor_total');
            $valorVenda = $vendas->sum('valor_total');

            if ($valorCompra > $valorVenda) {
                $valorCompleto = $valorCompra - $valorVenda;
                $dados[] = [
                    'nome' => $nome,
                    'valorTotal' => $valorCompleto,
                ];
                $labels[] = $nome;
            }
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

    private function gerarCoresAleatorias($quantidade)
    {
        $cores = [];
        for ($i = 0; $i < $quantidade; $i++) {
            $cores[] = $this->gerarCorAleatoria();
        }
        return $cores;
    }

    private function gerarCorAleatoria()
    {
        return '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
    }

    public function dash()
    {
        $user = Auth::user();

        $total = MovimentoAtivos::where('user_id', $user->id)->count();

        $acoesCount = MovimentoAtivos::where('user_id', $user->id)
            ->where('tipo', 'acao')
            ->distinct('nome')
            ->count('nome');

        $fiisCount = MovimentoAtivos::where('user_id', $user->id)
            ->where('tipo', 'fundo imobiliario')
            ->distinct('nome')
            ->count('nome');

        $total = $acoesCount + $fiisCount;

        if ($total != 0) {
            $acoesPercent = ($acoesCount / $total) * 100;
            $fiisPercent = ($fiisCount / $total) * 100;
        } else {
            $acoesPercent = 0;
            $fiisPercent = 0;
        }

        return view('principal.dashboard', compact('acoesCount', 'fiisCount', 'acoesPercent', 'fiisPercent'));
    }

    /*graficos*/

    /*acoes*/

    public function graficoAcoes()
    {
        $user = Auth::user();

        $movimentosAcoes = MovimentoAtivos::where('user_id', $user->id)
            ->where('tipo', 'acao')
            ->whereIn('movimento', ['compra', 'venda'])
            ->get();

        $dadosAtivos = $this->funcoesGraficos($movimentosAcoes->groupBy('nome'));

        return response()->json($dadosAtivos);
    }

    /*fiis*/

    public function graficoFiis()
    {
        $user = Auth::user();

        $movimentosFiis = MovimentoAtivos::where('user_id', $user->id)
            ->where('tipo', 'fundo imobiliario')
            ->whereIn('movimento', ['compra', 'venda'])
            ->get();

        $dadosAtivos = $this->funcoesGraficos($movimentosFiis->groupBy('nome'));

        return response()->json($dadosAtivos);
    }

    /*total de ativos*/

    public function graficoTotal()
    {
        $user = Auth::user();

        $movimentos = MovimentoAtivos::where('user_id', $user->id)
            ->whereIn('tipo', ['acao', 'fundo imobiliario'])
            ->whereIn('movimento', ['compra', 'venda'])
            ->get();

        $dadosAtivos = $this->funcoesGraficos($movimentos->groupBy('nome'));

        return response()->json($dadosAtivos);
    }
}
