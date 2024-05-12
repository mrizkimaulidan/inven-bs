<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Role::class, 'role');
    }

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

            $permissions = Permission::find($validated['permissions']);
            $role->syncPermissions($permissions);
            DB::commit();

            return redirect()->route('peran-dan-hak-akses.index')->with('success', 'Data berhasil ditambahkan!');
        } catch (\Exception $ex) {
            DB::rollBack();

            return redirect()->route('peran-dan-hak-akses.index')->with('error', 'Data gagal ditambahkan!');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        $validated = $request->validated();

        DB::beginTransaction();

        try {
            $role->update($validated);

            $permissions = Permission::find($validated['permissions']);
            $role->syncPermissions($permissions);
            DB::commit();

            return redirect()->route('peran-dan-hak-akses.index')->with('success', 'Data berhasil diubah!');
        } catch (\Exception $ex) {
            DB::rollBack();

            return redirect()->route('peran-dan-hak-akses.index')->with('error', 'Data gagal diubah!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        if ($role->users->isNotEmpty()) {
            return to_route('peran-dan-hak-akses.index')
                ->with('error', 'Peran tidak dapat dihapus karena masih terkait dengan data pengguna!');
        }

        $role->delete();

        return to_route('peran-dan-hak-akses.index')->with('success', 'Data berhasil dihapus!');
    }
}
