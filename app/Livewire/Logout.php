<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

/**
 * Handle user logout.
 */
class Logout extends Component
{
    /**
     * The logout button placement.
     */
    public string $placement = 'dropdown';

    /**
     * Log out the user and invalidate the session.
     *
     * @return void
     */
    public function logout(): void
    {
        Auth::logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        $this->redirectRoute('login');
    }

    public function render()
    {
        return view('livewire.logout');
    }
}
