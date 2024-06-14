<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiLoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('api_token')->plainTextToken;
            
            return response()->json([
                'message' => 'Ok',
                'token' => $token,
            ], 200);
        } else {
            return response()->json( 'Erro ao autenticar usuário', 403);
        }
    }
}
