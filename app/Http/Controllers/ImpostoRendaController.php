<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MovimentoAtivos;
use Illuminate\Support\Facades\Auth;
use App\Exports\AtivosExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class ImpostoRendaController extends Controller
{
    /*function para fazer pdf e retornar index*/

    private function calcularMovimentos($movimento)
    {
        $dados = [];

        foreach ($movimento as $nome => $movimentos) {
            $compras = $movimentos->where('movimento', 'compra');
            $vendas = $movimentos->where('movimento', 'venda');

            $quantidadeCompra = $compras->sum('quantidade');
            $quantidadeVenda = $vendas->sum('quantidade');
            $quantidadeTotal = $quantidadeCompra - $quantidadeVenda;

            $ano = $movimentos->first()->data->year;
            $movimento = $quantidadeTotal > 0 ? 'compra' : 'venda';

            $dados[] = [
                'nome' => $nome,
                'compra' => [
                    'quantidadeTotal' => $quantidadeTotal,
                    'total' => $quantidadeCompra > 0 ? $compras->sum('valor_total') : 0,
                    'ano' => $ano,
                ],
                'venda' => [
                    'quantidadeTotal' => $quantidadeVenda,
                    'total' => $quantidadeVenda > 0 ? $vendas->sum('valor_total') : 0,
                    'ano' => $ano,
                ],
            ];
        }

        return $dados;
    }
    /*function excel*/
    private function calcularMovimentosExcel($movimentosAtivos)
    {
        $dados = [];

        foreach ($movimentosAtivos as $nome => $movimentos) {
            $quantidadeCompraTotal = 0;
            $quantidadeVendaTotal = 0;
            $valorCompraTotal = 0;
            $valorVendaTotal = 0;
            $corretagemTotal = 0;

            foreach ($movimentos as $movimento) {
                if ($movimento->movimento === 'compra') {
                    $quantidadeCompraTotal += $movimento->quantidade;
                    $valorCompraTotal += $movimento->valor_total;
                } elseif ($movimento->movimento === 'venda') {
                    $quantidadeVendaTotal += $movimento->quantidade;
                    $valorVendaTotal += $movimento->valor_total;
                }

                $corretagemTotal += $movimento->corretagem;
            }

            $quantidadeTotal = $quantidadeCompraTotal - $quantidadeVendaTotal;

            $valorFinal = $valorCompraTotal - $valorVendaTotal + $corretagemTotal;

            $dados[] = [
                'nome' => $nome,
                'quantidadeCompra' => $quantidadeCompraTotal > 0 ? $quantidadeCompraTotal : '0',
                'quantidadeVenda' => $quantidadeVendaTotal > 0 ? $quantidadeVendaTotal : '0',
                'quantidadeTotal' => $quantidadeTotal > 0 ? $quantidadeTotal : '0',
                'SomaCorretagem' => $corretagemTotal > 0 ? 'R$ ' . number_format($corretagemTotal, 2, ',', '.') : 'R$ 0,00',
                'valorCompra' => $valorCompraTotal > 0 ? 'R$ ' . number_format($valorCompraTotal, 2, ',', '.') : 'R$ 0,00',
                'valorVenda' => $valorVendaTotal > 0 ? 'R$ ' . number_format($valorVendaTotal, 2, ',', '.') : 'R$ 0,00',
                'valorFinal' => $valorFinal > 0 ? 'R$ ' . number_format($valorFinal, 2, ',', '.') : 'R$ 0,00',
            ];
        }

        return $dados;
    }

    /*function baixar excel ou pdf*/

    public function opcoes(Request $request)
    {
        $baixar = $request->input('baixar');
        $data = $request->input('data');

        $tipo = $request->input('tipo');
        if ($baixar == 'Excel') {
            return redirect()->route('imposto.exportAtivosExcel', [
                'data_ini' => $data,
                'tip' => $tipo,
            ]);
        } else {
            return redirect()->route('imposto.exportIrPdf', [
                'data_ini' => $data,
            ]);
        }
    }

    public function index(Request $request)
    {
        $user = Auth::user();

        $anoSelecionado = $request->input('data');
        $movimentosAcoes = MovimentoAtivos::where('tipo', 'acao')
            ->whereIn('movimento', ['compra', 'venda'])
            ->whereYear('data', $anoSelecionado)
            ->where('user_id', $user->id)
            ->get();

        $movimentosFiis = MovimentoAtivos::where('tipo', 'fundo imobiliario')
            ->whereIn('movimento', ['compra', 'venda'])
            ->whereYear('data', $anoSelecionado)
            ->where('user_id', $user->id)
            ->get();

        $dadosAtivos = $this->calcularMovimentos($movimentosAcoes->groupBy('nome'));
        $dadosfiis = $this->calcularMovimentos($movimentosFiis->groupBy('nome'));

        return view('ir.impostoRenda', compact('dadosAtivos', 'dadosfiis'));
    }

    /* PDF*/

    public function exportIrPdf($data_ini)
    {
        $user = Auth::user();

        $data_inicio = $data_ini;

        $movimentosAcoes = MovimentoAtivos::where('tipo', 'acao')
            ->whereIn('movimento', ['compra', 'venda'])
            ->whereYear('data', $data_inicio)
            ->where('user_id', $user->id)
            ->get();
        $dadosAtivos = [];

        $movimentosFiis = MovimentoAtivos::where('tipo', 'fundo imobiliario')
            ->whereIn('movimento', ['compra', 'venda'])
            ->whereYear('data', $data_inicio)
            ->where('user_id', $user->id)
            ->get();
        $dadosfiis = [];

        $dadosAtivos = $this->calcularMovimentos($movimentosAcoes->groupBy('nome'));
        $dadosfiis = $this->calcularMovimentos($movimentosFiis->groupBy('nome'));

        $pdf = PDF::loadView('PDF.irPdf', compact('dadosAtivos', 'dadosfiis'));

        return $pdf->stream('download.pdf');
    }

    /* excel*/

    public function exportAtivosExcel($data_ini, $tip)
    {
        $user = Auth::user();

        $data_inicio = $data_ini;
        $tipo = $tip;
        $movimentosAtivos = MovimentoAtivos::where('tipo', $tipo)
            ->whereIn('movimento', ['compra', 'venda'])
            ->whereYear('data', $data_inicio)
            ->where('user_id', $user->id)
            ->get();

        $dadosAtivos = [];

        $dadosAtivos = $this->calcularMovimentosExcel($movimentosAtivos->groupBy('nome'));

        if ($tipo == "fundo imobiliario") {
            return Excel::download(new AtivosExport($dadosAtivos), 'Fiis.xlsx');
        } else {
            return Excel::download(new AtivosExport($dadosAtivos), 'Ações.xlsx');
        }
    }
}
