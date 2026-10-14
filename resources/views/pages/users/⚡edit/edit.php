<?php

use App\Livewire\Forms\UpdateUserForm;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Spatie\Permission\Models\Role;

new class extends Component
{
    /**
     * The form instance.
     */
    public UpdateUserForm $form;

    #[Computed]
    public function roles(): Collection
    {
        return Role::all();
    }

    /**
     * Mount the component.
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
     */
    public function edit(): void
    {
        $this->form->update();

        session()->flash('success', 'Data pengguna berhasil diubah!');

        $this->redirect('/pengguna', navigate: true);
    }
};
