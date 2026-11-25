<?php

namespace App\Livewire\Concerns;

use Illuminate\Support\Facades\Gate;

/**
 * Provide helper methods for authorizing module-scoped permissions in Livewire components.
 */
trait AuthorizesModulePermissions
{
    /**
     * Authorize an action for the given module or throw an authorization exception.
     */
    protected function authorizeModuleAction(string $action, string $module): void
    {
        Gate::authorize($this->formatModulePermission($action, $module));
    }

    /**
     * Determine whether the current user is allowed to perform an action on a module.
     */
    protected function canModuleAction(string $action, string $module): bool
    {
        return Gate::allows($this->formatModulePermission($action, $module));
    }

    /**
     * Build a normalized permission name in "<action> <module>" format.
     */
    private function formatModulePermission(string $action, string $module): string
    {
        return trim(trim($action).' '.trim($module));
    }
}
