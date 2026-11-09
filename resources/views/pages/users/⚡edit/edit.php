<?php

use App\Livewire\Forms\UpdateUserForm;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Spatie\Permission\Models\Role;

/**
 * Load the user and available roles, then save account changes.
 */
new class extends Component
{
    /**
     * The form instance.
     */
    public UpdateUserForm $form;

    /**
     * Get the roles available for assignment.
     *
     * @return Collection
     */
    #[Computed]
    public function roles(): Collection
    {
        $permissionNames = auth()->user()->getAllPermissions()->pluck('name');
        $currentRoleId = $this->form->user->roles()->value('roles.id');

        return Role::with('permissions')->get()
            ->filter(fn (Role $role) => $role->id === $currentRoleId
                || $role->permissions->pluck('name')->diff($permissionNames)->isEmpty())
            ->values();
    }

    /**
     * Load the user and populate the form with its current role and details.
     *
     * @param  int  $userId
     * @return void
     */
    public function mount(int $userId): void
    {
        $user = User::findOrFail($userId);

        $this->form->fill([
            'user' => $user,
            'name' => $user->name,
            'email' => $user->email,
            'role_id' => $user->roles->first()->id,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return void
     */
    public function edit(): void
    {
        $this->form->update();

        session()->flash('success', 'Data pengguna berhasil diubah!');

        $this->redirect('/pengguna', navigate: true);
    }
};
