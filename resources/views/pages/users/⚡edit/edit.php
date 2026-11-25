<?php

use App\Livewire\Forms\UpdateUserForm;
use App\Models\User;
use Illuminate\Support\Collection;
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
     * @return Collection<int, Role>
     */
    #[Computed]
    public function roles(): Collection
    {
        $permissionNames = auth()->user()?->getAllPermissions()->pluck('name') ?? collect();
        $currentRoleId = $this->form->user?->roles()->value('roles.id');

        return Role::query()
            ->with('permissions')
            ->get()
            ->filter(static fn (Role $role): bool => $role->id === $currentRoleId
                || $role->permissions->pluck('name')->diff($permissionNames)->isEmpty())
            ->values();
    }

    /**
     * Load the user and populate the form with its current role and details.
     */
    public function mount(int $userId): void
    {
        $user = User::query()->with('roles')->findOrFail($userId);

        $this->form->fill([
            'user' => $user,
            'name' => $user->name,
            'email' => $user->email,
            'role_id' => $user->roles->first()?->id,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function edit(): void
    {
        $this->form->update();

        session()->flash('success', 'Data pengguna berhasil diubah!');

        $this->redirect(route('pengguna.index'), navigate: true);
    }
};
