<?php

use App\Livewire\Forms\UpdateProfileForm;
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
     */
    public function mount(): void
    {
        $user = auth()->user();

        if (! $user) {
            return;
        }

        $this->form->fill([
            'user' => $user,
            'name' => $user->name,
            'email' => $user->email,
        ]);
    }

    /**
     * Update the authenticated user's profile in storage.
     */
    public function edit(): void
    {
        $this->form->update();

        session()->flash('success', 'Profil berhasil diperbarui.');

        $this->redirect(route('pengaturan.profil'), navigate: true);
    }
};
