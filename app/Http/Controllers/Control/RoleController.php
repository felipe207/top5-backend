<?php

namespace App\Http\Controllers\Control;

use App\Http\Requests\Control\RoleStoreRequest;
use App\Http\Requests\Control\RoleUpdateRequest;
use App\Http\Resources\Control\RoleResource;
use Illuminate\Routing\Controller;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();

        return apiResponse(false, [], RoleResource::collection($roles));
    }

    public function store(RoleStoreRequest $request)
    {
        $role = Role::create(['name' => $request->input('name'), 'guard_name' => 'web']);
        $role->syncPermissions($request->input('permission'));

        return apiResponse(false, ['Função criada com sucesso!'], new RoleResource($role));
    }

    public function show($id)
    {
        $role = Role::find($id);

        return apiResponse(false, [], new RoleResource($role));
    }

    public function update(RoleUpdateRequest $request, $id)
    {
        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->save();

        $role->syncPermissions($request->input('permission'));

        return apiResponse(false, ['Função atualizada com sucesso!'], new RoleResource($role));
    }

    public function destroy($id)
    {
        $role = Role::find($id);
        $role->delete();

        return apiResponse(false, ['Função deletada com sucesso!']);
    }
}
