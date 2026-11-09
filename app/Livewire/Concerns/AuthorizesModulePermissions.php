<?php

namespace App\Livewire\Concerns;

use Illuminate\Support\Facades\Gate;

trait AuthorizesModulePermissions
{
    /**
     * Authorize an action for the given module.
     */
    protected function authorizeModuleAction(string $action, string $module): void
    {
        Gate::authorize("{$action} {$module}");
    }
}
