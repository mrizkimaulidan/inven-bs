<?php

declare(strict_types=1);

use App\Livewire\Forms\UpdateRoleAndPermissionForm;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

new #[Title('Halaman Ubah Data Peran & Hak Akses')] class extends Component
{
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
     * Mount the component.
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
        $grouped = [];

        foreach ($this->permissions as $permission) {
            [$actionKey, $moduleKey] = array_pad(explode(' ', $permission->name, 2), 2, '');
            $actionKey = strtolower($actionKey);
            $moduleKey = strtolower($moduleKey);

            if (! isset($grouped[$moduleKey])) {
                $grouped[$moduleKey] = [
                    'key' => $moduleKey,
                    'label' => self::MODULE_META[$moduleKey]['label'] ?? ucfirst($moduleKey),
                    'icon' => self::MODULE_META[$moduleKey]['icon'] ?? 'fa-key',
                    'permissions' => [],
                ];
            }

            $grouped[$moduleKey]['permissions'][] = [
                'id' => $permission->id,
                'name' => $permission->name,
                'label' => self::ACTION_META[$actionKey]['label'] ?? ucfirst($actionKey),
                'icon' => self::ACTION_META[$actionKey]['icon'] ?? 'fa-key',
                'badge' => self::ACTION_META[$actionKey]['badge'] ?? 'badge-secondary',
            ];
        }

        return array_values($grouped);
    }

    /**
     * Get the number of currently selected permissions.
     */
    #[Computed]
    public function selectedPermissionsCount(): int
    {
        return count($this->form->permissions);
    }

    /**
     * Handle updates to a module select-all checkbox.
     */
    public function updatedSelectAll(mixed $value, string $key): void
    {
        $module = collect($this->groupedPermissions)->firstWhere('key', $key);

        if (! $module) {
            return;
        }

        $names = array_column($module['permissions'], 'name');
        $current = $this->form->permissions ?? [];

        if ((bool) $value) {
            $this->form->permissions = array_values(array_unique(array_merge($current, $names)));
        } else {
            $this->form->permissions = array_values(array_diff($current, $names));
        }
    }

    /**
     * Sync module select-all state after individual permission changes.
     */
    public function updatedFormPermissions(): void
    {
        $current = $this->form->permissions ?? [];

        foreach ($this->groupedPermissions as $module) {
            $names = array_column($module['permissions'], 'name');
            $this->selectAll[$module['key']] = count(array_diff($names, $current)) === 0;
        }
    }

    /**
     * Select all available permissions.
     */
    public function selectAllPermissions(): void
    {
        $this->form->permissions = $this->permissions->pluck('name')->all();

        foreach ($this->selectAll as $key => $value) {
            $this->selectAll[$key] = true;
        }
    }

    /**
     * Reset all selected permissions.
     */
    public function resetPermissions(): void
    {
        $this->form->permissions = [];

        foreach ($this->selectAll as $key => $value) {
            $this->selectAll[$key] = false;
        }
    }

    /**
     * Persist the new role along with its assigned permissions.
     */
    public function save(): void
    {
        $this->form->update();

        $this->redirect('/peran-dan-hak-akses', navigate: true);
    }
};
