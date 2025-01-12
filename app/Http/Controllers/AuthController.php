<?php

namespace App\Http\Controllers;

use App\Api\ApiMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller {
    public function login( Request $request ) {
        try {
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            if (Auth::attempt($credentials)) {
                $user = Auth::user();
                $token = $user->createToken('API Token')->plainTextToken;
                $response = new ApiMessage(false, 'Logado com sucesso!', ['token' => $token, 'user' => $user]);
                return response()->json($response->getResponse());
            }

            $response = new ApiMessage(true, 'As credenciais não coincidem com nossos registros!');
            return response()->json($response->getResponse());
        } catch (\Throwable $th) {
            Log::error($th);
            $response = new ApiMessage(true, 'Erro ao salvar música!', $th->getMessage());
            return response()->json($response->getResponse());
        }

    }

    public function logout( Request $request ) {
        Auth::guard( 'web' )->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json( [ 'message' => 'Deslogado com sucesso!' ] );
    }

    public function user( Request $request ) {
        return response()->json( $request->user() );
    }
}
