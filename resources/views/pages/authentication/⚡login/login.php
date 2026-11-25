<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

new #[Layout('layouts::authentication.app')] class extends Component
{
    /**
     * The login form object.
     */
    public LoginForm $form;

    /**
     * Authenticate the user and regenerate the session on success.
     */
    public function authenticate(): void
    {
        $validated = $this->form->validate();

        $remember = (bool) ($validated['remember'] ?? false);

        if (! Auth::attempt([
            'email' => $validated['email'],
            'password' => $validated['password'],
        ], $remember)) {
            $this->addError('form.email', 'Alamat email atau kata sandi tidak sesuai.');

            return;
        }

        $this->reset('form.password');
        request()->session()->regenerate();

        $this->redirectIntended(route('beranda'), navigate: true);
    }
};
