<?php

use App\Livewire\Forms\StoreUserForm;
use App\Models\Role;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;

/**
 * Load assignable roles and create a user with the selected role.
 */
new class extends Component
{
    /**
     * The form instance.
     */
    public StoreUserForm $form;

    /**
     * Get the roles available for assignment.
     *
     * @return Collection<int, Role>
     */
    #[Computed]
    public function roles(): Collection
    {
        $permissionNames = auth()->user()?->getAllPermissions()->pluck('name') ?? collect();

        return Role::query()
            ->with('permissions')
            ->get()
            ->filter(static fn (Role $role): bool => $role->permissions->pluck('name')->diff($permissionNames)->isEmpty())
            ->values();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function save(): void
    {
        $this->form->store();

        session()->flash('success', 'Data pengguna berhasil ditambahkan!');

        $this->redirect(route('pengguna.index'), navigate: true);
    }
};
