<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function auth(Request $request)
    {

    try {
        $credenciais = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6|regex:/^(?=.*[a-zA-Z])(?=.*\d)/',
        ]);
    
        if (Auth::attempt($credenciais)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        } else {
            return redirect()->back()->with('msg', 'Usuário não encontrado');
        }
    } catch (\Exception $e) {

        return redirect()->back()->withErrors(['message' => 'Erro ao autenticar usuário.']);
    }
        
    }
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
