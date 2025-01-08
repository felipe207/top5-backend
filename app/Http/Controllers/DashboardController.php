<?php

namespace App\Http\Controllers;

use App\Models\Musica;

use App\Models\User;

class DashboardController extends Controller
{

    public function index()
    {
        $data = ['musicas', 'users'];
        $musicas = Musica::count();
        $users = User::count();

        return view('auth.dashboard', compact($data));
    }
}
