<?php

use App\Http\Controllers\Control\AuthController;
use App\Http\Controllers\Control\ConfigController;
use App\Http\Controllers\Control\PermissionController;
use App\Http\Controllers\Control\RoleController;
use App\Http\Controllers\Control\UserController;
use App\Http\Controllers\Control\UsuarioController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return response()->json([
        'message' => 'Welcome to the Bredi Control Panel API v10.0',
        'status' => 'Connected'
    ]);
});

Route::controller(AuthController::class)->group(function () {
    Route::post('/login', 'login')->name('login');
    
    Route::post('/logout', 'logout')
        ->middleware('auth:sanctum')
        ->name('logout');
});

Route::get('/control/config', [ConfigController::class, 'index'])->name('control.config.index');

Route::group([
    'prefix'        => 'control/',
    'middleware'    => ['web', 'auth:sanctum', 'verified'],
    'as'            => 'control.'
] ,function () {

    /*--------------------------------------------------------------------------
    | Rotas para perfil
    |--------------------------------------------------------------------------*/
    Route::prefix('/profile')->controller(UserController::class)->name('profile.')->group(function () {
        Route::get('/', 'me')->name('me');
        Route::put('/', 'update')->name('update');
        Route::patch('/password', 'updatePassword')->name('updatePassword');
        Route::post('/photo', 'updatePhoto')->name('updatePhoto');
    });

    /*--------------------------------------------------------------------------
    | Rotas para configurações
    |--------------------------------------------------------------------------*/
    Route::prefix('/config')->controller(ConfigController::class)->name('config.')->group(function () {
        Route::post('/', 'update')->middleware('permission:Alterar Configurações')->name('update');
    });

    /*--------------------------------------------------------------------------
    | Rotas para o usuário
    |--------------------------------------------------------------------------*/
    Route::prefix('/user')->controller(UsuarioController::class)->name('user.')->group(function () {
        Route::get('/', 'index')->middleware('permission:Visualizar Usuário')->name('index');
        Route::post('/', 'store')->middleware('permission:Cadastrar Usuário')->name('store');
        Route::get('/{id}', 'show')->middleware('permission:Visualizar Usuário')->name('show');
        Route::put('/{id}', 'update')->middleware('permission:Alterar Usuário')->name('update');
        Route::delete('/{id}', 'destroy')->middleware('permission:Excluir Usuário')->name('delete');
    });

    /*--------------------------------------------------------------------------
    | Rotas para permissões
    |--------------------------------------------------------------------------*/
    Route::prefix('permission')->controller(PermissionController::class)->name('permission.')->group(function () {
        Route::get('/', 'index')->middleware('permission:Visualizar Função')->name('index');
    });

    /*--------------------------------------------------------------------------
    | Rotas para roles
    |--------------------------------------------------------------------------*/
    Route::prefix('role')->controller(RoleController::class)->name('role.')->group(function () {
        Route::get('/', 'index')->middleware('permission:Visualizar Função')->name('index');
        Route::post('/', 'store')->middleware('permission:Cadastrar Função')->name('store');
        Route::get('/{id}', 'show')->middleware('permission:Visualizar Função')->name('show');
        Route::put('/{id}', 'update')->middleware('permission:Alterar Função')->name('update');
        Route::delete('/{id}', 'destroy')->middleware('permission:Excluir Função')->name('delete');
    });

});
