<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\MovimentoAtivos;

class AtivoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $user = Auth::user();
            return MovimentoAtivos::all();
        } catch (\Exception $e) {
            return response()->json(['Erro ao mostrar movimento.' => $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'tipo' => 'required|in:fundo imobiliario,acao',
                'movimento' => 'required|in:compra,venda',
                'nome' => 'required|string|max:6|regex:/^[a-z0-9]+$/',
                'data' => 'required|date|before_or_equal:' . now()->toDateString(),
                'corretagem' => 'required|numeric|gt:-1',
                'quantidade' => 'required|numeric|gt:0',
                'valor' => 'required|numeric|gt:0',

            ]);

            $user = Auth::user();

            $ativos = new MovimentoAtivos();

            $ativos-> user_id = $user->id;
            $ativos-> tipo = $request->tipo;
            $ativos-> movimento = $request->movimento;
            $ativos-> nome = $request->nome;
            $ativos-> quantidade = $request->quantidade;
            $ativos-> corretagem = $request->corretagem;
            $ativos-> valor = $request->valor;
            $ativos-> data = $request->data;
            $ativos-> valor_total = ($request->corretagem + ($request->valor * $request->quantidade));

            $ativos->save();

            return ( 'Cadastrado com sucesso.');
        } catch (\Exception $e) {
            return response()->json(['Erro ao cadastrar movimento.' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $user = Auth::user();

            return MovimentoAtivos::findOrFail($id);
        } catch (\Exception $e) {
            return response()->json(['Erro ao mostar movimento.' => $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $user = Auth::user();

            $movimento = MovimentoAtivos::findOrFail($id);

            $request->validate([
                'tipo' => 'required|in:fundo imobiliario,acao',
                'movimento' => 'required|in:compra,venda',
                'nome' => 'required|string|max:6|regex:/^[a-z0-9]+$/',
                'data' => 'required|date|before_or_equal:now',
                'corretagem' => 'required|numeric|gt:-1',
                'quantidade' => 'required|numeric|gt:0',
                'valor' => 'required|numeric|gt:0',

            ]);

            $dadosAtualizados = $request->only([
                'tipo',
                'movimento',
                'nome',
                'data',
                'corretagem',
                'quantidade',
                'valor',
            ]);

            $dadosAtualizados['valor_total'] = $request->corretagem + ($request->valor * $request->quantidade);

            $movimento->save($dadosAtualizados);

            return ('Movimento atualizado com sucesso.');
        } catch (\Exception $e) {
            return response()->json(['Erro ao atualizar o movimento.' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $user = Auth::user();

            $Ativos = MovimentoAtivos::findOrFail($id);
            $Ativos-> delete();
        } catch (\Exception $e) {
            return response()->json(['Erro ao deletar movimento.' => $e->getMessage()], 500);
        }
    }
}
