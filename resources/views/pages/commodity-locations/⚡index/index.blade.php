<div>
    {{-- Main Card --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {{-- Toolbar: Action Buttons --}}
                    <div class="d-flex justify-content-between align-items-center flex-wrap pb-3">
                        <div class="d-flex flex-wrap">
                            <x-button icon="fa-file-import" label="Import" class="btn-success mr-2 mb-2" />
                            <x-button
                                wire:click="$dispatch('showModal', {modalName: 'export'})"
                                icon="fa-file-export"
                                label="Export"
                                class="btn-info mr-2 mb-2"
                            />
                            <x-button icon="fa-trash-alt" label="Hapus Terpilih" class="btn-danger mr-2 mb-2" />
                            <x-button icon="fa-print" label="Print" class="btn-secondary mr-2 mb-2" />
                            <x-button
                                wire:click="$refresh"
                                icon="fa-sync-alt"
                                label="Refresh"
                                class="btn-light mb-2"
                                data-toggle="tooltip"
                                title="Refresh"
                            />
                        </div>
                        <a wire:navigate href="/lokasi/tambah" class="btn btn-primary mb-2">
                            <i class="fas fa-plus-circle"></i>
                            Tambah Data
                        </a>
                    </div>

                    {{-- Table --}}
                    <x-table :targets="['']" :paginator="$this->commodityLocations">
                        <x-slot:thead>
                            <tr>
                                <th class="text-center" style="width: 40px">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="checkbox-all" />
                                        <label for="checkbox-all" class="custom-control-label">&nbsp;</label>
                                    </div>
                                </th>
                                <th>Ruang</th>
                                <th>Deskripsi</th>
                            </tr>
                        </x-slot:thead>

                        <x-slot:tbody>
                            @forelse ($this->commodityLocations as $location)
                                <tr wire:key="location-{{ $location->id }}">
                                    {{-- Checkbox --}}
                                    <td class="text-center align-middle" style="width: 40px">
                                        <div class="custom-control custom-checkbox">
                                            <input
                                                type="checkbox"
                                                class="custom-control-input"
                                                id="checkbox-{{ $location->id }}"
                                                wire:model.live="selected"
                                                value="{{ $location->id }}"
                                            />
                                            <label for="checkbox-{{ $location->id }}" class="custom-control-label"
                                                >&nbsp;</label>
                                        </div>
                                    </td>

                                    {{-- Ruang --}}
                                    <td class="py-3 align-middle">
                                        <div class="font-weight-bold mb-2">{{ $location->name }}</div>

                                        <div class="d-flex align-items-center mb-3 flex-wrap">
                                            <x-badge
                                                :label="$location->commodities_count"
                                                icon="fa-boxes-alt"
                                                class="badge-primary mr-1"
                                            />

                                            <x-badge
                                                :label="$location->good_conditions_count"
                                                icon="fa-check-circle"
                                                class="badge-success mr-1"
                                            />

                                            <x-badge
                                                :label="$location->poor_conditions_count"
                                                icon="fa-exclamation-circle"
                                                class="badge-warning mr-1"
                                            />

                                            <x-badge
                                                :label="$location->heavily_damaged_conditions_count"
                                                icon="fa-circle-xmark"
                                                class="badge-danger"
                                            />
                                        </div>

                                        <div class="table-links">
                                            <a
                                                href="#"
                                                class="btn btn-sm btn-outline-dark"
                                                data-toggle="tooltip"
                                                data-placement="top"
                                                title="QR Code"
                                            >
                                                <i class="fas fa-qrcode"></i>
                                            </a>
                                            <a
                                                href="#"
                                                class="btn btn-sm btn-outline-info"
                                                data-toggle="tooltip"
                                                data-placement="top"
                                                title="Detail"
                                            >
                                                <i class="fas fa-search"></i>
                                            </a>
                                            <a
                                                href="#"
                                                class="btn btn-sm btn-outline-success"
                                                data-toggle="tooltip"
                                                data-placement="top"
                                                title="Ubah"
                                            >
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a
                                                href="#"
                                                class="btn btn-sm btn-outline-secondary"
                                                data-toggle="tooltip"
                                                data-placement="top"
                                                title="Print"
                                            >
                                                <i class="fas fa-print"></i>
                                            </a>
                                            <a
                                                href="#"
                                                class="btn btn-sm btn-outline-danger"
                                                data-toggle="tooltip"
                                                data-placement="top"
                                                title="Hapus"
                                            >
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>

                                    {{-- Deskripsi --}}
                                    <td class="py-3 align-middle">
                                        <span class="text-muted">{{ $location->description ?: '—' }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <x-empty-state :search="$this->search" colspan="3" />
                                </tr>
                            @endforelse
                        </x-slot:tbody>
                    </x-table>
                </div>
            </div>
        </div>
    </div>
</div>
