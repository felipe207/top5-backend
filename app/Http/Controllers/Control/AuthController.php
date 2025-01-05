<?php
 
namespace App\Http\Controllers\Control;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
 
class AuthController extends Controller
{
    public function login(Request $request): JsonResponse|RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
 
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
 
            return redirect()->intended('user');
        }
 
        return apiResponse(true, [
            'Suas credenciais estão incorretas.'
        ], null, 401);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->session()->invalidate();
 
        auth()->guard('web')->logout();
 
        return apiResponse(false, [
            'Você foi deslogado com sucesso.'
        ], null, 200);
    }
}