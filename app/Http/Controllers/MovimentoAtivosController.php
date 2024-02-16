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
    /**
     * Display a listing of the resource.
     */
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

    /**
     * excel
     */

    public function exportMovimentoAtivos(Request $request)
    {
        $data_inicio = $request->input('data_inicio');
        $data_fim = $request->input('data_fim');
        $tipo = $request->input('tipo');
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

    public function exportMovimentoAtivosPdf()
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

        $pdf = PDF::loadView('PDF.movimentospdf', compact('dadosAcoes', 'dadosFiis'));

        return $pdf->stream('download.pdf');
    }
}
