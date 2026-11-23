<?php

use App\Models\AuditLog;
use Livewire\Component;

new class extends Component
{
    /**
     * The audit log being displayed.
     */
    public ?AuditLog $auditLog = null;

    /**
     * Load the selected audit log.
     *
     * @param  int  $auditLogId
     * @return void
     */
    public function mount(int $auditLogId): void
    {
        $this->auditLog = AuditLog::findOrFail($auditLogId);
    }
};
