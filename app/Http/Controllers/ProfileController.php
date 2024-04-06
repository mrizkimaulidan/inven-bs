<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use App\User;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('mengatur profile');

        return view('profile');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProfileRequest $request)
    {
        $this->authorize('mengatur profile');

        $user = User::find(auth()->id());
        $validated = $request->validated();

        if ($user->email !== $validated['email']) {
            $user->update([
                'email' => $validated['email']
            ]);

            auth()->logout();

            return to_route('login')->with('success', 'Email berhasil diubah! Mohon login kembali.');
        }

        if ($validated['password'] !== null && $validated['password_confirmation'] !== null) {
            $user->update([
                'password' => bcrypt($validated['password'])
            ]);

            auth()->logout();

            return to_route('login')->with('success', 'Kata sandi berhasil diubah! Mohon login kembali.');
        }

        $user->update([
            'name' => $validated['name'],
        ]);

        return to_route('profile.index')->with('success', 'Profil berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
