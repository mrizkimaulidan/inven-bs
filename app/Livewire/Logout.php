<?php

namespace App\Livewire;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

/**
 * Handle user logout and session cleanup in Livewire.
 */
class Logout extends Component
{
    /**
     * The logout button placement identifier.
     */
    public string $placement = 'dropdown';

    /**
     * Log out the user, invalidate the session, and redirect to login.
     */
    public function logout(): void
    {
        Auth::logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        $this->redirectRoute('login');
    }

    /**
     * Render the logout component view.
     */
    public function render(): View
    {
        return view('livewire.logout');
    }
}
