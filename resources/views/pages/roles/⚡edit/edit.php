<?php

declare(strict_types=1);

use App\Livewire\Forms\UpdateRoleAndPermissionForm;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

/**
 * Load a role, synchronize permission selection, and save its changes.
 */
new #[Title('Halaman Ubah Data Peran & Hak Akses')] class extends Component
{
    /**
     * The role being updated.
     */
    public Role $role;

    /**
     * The form instance.
     */
    public UpdateRoleAndPermissionForm $form;

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
    ];

    /**
     * Module display metadata (label & icon).
     *
     * @var array<string, array{label: string, icon: string}>
     */
    private const MODULE_META = [
        'barang' => ['label' => 'Barang',    'icon' => 'fa-boxes-stacked'],
        'perolehan' => ['label' => 'Perolehan', 'icon' => 'fa-hand-holding'],
        'ruangan' => ['label' => 'Ruangan',   'icon' => 'fa-map-location-dot'],
        'merek' => ['label' => 'Merek',     'icon' => 'fa-tag'],
        'bahan' => ['label' => 'Bahan',     'icon' => 'fa-cube'],
        'pengguna' => ['label' => 'Pengguna',  'icon' => 'fa-users'],
    ];

    /**
     * Action display metadata (label, icon & badge color).
     *
     * @var array<string, array{label: string, icon: string, badge: string}>
     */
    private const ACTION_META = [
        'tambah' => ['label' => 'Tambah', 'icon' => 'fa-plus',        'badge' => 'badge-success'],
        'ubah' => ['label' => 'Ubah',   'icon' => 'fa-pen',         'badge' => 'badge-warning'],
        'hapus' => ['label' => 'Hapus',  'icon' => 'fa-trash',       'badge' => 'badge-danger'],
        'lihat' => ['label' => 'Lihat',  'icon' => 'fa-eye',         'badge' => 'badge-primary'],
        'detail' => ['label' => 'Detail', 'icon' => 'fa-info-circle', 'badge' => 'badge-info'],
        'impor' => ['label' => 'Impor',  'icon' => 'fa-download',    'badge' => 'badge-secondary'],
        'ekspor' => ['label' => 'Ekspor', 'icon' => 'fa-upload',      'badge' => 'badge-secondary'],
        'print' => ['label' => 'Print',  'icon' => 'fa-print',       'badge' => 'badge-dark'],
    ];

    /**
     * Load the role and populate its current name and permissions.
     *
     * @param  Role  $role
     * @return void
     */
    public function mount(Role $role): void
    {
        $this->role = $role;

        $this->form->fill([
            'role' => $role,
            'name' => $role->name,
            'permissions' => $role->permissions->pluck('name')->toArray(),
        ]);

        $this->updatedFormPermissions();
    }

    /**
     * Get all permissions from the database.
     *
     * @return Collection<int, Permission>
     */
    #[Computed]
    public function permissions(): Collection
    {
        return Permission::all();
    }

    /**
     * Get the total number of permissions available.
     *
     * @return int
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
            [$actionKey, $moduleKey] = array_pad(explode(' ', $permission->name, 2), 2, '');
            $actionKey = strtolower($actionKey);
            $moduleKey = strtolower($moduleKey);

            if (! isset($permissionsByModule[$moduleKey])) {
                $permissionsByModule[$moduleKey] = [
                    'key' => $moduleKey,
                    'label' => self::MODULE_META[$moduleKey]['label'] ?? ucfirst($moduleKey),
                    'icon' => self::MODULE_META[$moduleKey]['icon'] ?? 'fa-key',
                    'permissions' => [],
                ];
            }

            $permissionsByModule[$moduleKey]['permissions'][] = [
                'id' => $permission->id,
                'name' => $permission->name,
                'label' => self::ACTION_META[$actionKey]['label'] ?? ucfirst($actionKey),
                'icon' => self::ACTION_META[$actionKey]['icon'] ?? 'fa-key',
                'badge' => self::ACTION_META[$actionKey]['badge'] ?? 'badge-secondary',
            ];
        }

        return array_values($permissionsByModule);
    }

    /**
     * Get the number of currently selected permissions.
     *
     * @return int
     */
    #[Computed]
    public function selectedPermissionsCount(): int
    {
        return count($this->form->permissions);
    }

    /**
     * Handle updates to a module select-all checkbox.
     *
     * @param  mixed  $value
     * @param  string  $key
     * @return void
     */
    public function updatedSelectAll(mixed $value, string $key): void
    {
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
     *
     * @return void
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
     *
     * @return void
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
     *
     * @return void
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
     *
     * @return void
     */
    public function save(): void
    {
        $this->form->update();

        $this->redirect('/peran-dan-hak-akses', navigate: true);
    }
};
