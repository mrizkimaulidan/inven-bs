<?php

use App\Livewire\Forms\StoreRoleAndPermissionForm;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Spatie\Permission\Models\Permission;

/**
 * Group permissions, synchronize selection state, and save the role.
 */
new class extends Component
{
    /**
     * The form instance.
     */
    public StoreRoleAndPermissionForm $form;

    /**
     * Per-module select-all state keyed by module slug.
     *
     * @var array<string, bool>
     */
    public array $selectAll = [
        'barang' => false,
        'perolehan' => false,
        'ruangan' => false,
        'merek' => false,
        'bahan' => false,
        'pengguna' => false,
        'peran' => false,
        'log aktivitas' => false,
    ];

    /**
     * Module display metadata (label and icon).
     *
     * @var array<string, array{label: string, icon: string}>
     */
    private const MODULE_META = [
        'barang' => ['label' => 'Barang', 'icon' => 'fa-boxes-stacked'],
        'perolehan' => ['label' => 'Perolehan', 'icon' => 'fa-hand-holding'],
        'ruangan' => ['label' => 'Ruangan', 'icon' => 'fa-map-location-dot'],
        'merek' => ['label' => 'Merek', 'icon' => 'fa-tag'],
        'bahan' => ['label' => 'Bahan', 'icon' => 'fa-cube'],
        'pengguna' => ['label' => 'Pengguna', 'icon' => 'fa-users'],
        'peran' => ['label' => 'Peran & Hak Akses', 'icon' => 'fa-user-shield'],
        'log aktivitas' => ['label' => 'Log Aktivitas', 'icon' => 'fa-history'],
    ];

    /**
     * Action display metadata (label, icon, and badge color).
     *
     * @var array<string, array{label: string, icon: string, badge: string}>
     */
    private const ACTION_META = [
        'tambah' => ['label' => 'Tambah', 'icon' => 'fa-plus', 'badge' => 'success'],
        'ubah' => ['label' => 'Ubah', 'icon' => 'fa-pen', 'badge' => 'warning'],
        'hapus' => ['label' => 'Hapus', 'icon' => 'fa-trash', 'badge' => 'danger'],
        'lihat' => ['label' => 'Lihat', 'icon' => 'fa-eye', 'badge' => 'primary'],
        'detail' => ['label' => 'Detail', 'icon' => 'fa-info-circle', 'badge' => 'info'],
        'impor' => ['label' => 'Impor', 'icon' => 'fa-download', 'badge' => 'secondary'],
        'ekspor' => ['label' => 'Ekspor', 'icon' => 'fa-upload', 'badge' => 'secondary'],
        'print' => ['label' => 'Print', 'icon' => 'fa-print', 'badge' => 'dark'],
    ];

    /**
     * Get permissions assigned or available to the current user.
     *
     * @return Collection<int, Permission>
     */
    #[Computed]
    public function permissions(): Collection
    {
        $user = auth()->user();

        if (! $user) {
            return new Collection;
        }

        $permissionNames = $user->getAllPermissions()->pluck('name')->all();

        if ($permissionNames === []) {
            return new Collection;
        }

        return Permission::query()
            ->whereIn('name', $permissionNames)
            ->get();
    }

    /**
     * Get the total number of permissions available.
     */
    #[Computed]
    public function totalPermissions(): int
    {
        return $this->permissions->count();
    }

    /**
     * Get all permissions grouped by module with resolved action metadata.
     *
     * @return array<int, array{
     *     key: string,
     *     label: string,
     *     icon: string,
     *     permissions: array<int, array{
     *         id: int,
     *         name: string,
     *         label: string,
     *         icon: string,
     *         badge: string
     *     }>
     * }>
     */
    #[Computed]
    public function groupedPermissions(): array
    {
        $permissionsByModule = [];

        foreach ($this->permissions as $permission) {
            [$actionKey, $moduleKey] = array_pad(explode(' ', (string) $permission->name, 2), 2, '');
            $actionKey = strtolower(trim($actionKey));
            $moduleKey = strtolower(trim($moduleKey));

            if (! isset($permissionsByModule[$moduleKey])) {
                $permissionsByModule[$moduleKey] = [
                    'key' => $moduleKey,
                    'label' => self::MODULE_META[$moduleKey]['label'] ?? ucfirst($moduleKey),
                    'icon' => self::MODULE_META[$moduleKey]['icon'] ?? 'fa-key',
                    'permissions' => [],
                ];
            }

            $permissionsByModule[$moduleKey]['permissions'][] = [
                'id' => (int) $permission->id,
                'name' => (string) $permission->name,
                'label' => self::ACTION_META[$actionKey]['label'] ?? ucfirst($actionKey),
                'icon' => self::ACTION_META[$actionKey]['icon'] ?? 'fa-key',
                'badge' => self::ACTION_META[$actionKey]['badge'] ?? 'secondary',
            ];
        }

        return array_values($permissionsByModule);
    }

    /**
     * Get the number of currently selected permissions.
     */
    #[Computed]
    public function selectedPermissionsCount(): int
    {
        return count($this->form->permissions ?? []);
    }

    /**
     * Handle updates to a module select-all checkbox.
     */
    public function updatedSelectAll(mixed $value, ?string $key = null): void
    {
        if (blank($key)) {
            return;
        }

        $moduleData = collect($this->groupedPermissions)->firstWhere('key', $key);

        if (! $moduleData) {
            return;
        }

        $modulePermissionNames = array_column($moduleData['permissions'], 'name');
        $selectedPermissionNames = $this->form->permissions ?? [];

        if ((bool) $value) {
            $this->form->permissions = array_values(array_unique(array_merge($selectedPermissionNames, $modulePermissionNames)));
        } else {
            $this->form->permissions = array_values(array_diff($selectedPermissionNames, $modulePermissionNames));
        }
    }

    /**
     * Sync module select-all state after individual permission changes.
     */
    public function updatedFormPermissions(): void
    {
        $selectedPermissionNames = $this->form->permissions ?? [];

        foreach ($this->groupedPermissions as $moduleData) {
            $modulePermissionNames = array_column($moduleData['permissions'], 'name');
            $this->selectAll[$moduleData['key']] = count(array_diff($modulePermissionNames, $selectedPermissionNames)) === 0;
        }
    }

    /**
     * Select all available permissions.
     */
    public function selectAllPermissions(): void
    {
        $this->form->permissions = $this->permissions->pluck('name')->all();

        foreach (array_keys($this->selectAll) as $moduleKey) {
            $this->selectAll[$moduleKey] = true;
        }
    }

    /**
     * Reset all selected permissions.
     */
    public function resetPermissions(): void
    {
        $this->form->permissions = [];

        foreach (array_keys($this->selectAll) as $moduleKey) {
            $this->selectAll[$moduleKey] = false;
        }
    }

    /**
     * Persist the new role along with its assigned permissions.
     */
    public function save(): void
    {
        $this->form->store();

        session()->flash('success', 'Peran berhasil ditambahkan.');

        $this->redirect(route('peran-dan-hak-akses.index'), navigate: true);
    }
};
