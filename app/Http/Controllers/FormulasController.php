<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MovimentoAtivos;
use Carbon\Carbon;

class FormulasController extends Controller
{
    public function index()
    {
        $Acoes = MovimentoAtivos::where('tipo', 'acao')->get();
        $dadosAcoes = [];
        $Fiis = MovimentoAtivos::where('tipo', 'fundo imobiliario')->get();
        $dadosFiis = [];

        foreach ($Acoes as $movimentoacao) {
            $dadosAcoes[] = [
                'id' => $movimentoacao->id,
                'nome' => $movimentoacao->nome,
                'quantidade' => $movimentoacao->quantidade,
                'valor' => $movimentoacao->valor,
                'movimento' => $movimentoacao->movimento,
                'corretagem' => $movimentoacao->corretagem,
                'data' => Carbon::parse($movimentoacao->data)->format('d/m/Y'),
            ];
        }

        foreach ($Fiis as $movimentofii) {
            $dadosFiis[] = [
                'id' => $movimentofii->id,
                'nome' => $movimentofii->nome,
                'quantidade' => $movimentofii->quantidade,
                'valor' => $movimentofii->valor,
                'movimento' => $movimentofii->movimento,
                'corretagem' => $movimentofii->corretagem,
                'data' => Carbon::parse($movimentofii->data)->format('d/m/Y'),
            ];
        }
        return view('formula.formulas', compact('dadosAcoes', 'dadosFiis'));
    }
}
