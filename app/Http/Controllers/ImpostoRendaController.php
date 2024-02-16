<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\MovimentoAtivos;
use App\Exports\AtivosExport;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class ImpostoRendaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $movimentosAcoes = MovimentoAtivos::where('tipo', 'acao')->whereIn('movimento', ['compra', 'venda'])->get();
        $dadosAtivos = [];

        $movimentosFiis = MovimentoAtivos::where('tipo', 'fundo imobiliario')->whereIn('movimento', ['compra', 'venda'])->get();
        $dadosfiis = [];

        $movimentosAcoesAgrupados = $movimentosAcoes->groupBy('nome');
        $movimentosFissAgrupados = $movimentosFiis->groupBy('nome');
 
        foreach ($movimentosAcoesAgrupados as $nome => $movimentos) {
            $compras = $movimentos->where('movimento', 'compra');
            $vendas = $movimentos->where('movimento', 'venda');       
    
            $quantidadeCompra = $compras->sum('quantidade');
            $quantidadeVenda = $vendas->sum('quantidade'); 

            $valorCompra = $compras->sum('valortotal');
    
            $quantidadeTotal = $quantidadeCompra - $quantidadeVenda;


            $movimento = $quantidadeTotal > 0 ? 'compra' : 'venda';
    
            $dadosAtivos[] = [
                'nome' => $nome,
                'compra' => [
                    'quantidadeTotal' => $quantidadeTotal,
                    'total' => $quantidadeCompra  > 0 ? $compras->sum('valortotal') : 0,
                ],
                'venda' => [
                    'quantidadeTotal' => $quantidadeVenda,
                    'total' => $quantidadeVenda > 0 ? $vendas->sum('valortotal') : 0,
                ],
            ];
        }

        foreach ($movimentosFissAgrupados as $nome => $movimentos) {
            $compras = $movimentos->where('movimento', 'compra');
            $vendas = $movimentos->where('movimento', 'venda');       
    
            $quantidadeCompra = $compras->sum('quantidade');
            $quantidadeVenda = $vendas->sum('quantidade'); 

            $valorCompra = $compras->sum('valortotal');
    
            $quantidadeTotal = $quantidadeCompra - $quantidadeVenda;


            $movimento = $quantidadeTotal > 0 ? 'compra' : 'venda';
    
            $dadosfiis[] = [
                'nome' => $nome,
                'compra' => [
                    'quantidadeTotal' => $quantidadeTotal,
                    'total' => $quantidadeCompra  > 0 ? $compras->sum('valortotal') : 0,
                ],
                'venda' => [
                    'quantidadeTotal' => $quantidadeVenda,
                    'total' => $quantidadeVenda > 0 ? $vendas->sum('valortotal') : 0,
                ],
            ];
        }
        
        return view('ir.impostoRenda', compact('dadosAtivos','dadosfiis'));
    }

    public function exportAtivos(Request $request)
    {
        $data_inicio = $request->input('data_inicio');
        $data_fim = $request->input('data_fim');
        $tipo = $request->input('tipo');
        $movimentosAcoes = MovimentoAtivos::where('tipo', $tipo)
        ->whereIn('movimento', ['compra', 'venda'])
        ->whereBetween('data', [$data_inicio, $data_fim])->get();     

        $dadosAtivos = [];
    
        $movimentosAcoesAgrupados = $movimentosAcoes->groupBy('nome');
    
        foreach ($movimentosAcoesAgrupados as $nome => $movimentos) {
            foreach ($movimentos as $movimento) {

                $compras = $movimentos->where('movimento', 'compra');
                $vendas = $movimentos->where('movimento', 'venda');
        
                $quantidadeCompra = $compras->sum('quantidade');
                $quantidadeVenda = $vendas->sum('quantidade');
                $corretagem = $compras->sum('corretagem') + $vendas->sum('corretagem');
        
                $valorCompra = $compras->sum('valortotal');
                $valorVenda = $vendas->sum('valortotal');
                $valorFinal = $valorCompra -  $valorVenda;

                $dataTransacao = Carbon::parse($movimento->data)->format('d/m/Y');
        
                $quantidadeTotal = $quantidadeCompra - $quantidadeVenda;
        
                $dadosAtivos[] = [
                    'nome' => $nome,
                    'datatransacao' =>  $dataTransacao,
                    'quantidadeCompra' =>  $quantidadeCompra > 0 ?$quantidadeCompra: '0',
                    'quantidadeVenda' =>  $quantidadeVenda > 0 ?$quantidadeVenda : '0',
                    'quantidadeTotal' =>  $quantidadeTotal > 0 ?$quantidadeTotal: '0',
                    'SomaCorretagem' =>  $corretagem > 0 ?'R$ ' . number_format(($corretagem), 2, ',', '.') : 'R$ 0,00',
                    'valorCompra' => $valorCompra > 0 ?  'R$ ' . number_format(($valorCompra), 2, ',', '.') : 'R$ 0,00',
                    'valorVenda' => $valorVenda > 0 ? 'R$ ' . number_format(($valorVenda), 2, ',', '.') : 'R$ 0,00',          
                    'valorFinal' => $valorFinal > 0 ? 'R$ ' . number_format(($valorFinal), 2, ',', '.') : 'R$ 0,00',           
                ];
            }
        }

        if ($tipo == "fundo imobiliario") {
            return Excel::download(new AtivosExport($dadosAtivos), 'Fiis.xlsx');
        } else {
            return Excel::download(new AtivosExport($dadosAtivos), 'Ações.xlsx');        
        }
    
    }

    public function exportIrpdfPdf(Request $request)
    {
        $movimentosAcoes = MovimentoAtivos::where('tipo', 'acao')->whereIn('movimento', ['compra', 'venda'])->get();
        $dadosAtivos = [];

        $movimentosFiis = MovimentoAtivos::where('tipo', 'fundo imobiliario')->whereIn('movimento', ['compra', 'venda'])->get();
        $dadosfiis = [];

        $movimentosAcoesAgrupados = $movimentosAcoes->groupBy('nome');
        $movimentosFissAgrupados = $movimentosFiis->groupBy('nome');
 
        foreach ($movimentosAcoesAgrupados as $nome => $movimentos) {
            $compras = $movimentos->where('movimento', 'compra');
            $vendas = $movimentos->where('movimento', 'venda');       
    
            $quantidadeCompra = $compras->sum('quantidade');
            $quantidadeVenda = $vendas->sum('quantidade'); 

            $valorCompra = $compras->sum('valortotal');
    
            $quantidadeTotal = $quantidadeCompra - $quantidadeVenda;


            $movimento = $quantidadeTotal > 0 ? 'compra' : 'venda';
    
            $dadosAtivos[] = [
                'nome' => $nome,
                'compra' => [
                    'quantidadeTotal' => $quantidadeTotal,
                    'total' => $quantidadeCompra  > 0 ? $compras->sum('valortotal') : 0,
                ],
                'venda' => [
                    'quantidadeTotal' => $quantidadeVenda,
                    'total' => $quantidadeVenda > 0 ? $vendas->sum('valortotal') : 0,
                ],
            ];
        }

        foreach ($movimentosFissAgrupados as $nome => $movimentos) {
            $compras = $movimentos->where('movimento', 'compra');
            $vendas = $movimentos->where('movimento', 'venda');       
    
            $quantidadeCompra = $compras->sum('quantidade');
            $quantidadeVenda = $vendas->sum('quantidade'); 

            $valorCompra = $compras->sum('valortotal');
    
            $quantidadeTotal = $quantidadeCompra - $quantidadeVenda;


            $movimento = $quantidadeTotal > 0 ? 'compra' : 'venda';
    
            $dadosfiis[] = [
                'nome' => $nome,
                'compra' => [
                    'quantidadeTotal' => $quantidadeTotal,
                    'total' => $quantidadeCompra  > 0 ? $compras->sum('valortotal') : 0,
                ],
                'venda' => [
                    'quantidadeTotal' => $quantidadeVenda,
                    'total' => $quantidadeVenda > 0 ? $vendas->sum('valortotal') : 0,
                ],
            ];
        }
        
        $pdf = PDF::loadView('PDF.irpdf', compact('dadosAtivos','dadosfiis'));

        return $pdf->stream('download.pdf');
    }

}
