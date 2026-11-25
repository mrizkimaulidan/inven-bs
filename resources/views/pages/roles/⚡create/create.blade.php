@php
    $selectedCount = (int) ($this->selectedPermissionsCount ?? 0);
    $totalCount = (int) ($this->totalPermissions ?? 0);
    $modules = $this->groupedPermissions ?? [];
@endphp

<div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form wire:submit="save">
                        <div class="row">
                            <div class="col-md-6">
                                <x-input
                                    wire:model="form.name"
                                    name="form.name"
                                    label="Nama Peran"
                                    icon="fa-user-tag"
                                    placeholder="Masukkan nama peran"
                                    help="Contoh: Admin Gudang, Staff IT, dll."
                                    required
                                    autofocus
                                />
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>
                                        <i class="fas fa-check-circle mr-1" aria-hidden="true"></i>
                                        Hak Akses Terpilih
                                    </label>
                                    <div class="bg-light rounded border px-3 py-2">
                                        <div class="font-weight-bold">
                                            <span>{{ $selectedCount }}</span>
                                            / {{ $totalCount }} hak akses dipilih
                                        </div>
                                        <small class="form-text text-muted mb-0">
                                            Centang hak akses yang diberikan ke peran ini.
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex justify-content-end align-items-center mb-3 flex-wrap">
                                    <div>
                                        <button
                                            type="button"
                                            class="btn btn-sm btn-outline-primary mr-1"
                                            wire:click="selectAllPermissions"
                                        >
                                            <i class="fas fa-check-double" aria-hidden="true"></i>
                                            Pilih Semua
                                        </button>
                                        <button
                                            type="button"
                                            class="btn btn-sm btn-outline-secondary"
                                            wire:click="resetPermissions"
                                        >
                                            <i class="fas fa-rotate-left" aria-hidden="true"></i>
                                            Reset Pilihan
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @foreach ($modules as $module)
                            @php
                                $moduleKey = (string) ($module['key'] ?? '');
                                $moduleLabel = (string) ($module['label'] ?? '');
                                $moduleIcon = (string) ($module['icon'] ?? 'fa-key');
                                $modulePermissions = $module['permissions'] ?? [];
                            @endphp

                            <div class="row" wire:key="module-{{ $moduleKey }}">
                                <div class="col-12">
                                    <div class="mb-3">
                                        <div class="d-flex align-items-center mb-2 flex-wrap">
                                            <x-badge
                                                :label="$moduleLabel"
                                                :icon="$moduleIcon"
                                                variant="dark"
                                                class="mr-1 mb-1"
                                            />
                                            <x-badge
                                                :label="(string) count($modulePermissions)"
                                                icon="fa-key"
                                                variant="secondary"
                                                class="mr-2 mb-1"
                                            />
                                            <div class="custom-control custom-checkbox mb-1">
                                                <input
                                                    type="checkbox"
                                                    class="custom-control-input"
                                                    id="select-all-{{ $moduleKey }}"
                                                    wire:model.live="selectAll.{{ $moduleKey }}"
                                                />
                                                <label class="custom-control-label" for="select-all-{{ $moduleKey }}">
                                                    Pilih Semua Modul
                                                </label>
                                            </div>
                                        </div>
                                        <div class="rounded border px-3 py-2">
                                            <div class="row">
                                                @foreach ($modulePermissions as $permission)
                                                    @php
                                                        $permissionId = $permission['id'] ?? '';
                                                        $permissionName = (string) ($permission['name'] ?? '');
                                                        $permissionLabel = (string) ($permission['label'] ?? '');
                                                        $permissionIcon = (string) ($permission['icon'] ?? 'fa-key');
                                                        $permissionBadge = (string) ($permission['badge'] ?? 'secondary');
                                                    @endphp

                                                    <div
                                                        class="col-md-3 col-6 mb-2"
                                                        wire:key="perm-{{ $permissionId }}"
                                                    >
                                                        <div class="custom-control custom-checkbox">
                                                            <input
                                                                type="checkbox"
                                                                class="custom-control-input"
                                                                id="perm-{{ $permissionId }}"
                                                                wire:model.live="form.permissions"
                                                                value="{{ $permissionName }}"
                                                            />
                                                            <label
                                                                class="custom-control-label"
                                                                for="perm-{{ $permissionId }}"
                                                            >
                                                                <x-badge
                                                                    :label="$permissionLabel"
                                                                    :icon="$permissionIcon"
                                                                    :variant="$permissionBadge"
                                                                    class="mb-0"
                                                                />
                                                            </label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        @error('form.permissions')
                            <div class="alert alert-danger mb-3 py-2" role="alert">
                                <i class="fas fa-exclamation-circle mr-1" aria-hidden="true"></i>
                                {{ $message }}
                            </div>
                        @enderror

                        <div class="d-flex justify-content-between align-items-center flex-wrap pb-3">
                            <div class="d-flex flex-wrap">
                                <a
                                    wire:navigate
                                    href="{{ route('peran-dan-hak-akses.index') }}"
                                    class="btn btn-outline-secondary mr-2 mb-2"
                                >
                                    <i class="fas fa-arrow-left" aria-hidden="true"></i>
                                    Kembali
                                </a>
                                <x-button
                                    type="button"
                                    wire:click="resetForm"
                                    icon="fa-rotate-left"
                                    label="Reset"
                                    class="btn-outline-warning mr-2 mb-2"
                                />
                            </div>
                            <x-button
                                type="submit"
                                icon="fa-plus-circle"
                                label="Simpan Data"
                                class="btn-primary mb-2"
                                wire:loading.attr="disabled"
                                wire:target="save"
                            />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
