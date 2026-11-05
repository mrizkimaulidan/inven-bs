<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

new #[Layout('layouts::authentication.app')] class extends Component
{
    /**
     * The login form.
     */
    public LoginForm $form;

    /**
     * Authenticate the user.
     *
     * @return void
     */
    public function authenticate(): void
    {
        $validated = $this->form->validate();

        if (! Auth::attempt([
            'email' => $validated['email'],
            'password' => $validated['password'],
        ], $validated['remember'])) {
            $this->addError('form.email', 'Alamat email atau kata sandi tidak sesuai.');

            return;
        }

        $this->reset('form.password');
        request()->session()->regenerate();

        $this->redirectIntended('/beranda', navigate: true);
    }
};
