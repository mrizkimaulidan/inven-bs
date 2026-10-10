<?php

use App\Livewire\Forms\StoreUserForm;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Spatie\Permission\Models\Role;

new class extends Component
{
    /**
     * The form instance.
     */
    public StoreUserForm $form;

    #[Computed]
    public function roles(): Collection
    {
        return Role::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function save(): void
    {
        $this->form->store();

        $this->redirect('/pengguna', navigate: true);
    }
};
