<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        return response()->json([
            'code' => Response::HTTP_OK,
            'message' => 'success',
            'data' => $role->load('permissions')
        ], Response::HTTP_OK);
    }
}
