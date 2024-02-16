<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\MovimentoAtivos; 


class LoginController extends Controller
{
    public function auth(Request $request)
    {
        $credenciais = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6|regex:/^(?=.*[a-zA-Z])(?=.*\d)/',
        ]);

        if (Auth::attempt($credenciais)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        } else {
            return redirect()->back()->with('msg', 'erro');
        }
    }

    public function dash()
    {
        $acoesCount = MovimentoAtivos::where('tipo', 'acao')->distinct('nome')->count('nome');
        $fiisCount = MovimentoAtivos::where('tipo', 'fundo imobiliario')->distinct('nome')->count('nome');

    return view('principal.dashboard', compact('acoesCount', 'fiisCount'));
    }


}
