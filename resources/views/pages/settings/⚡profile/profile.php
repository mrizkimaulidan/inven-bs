<?php

use App\Livewire\Forms\UpdateProfileForm;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;

/**
 * Load and update the signed-in user profile.
 */
new #[Title('Pengaturan Profil')] class extends Component
{
    /**
     * The form instance.
     */
    public UpdateProfileForm $form;

    /**
     * Load the signed-in user and populate the profile form.
     *
     * @return void
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
     *
     * @return void
     */
    public function edit(): void
    {
        $this->form->update();

        $this->redirect('/pengaturan/profil', navigate: true);
    }
};
