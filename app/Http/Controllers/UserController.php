<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\User;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(User::class, 'user');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = User::query();

        $query->when(request()->filled('role_id'), function ($q) {
            return $q->whereRelation('roles', 'id', '=', request('role_id'));
        });

        $users = $query->get()->except(auth()->id());
        $roles = Role::withCount('users')->get();
        $departments = \App\Department::all();

        return view('users.index', compact('users', 'roles', 'departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $validated = $request->validated();
        $role = Role::findById($validated['role_id']);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);
        $user->assignRole($role);

        return to_route('pengguna.index')->with('success', 'Data berhasil ditambahkan!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $validated = $request->validated();
        $role = Role::findById($validated['role_id']);

        $credentials = [];
        if ($validated['password'] !== null) {
            $credentials['password'] = bcrypt($validated['password']);
        } else {
            $credentials = collect($validated)->except('password', 'password_confirmation')->toArray();
        }

        $user->update($credentials);
        $user->syncRoles($role);

        return redirect()->route('pengguna.index')->with('success', 'Data berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return to_route('pengguna.index')->with('success', 'Data berhasil dihapus!');
    }
}
