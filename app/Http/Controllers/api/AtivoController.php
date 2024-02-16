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
        return MovimentoAtivos::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        MovimentoAtivos::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return MovimentoAtivos::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $Ativos = MovimentoAtivos::findOrFail($id);
        $Ativos-> update ($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $Ativos = MovimentoAtivos::findOrFail($id);
        $Ativos-> delete ();
    }
}
