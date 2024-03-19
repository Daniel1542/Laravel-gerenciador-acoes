<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MovimentoAtivos;
use App\Exports\MovimentoAtivosExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class MovimentoAtivosController extends Controller
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
        return view('crud.movimentos', compact('dadosAcoes', 'dadosFiis'));
    }

    public function opcoesMove(Request $request){
        $baixar = $request->input('baixar');
        $data_inicio = $request->input('data_inicio');
        $data_fim = $request->input('data_fim');
        $tipo = $request->input('tipo');
        if ( $baixar == 'Excel'){
            return redirect()->route('movimento.exportMovimentoAtivos', [
                'data_ini' => $data_inicio,
                'data_fi' => $data_fim,
                'tip' => $tipo,
            ]);

        }
        else{
            return redirect()->route('movimento.exportMovimentoAtivosPdf', [
                'data_ini' => $data_inicio,
                'data_fi' => $data_fim,
                'tip' => $tipo,
            ]);
        }
    }

    /**
     * excel
     */
    public function exportMovimentoAtivos($data_ini, $data_fi, $tip)
    {
        $data_inicio = $data_ini;
        $data_fim = $data_fi;
        $tipo = $tip;
        $movimentosAcoes = MovimentoAtivos::where('tipo', $tipo)
        ->whereBetween('data', [$data_inicio, $data_fim])
        ->get();

        $dadosAtivos = [];

        $movimentosAcoesAgrupados = $movimentosAcoes->groupBy('nome');

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
                    'corretagem' =>  $corretage > 0 ? 'R$ ' . number_format(($corretage), 2, ',', '.') : 'R$ 0,00',
                    'quantidade' =>  $quantidadeTotal > 0 ? $quantidadeTotal : '0',
                    'valor' => $valo > 0 ?  'R$ ' . number_format(($valo), 2, ',', '.') : 'R$ 0,00',
                    'valorFinal' => $valorFinal > 0 ? 'R$ ' . number_format(($valorFinal), 2, ',', '.') : 'R$ 0,00',
                ];
            }
        }

        if ($tipo == "fundo imobiliario") {
            return Excel::download(new MovimentoAtivosExport($dadosAtivos), 'movimentos fundos.xlsx');
        } else {
            return Excel::download(new MovimentoAtivosExport($dadosAtivos), 'movimentos ações.xlsx');
        }
    }

    /**
     * pdf
     */
    public function exportMovimentoAtivosPdf($data_ini, $data_fi, $tip)
    {
        $data_inicio = $data_ini;
        $data_fim = $data_fi;
        $tipo = $tip;
        $Acoes = MovimentoAtivos::where('tipo', 'acao')
        ->whereBetween('data', [$data_inicio, $data_fim])
        ->get();
        $dadosAcoes = [];
        $Fiis = MovimentoAtivos::where('tipo', 'fundo imobiliario')
        ->whereBetween('data', [$data_inicio, $data_fim])
        ->get();
        $dadosFiis = [];

        foreach ($Acoes as $movimentoacao) {
            $dadosAcoes[] = [
                'id' => $movimentoacao->id,
                'nome' => $movimentoacao->nome,
                'movimento' => $movimentoacao->movimento,
                'quantidade' => $movimentoacao->quantidade,
                'valor' => number_format(floatval($movimentoacao->valor), 2, '.', ''),
                'corretagem' => number_format(floatval($movimentoacao->corretagem), 2, '.', ''),
                'valortotal' => number_format(floatval($movimentoacao->valortotal), 2, '.', ''),
                'data' => Carbon::parse($movimentoacao->data)->format('d/m/Y'),
            ];
        }

        foreach ($Fiis as $movimentofii) {
            $dadosFiis[] = [
                'id' => $movimentofii->id,
                'nome' => $movimentofii->nome,
                'movimento' => $movimentofii->movimento,
                'quantidade' => $movimentofii->quantidade,
                'valor' => number_format(floatval($movimentofii->valor), 2, '.', ''),        
                'corretagem' => number_format(floatval($movimentofii->corretagem), 2, '.', ''),
                'valortotal' => number_format(floatval($movimentofii->valortotal), 2, '.', ''),
                'data' => Carbon::parse($movimentofii->data)->format('d/m/Y'),
            ];
        }

        $pdf = PDF::loadView('PDF.movimentospdf', compact('dadosAcoes', 'dadosFiis'));

        return $pdf->stream('download.pdf');
    }
}
