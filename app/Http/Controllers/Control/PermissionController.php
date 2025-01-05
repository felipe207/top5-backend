<?php

namespace App\Http\Controllers\Control;

use App\Http\Resources\Control\PermissionResource;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::all();

        return apiResponse(false, [], PermissionResource::collection($permissions));
    }
}
