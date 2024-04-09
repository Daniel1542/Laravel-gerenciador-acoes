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
    private function MovimentosIndex($ativos)
    {
        $dados = [];
        foreach ($ativos as $movimentoAtivo) {
            $dados[] = [
                'id' => $movimentoAtivo['id'],
                'nome' => $movimentoAtivo['nome'],
                'quantidade' => $movimentoAtivo['quantidade'],
                'valor' => $movimentoAtivo['valor'],
                'movimento' => $movimentoAtivo['movimento'],
                'corretagem' => $movimentoAtivo['corretagem'],
                'data' => Carbon::parse($movimentoAtivo['data'])->format('d/m/Y'),
            ];
        }
        return $dados;
    }

    public function index()
    {
        $Acoes = MovimentoAtivos::where('tipo', 'acao')
        ->orderBy('data')
        ->get();
        $Fiis = MovimentoAtivos::where('tipo', 'fundo imobiliario')
        ->orderBy('data')
        ->get();

        $dadosAcoes = $this->MovimentosIndex($Acoes->toArray());
        $dadosFiis = $this->MovimentosIndex($Fiis->toArray());

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
            return redirect()->route('movimento.exportMovimentoAtivos', [
                'data_ini' => $data_inicio,
                'data_fi' => $data_fim,
                'tip' => $tipo,
            ]);
        } else {
            return redirect()->route('movimento.exportMovimentoAtivosPdf', [
                'data_ini' => $data_inicio,
                'data_fi' => $data_fim,
                'tip' => $tipo,
            ]);
        }
    }

    /**
     * gerar excel
     */
    public function exportMovimentoAtivos($data_ini, $data_fi, $tip)
    {
        $data_inicio = $data_ini;
        $data_fim = $data_fi;
        $tipo = $tip;
        $movimentosAcoes = MovimentoAtivos::where('tipo', $tipo)
        ->whereBetween('data', [$data_inicio, $data_fim])
        ->orderBy('data')
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
    public function exportMovimentoAtivosPdf($data_ini, $data_fi, $tip)
    {
        $data_inicio = $data_ini;
        $data_fim = $data_fi;
        $tipo = $tip;


        $Acoes = MovimentoAtivos::where('tipo', 'acao')
        ->whereBetween('data', [$data_inicio, $data_fim])
        ->orderBy('data')
        ->get();

        $dadosAcoes = [];

        $Fiis = MovimentoAtivos::where('tipo', 'fundo imobiliario')
        ->whereBetween('data', [$data_inicio, $data_fim])
        ->orderBy('data')
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
                'valor_total' => number_format(floatval($movimentoacao->valor_total), 2, '.', ''),
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
                'valor_total' => number_format(floatval($movimentofii->valor_total), 2, '.', ''),
                'data' => Carbon::parse($movimentofii->data)->format('d/m/Y'),
            ];
        }

        $pdf = PDF::loadView('PDF.movimentospdf', compact('dadosAcoes', 'dadosFiis'));

        return $pdf->stream('download.pdf');
    }
}
