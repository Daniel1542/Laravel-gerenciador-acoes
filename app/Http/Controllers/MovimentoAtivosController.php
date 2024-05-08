<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\MovimentoAtivos;
use App\Exports\MovimentoAtivosExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class MovimentoAtivosController extends Controller
{
     /**
     * função para index e pdf
     */
    private function pegarMovimentos($movimentos)
    {
        $dados = [];

        foreach ($movimentos as $movimento) {
            $dados[] = [
                'id' => $movimento->id,
                'nome' => $movimento->nome,
                'movimento' => $movimento->movimento,
                'quantidade' => $movimento->quantidade,
                'valor' => number_format(floatval($movimento->valor), 2, '.', ''),
                'corretagem' => number_format(floatval($movimento->corretagem), 2, '.', ''),
                'valor_total' => number_format(floatval($movimento->valor_total), 2, '.', ''),
                'data' => Carbon::parse($movimento->data)->format('d/m/Y'),
            ];
        }

        return $dados;

    }

    public function index()
    {
        $user = Auth::user();

        $Acoes = MovimentoAtivos::where('tipo', 'acao')
            ->orderBy('data')
            ->where('user_id', $user->id)
            ->get();
        $Fiis = MovimentoAtivos::where('tipo', 'fundo imobiliario')
            ->orderBy('data')
            ->where('user_id', $user->id)
            ->get();

        $dadosAcoes = $this->pegarMovimentos($Acoes);
        $dadosFiis = $this->pegarMovimentos($Fiis);

        return view('crud.movimentos', compact('dadosAcoes', 'dadosFiis'));
    }
     /**
     * Opções de escolha entre excel e pdf
     */

    public function opcoesMove(Request $request)
    {
        $baixar = $request->input('baixar');
        $data_inicio = $request->input('data_inicio');
        $data_fim = $request->input('data_fim');
        $tipo = $request->input('tipo');
        if ($baixar == 'Excel') {
            return redirect()->route('movimento.exportMovimentoExcel', [
                'data_ini' => $data_inicio,
                'data_fi' => $data_fim,
                'tip' => $tipo,
            ]);
        } else {
            return redirect()->route('movimento.exportMovimentoPdf', [
                'data_ini' => $data_inicio,
                'data_fi' => $data_fim,            
            ]);
        }
    }

    /**
     * gerar excel
     */
    public function exportMovimentoExcel($data_ini, $data_fi, $tip)
    {
        $data_inicio = $data_ini;
        $data_fim = $data_fi;
        $tipo = $tip;

        $user = Auth::user();

        $movimentosAcoes = MovimentoAtivos::where('tipo', $tipo)
            ->whereBetween('data', [$data_inicio, $data_fim])
            ->orderBy('data')
            ->where('user_id', $user->id)
            ->get();

        $dadosAtivos = [];

        foreach ($movimentosAcoes as $movimento) {
            $nome = $movimento->nome;
            $tipo = $movimento->tipo;
            $move = $movimento->movimento;
            $dataTransacao = Carbon::parse($movimento->data)->format('d/m/Y');
            $corretagem = $movimento->corretagem;
            $quantidadeTotal = $movimento->quantidade;
            $valor = $movimento->valor;
            $valorFinal = $movimento->valor_total;

            $dadosAtivos[] = [
                'nome' => $nome,
                'tipo' => $tipo,
                'movimento' => $move,
                'data' =>  $dataTransacao,
                'corretagem' =>  $corretagem > 0 ? 'R$ ' . number_format(($corretagem), 2, ',', '.') : 'R$ 0,00',
                'quantidade' =>  $quantidadeTotal > 0 ? $quantidadeTotal : '0',
                'valor' => $valor > 0 ?  'R$ ' . number_format(($valor), 2, ',', '.') : 'R$ 0,00',
                'valorFinal' => $valorFinal > 0 ? 'R$ ' . number_format(($valorFinal), 2, ',', '.') : 'R$ 0,00',
            ];
        }

        if ($tipo == "fundo imobiliario") {
            return Excel::download(new MovimentoAtivosExport($dadosAtivos), 'movimentos fundos.xlsx');
        } else {
            return Excel::download(new MovimentoAtivosExport($dadosAtivos), 'movimentos ações.xlsx');
        }
    }

    /**
    * gerar pdf
    */
    
    public function exportMovimentoPdf($data_ini, $data_fi)
    {
        $user = Auth::user();

        $data_inicio = $data_ini;
        $data_fim = $data_fi;

        $Acoes = MovimentoAtivos::where('tipo', 'acao')
            ->whereBetween('data', [$data_inicio, $data_fim])
            ->orderBy('data')
            ->where('user_id', $user->id)
            ->get();
        $dadosAcoes = [];

        $Fiis = MovimentoAtivos::where('tipo', 'fundo imobiliario')
            ->whereBetween('data', [$data_inicio, $data_fim])
            ->orderBy('data')
            ->where('user_id', $user->id)
            ->get();
        $dadosFiis = [];

        $dadosAcoes = $this->pegarMovimentos($Acoes);
        $dadosFiis = $this->pegarMovimentos($Fiis);

        $pdf = PDF::loadView('PDF.movimentosPdf', compact('dadosAcoes', 'dadosFiis'));

        return $pdf->stream('download.pdf');
    }
}