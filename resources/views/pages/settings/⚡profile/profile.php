<?php

use App\Livewire\Forms\UpdateProfileForm;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Pengaturan Profil')] class extends Component
{
    /**
     * The form instance.
     */
    public UpdateProfileForm $form;

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        Auth::loginUsingId(1);

        $user = auth()->user();

        $this->form->fill([
            'user' => $user,
            'name' => $user->name,
            'email' => $user->email,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function edit(): void
    {
        $this->form->update();

        $this->redirect('/pengaturan/profil', navigate: true);
    }
};
