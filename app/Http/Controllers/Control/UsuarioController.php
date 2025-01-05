<?php

namespace App\Http\Controllers\Control;

use App\Http\Requests\Control\UsuarioStoreRequest;
use App\Http\Requests\Control\UsuarioUpdateRequest;
use App\Http\Resources\Control\UserResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Routing\Controller;
use App\Models\User;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = User::orderBy('name')->get();

        return apiResponse(false, [], UserResource::collection($usuarios));
    }

    public function store(UsuarioStoreRequest $request)
    {
        $user = User::create([
            'name' => $request->input('name'),
            'email'  => $request->input('email'),
            'password' => Hash::make($request->input('password'))
        ]);

        $user->assignRole($request->input('roles'));

        return apiResponse(false, ['Usuário cadastrado com sucesso'], new UserResource($user));
    }

    public function show($id)
    {
        $user = User::find($id);

        return apiResponse(false, [], new UserResource($user));
    }

    public function update($id, UsuarioUpdateRequest $request)
    {
        if ($request->only('password')['password'] == null) {
            $input = $request->except('password', 'password_confirmation');
        } else {
            $input = $request->all();
            $input['password'] = Hash::make($request->input('password'));
        }

        $user = User::findOrFail($id);

        $user->update($input);

        $user->syncRoles($request->input('roles'));

        return apiResponse(false, ['Usuário atualizado com sucesso'], new UserResource($user));
    }

    public function destroy($id)
    {
        $user = User::find($id);

        $user->delete();

        return apiResponse(false, ['Usuário excluído com sucesso']);
    }
}
