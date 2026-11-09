<?php

namespace App\Livewire\Concerns;

use Livewire\Attributes\On;

/**
 * Handle modal state management.
 */
trait WithModal
{
    use AuthorizesModulePermissions;

    /**
     * The currently active modal identifier.
     */
    public ?string $activeModal = null;

    /**
     * The parameters to pass to the modal.
     */
    public ?array $modalParams = null;

    /**
     * Open the modal with the given name and parameters.
     *
     * @param  string  $modalName
     * @param  array<string, mixed>|null  $params
     * @return void
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

        $this->authorizeModuleAction($action, $this->bulkPermissionModule());

        $this->activeModal = $modalName;
        $this->modalParams = $params;
    }

    /**
     * Close the active modal.
     *
     * @return void
     */
    #[On('closeModal')]
    public function closeModal(): void
    {
        $this->activeModal = null;
        $this->modalParams = null;
    }
}
