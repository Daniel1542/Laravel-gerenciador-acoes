<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MovimentoAtivos;

class AtivoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
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

            $ativos = new MovimentoAtivos();

            $ativos-> tipo = $request->tipo;
            $ativos-> movimento = $request->movimento;
            $ativos-> nome = $request->nome;
            $ativos-> quantidade = $request->quantidade;
            $ativos-> corretagem = $request->corretagem;
            $ativos-> valor = $request->valor;
            $ativos-> data = $request->data;
            $ativos-> valortotal = ($request->corretagem + ($request->valor * $request->quantidade));

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

            $dadosAtualizados['valortotal'] = $request->corretagem + ($request->valor * $request->quantidade);

            $movimento->update($dadosAtualizados);

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
            $Ativos = MovimentoAtivos::findOrFail($id);
            $Ativos-> delete();
        } catch (\Exception $e) {
            return response()->json(['Erro ao deletar movimento.' => $e->getMessage()], 500);
        }
    }
}
