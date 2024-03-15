<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoleRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::all();
        $permissions = Permission::all();

        return view('roles.index', compact('roles', 'permissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request)
    {
        $validated = $request->validated();

        DB::beginTransaction();

        try {
            $role = Role::create([
                'name' => $validated['name'],
                'guard_name' => 'web'
            ]);

            $permissions = Permission::find($validated->permissions);
            $role->syncPermissions($permissions);
            DB::commit();

            return redirect()->route('peran-dan-hak-akses.index')->with('success', 'Data berhasil ditambahkan!');
        } catch (\Exception $ex) {
            DB::rollBack();

            return redirect()->route('peran-dan-hak-akses.index')->with('error', 'Data gagal ditambahkan!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $role->delete();

        return to_route('peran-dan-hak-akses.index')->with('success', 'Data berhasil dihapus!');
    }
}
