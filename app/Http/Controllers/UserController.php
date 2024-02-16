<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $usu = User::all();
        return view('welcome', compact('usu'));
    }
    /* cadastro*/
    public function create()
    {
        return view('criacao.cadastro');
    }
    public function store(Request $request)
    {
        $credenciais = $request->validate([
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|regex:/^(?=.*[a-zA-Z])(?=.*\d)/',
        ]);

        if (strlen($credenciais['password']) < 6) {
            // Usuário não atende aos requisitos mínimos
            return redirect()->back()->with('msg', 'Erro: O nome e a senha devem ter pelo menos 6 caracteres.');
        }

        $user = new User();
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();
        return redirect('/')->with('msg', 'Cadastrado com sucesso.');
    }
}
