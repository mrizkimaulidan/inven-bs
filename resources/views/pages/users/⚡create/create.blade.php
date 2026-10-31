<div>
    <x-modal title="Tambah Data Pengguna" submit="save">
        <x-slot:body>
            <x-input
                wire:model="form.name"
                name="form.name"
                label="Nama Pengguna"
                placeholder="Masukkan nama pengguna"
                required
            />

            <x-input
                wire:model="form.email"
                name="form.email"
                label="Alamat Email"
                placeholder="Masukkan alamat email"
                required
            />

            <x-select name="form.role_id" label="Pilih Peran" wire:model="form.role_id" required>
                <option value="">Pilih Peran</option>
                @foreach ($this->roles as $role)
                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                @endforeach
            </x-select>

            <x-input
                wire:model="form.password"
                type="password"
                name="form.password"
                label="Kata Sandi"
                placeholder="Masukkan kata sandi"
                required
            />

            <x-input
                wire:model="form.password_confirmation"
                type="password"
                name="form.password_confirmation"
                label="Kata Sandi"
                placeholder="Konfirmasi kata sandi"
                required
            />
        </x-slot:body>

        <x-slot:footer>
            <x-button type="submit" icon="fa-plus-circle" label="Simpan Data" class="btn-primary" />
        </x-slot:footer>
    </x-modal>
</div>
