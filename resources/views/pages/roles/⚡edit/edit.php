<?php

use App\Livewire\Forms\UpdateRoleAndPermissionForm;
use App\Models\Role;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;
use Spatie\Permission\Models\Permission;

/**
 * Load a role, synchronize permission selection, and save its changes.
 */
new #[Title('Halaman Ubah Data Peran & Hak Akses')] class extends Component
{
    /**
     * The role being updated.
     */
    public ?Role $role = null;

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
        'peran' => false,
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
     * Load the role and populate its current name and permissions.
     */
    public function mount(Role $role): void
    {
        $this->role = $role;

        $this->form->fill([
            'role' => $role,
            'name' => $role->name,
            'permissions' => $role->permissions->pluck('name')->all(),
        ]);

        $this->updatedFormPermissions();
    }

    /**
     * Get permissions available to the current user combined with the role's existing permissions.
     *
     * @return Collection<int, Permission>
     */
    #[Computed]
    public function permissions(): Collection
    {
        $userPermissions = auth()->user()?->getAllPermissions()->pluck('name')->all() ?? [];
        $rolePermissions = $this->role?->permissions?->pluck('name')->all() ?? [];

        $assignablePermissions = array_values(array_unique(array_merge(
            $userPermissions,
            $rolePermissions,
        )));

        if ($assignablePermissions === []) {
            return new Collection;
        }

        return Permission::query()
            ->whereIn('name', $assignablePermissions)
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
     * Update the role along with its assigned permissions.
     */
    public function save(): void
    {
        $this->form->update();

        session()->flash('success', 'Peran berhasil diperbarui.');

        $this->redirect(route('peran-dan-hak-akses.index'), navigate: true);
    }
};
