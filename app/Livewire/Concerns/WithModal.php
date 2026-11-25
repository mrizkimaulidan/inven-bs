<?php

namespace App\Livewire\Concerns;

use Livewire\Attributes\On;
use LogicException;

/**
 * Handle modal state and permission checks in Livewire components.
 */
trait WithModal
{
    use AuthorizesModulePermissions;

    /**
     * The currently active modal identifier.
     */
    public ?string $activeModal = null;

    /**
     * The parameters passed to the active modal.
     *
     * @var array<string, mixed>|null
     */
    public ?array $modalParams = null;

    /**
     * Resolve the permission module name used when opening a modal.
     */
    protected function modalPermissionModule(): string
    {
        if (method_exists($this, 'bulkPermissionModule')) {
            return $this->bulkPermissionModule();
        }

        throw new LogicException('The modal permission module must be defined by the consuming component.');
    }

    /**
     * Open the modal with the given name and optional parameters after authorization.
     *
     * @param  array<string, mixed>|null  $params
     */
    #[On('showModal')]
    public function showModal(string $modalName, ?array $params = null): void
    {
        $action = match ($modalName) {
            'create' => 'tambah',
            'edit' => 'ubah',
            'show', 'qrcode' => 'detail',
            'import' => 'impor',
            'export' => 'ekspor',
            'bulk-destroy' => 'hapus',
            default => abort(404),
        };

        $this->authorizeModuleAction($action, $this->modalPermissionModule());

        $this->activeModal = $modalName;
        $this->modalParams = $params;
    }

    /**
     * Close the active modal and clear its parameters.
     */
    #[On('closeModal')]
    public function closeModal(): void
    {
        $this->activeModal = null;
        $this->modalParams = null;
    }
}
