<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        return view('welcome');
    }
    /* cadastro*/
    public function create()
    {
        return view('criacao_usuario.cadastro');
    }
    public function store(Request $request)
    {
    try {
        $credenciais = $request->validate([
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|regex:/^(?=.*[a-zA-Z])(?=.*\d)/',
        ]);

        $user = new User();
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        return redirect('/')->with('msg', 'Cadastrado com sucesso.');
    } catch (\Exception $e) {

        return redirect()->back()->withErrors(['message' => 'Erro ao cadastrar usuário.']);
    }
    }
}
