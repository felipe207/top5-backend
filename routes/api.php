<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MusicasController;

Route::post('/login', [AuthController::class, 'login']);

// Route::middleware(['web'])->post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::get('/user', [AuthController::class, 'user'])->middleware('auth:sanctum');


Route::post('/salva-musica', [MusicasController::class, 'salva'])->name('salva.musicas');
Route::get('/musicas', [MusicasController::class, 'musicas'])->name('api.musicas');

// editar música
Route::post('/update-musica/{id}', [MusicasController::class, 'atualiza'])->name('atualiza.musicas');
// deletar música
Route::delete('/delete-musica/{id}', [MusicasController::class, 'deleta'])->name('deleta.musicas');
// ordenar musicas
Route::post('/ordena-musicas', [MusicasController::class, 'ordena'])->name('ordena.musicas');


Route::middleware('api')->group(function () {
    Route::get('/test', function () {
        return response()->json(['message' => 'API route is working']);
    });
});
