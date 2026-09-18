<div
    class="modal fade show d-block"
    id="exportModal"
    tabindex="-1"
    role="dialog"
    style="display: block; background: rgba(0, 0, 0, 0.5)"
    data-backdrop="static"
>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form wire:submit="edit">
                <div class="modal-header">
                    <h5 class="modal-title">Ubah Data Ruangan</h5>
                    <button wire:click="$dispatch('closeModal')" type="button" class="close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <x-input
                        wire:model="form.name"
                        name="form.name"
                        label="Nama Ruangan"
                        placeholder="Masukkan nama ruangan"
                        required
                    />

                    <x-textarea
                        wire:model="form.description"
                        label="Deskripsi Ruangan"
                        placeholder="Masukan deskripsi ruangan (opsional)"
                        name="form.description"
                    />
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <x-button wire:click="$dispatch('closeModal')" class="btn-secondary" label="Tutup" />
                    <x-button type="submit" icon="fa-plus-circle" label="Simpan Data" class="btn-primary" />
                </div>
            </form>
        </div>
    </div>
</div>
