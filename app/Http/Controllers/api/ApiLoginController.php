<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiLoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials  = $request->validate([
        'email' => 'required|email',
        'password' => 'required|string|min:6|regex:/^(?=.*[a-zA-Z])(?=.*\d)/',
        ]);

        if (Auth::attempt($credentials)) {
            return (new ApiAtivoController())->index();
        } else {
            return response()->json(['message' => 'Erro ao autenticar usuário.'], 401);
        }
    }
}
