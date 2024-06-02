<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Services\YahooFinanceService;
use App\Models\MovimentoAtivos;

class ListaAtivosController extends Controller
{
    protected $yahooFinanceService;

    public function __construct(YahooFinanceService $yahooFinanceService)
    {
        $this->yahooFinanceService = $yahooFinanceService;
    }

    
    /*Função para mostrar os dados de todos os ativos.*/
    private function mostrarTudo($movimento)
    {
        $dados = [];

        // Calcula o valor total de todos os ativos
        $valorTotalAtivo = $this->valorTodosAtivos($movimento);
        $precosAtuais = $this->getStockPrices($movimento);

        foreach ($movimento as $nome => $movimentos) {
            $compras = $movimentos->where('movimento', 'compra');
            $vendas = $movimentos->where('movimento', 'venda');

            $quantidadeCompra = $compras->sum('quantidade');
            $quantidadeVenda = $vendas->sum('quantidade');

            // Calcula o valor total de compra e venda
            $valorCompra = $compras->sum('valor_total');
            $valorVenda = $vendas->sum('valor_total');

            // Calcula o valor completo do ativo
            $valorCompleto =  $valorCompra - $valorVenda;

            $quantidadeTotal = $quantidadeCompra - $quantidadeVenda;

            $precoAtual = $precosAtuais[$nome] ?? 0;

            // Calcula o preço médio do ativo
            if ($quantidadeCompra > 0 && $valorCompra > 0) {
                $precoMedio = $valorCompra / $quantidadeCompra;
            } else {
                $precoMedio = 0;
            }

            // Calculando a porcentagem em relação ao valor total de todos os ativos
            if ($valorCompleto > 0 && $valorTotalAtivo['valorTotal'] > 0) {
                $porcentagem = ($valorCompleto / $valorTotalAtivo['valorTotal']) * 100;
            } else {
                $porcentagem = 0;
            }

            $dados[] = [
                'nome' => $nome,
                'quantidadeTotal' => $quantidadeTotal,
                'precoMedio' => $precoMedio,
                'precoAtual' => $precoAtual,
                'valorTotal' => $valorCompleto,
                'porcentagem' => $porcentagem,
            ];
        }
        return $dados;
    }
    
    private function getStockPrices($movimento)
    {
        $precosAtuais = [];
    
        foreach ($movimento as $nome => $movimentos) {
            if ($movimentos->isNotEmpty()) { // Verifica se a coleção não está vazia
                $symbol = $movimentos->first()->nome;  // Símbolo da ação
    
                // Obter o preço da ação usando o serviço YahooFinanceService
                $preco = $this->yahooFinanceService->getStockPrice($symbol);
    
                $precosAtuais[] = [
                    'nome' => $symbol,
                    'precoAtual' => $preco
                ];
            }
        }
    
        return $precosAtuais;
    }
    
    /*Função para calcular o valor total de todos os ativos.*/
    private function valorTodosAtivos($movimento)
    {
        $dado = [];
        $valorTotal = 0;
        foreach ($movimento as $movimentos) {
            // Filtra os movimentos de compra e venda
            $compras = $movimentos->where('movimento', 'compra');
            $vendas = $movimentos->where('movimento', 'venda');

            $quantidadeCompra = $compras->sum('quantidade');
            $quantidadeVenda = $vendas->sum('quantidade');

            // Calcula o valor total de compra e venda
            $valorCompra = $compras->sum('valor_total');
            $valorVenda = $vendas->sum('valor_total');

            $quantidadeTotal = $quantidadeCompra - $quantidadeVenda;

            // Calcula o valor completo do ativo
            $valorCompleto =  $valorCompra - $valorVenda;

            if ($valorCompleto > 0 && $quantidadeTotal > 0) {
                $valorTotal += $valorCompleto;
            } else {
                $valorTotal += 0;
            }
        }
        $dado['valorTotal'] = $valorTotal;
        return $dado;
    }

    public function index()
    {
        $user = Auth::user();

        $movimentosAcoes = MovimentoAtivos::where('tipo', 'acao')
            ->whereIn('movimento', ['compra', 'venda'])
            ->where('user_id', $user->id)
            ->get();
        $dadosAcoes = [];

        $movimentosFiis = MovimentoAtivos::where('tipo', 'fundo imobiliario')
            ->whereIn('movimento', ['compra', 'venda'])
            ->where('user_id', $user->id)
            ->get();
        $dadosFiis = [];

        $dadosAcoes = $this->mostrarTudo($movimentosAcoes->groupBy('nome'));

        $dadosFiis = $this->mostrarTudo($movimentosFiis->groupBy('nome'));

        return view('crud.listaAtivos', compact('dadosAcoes', 'dadosFiis'));
    }
}
