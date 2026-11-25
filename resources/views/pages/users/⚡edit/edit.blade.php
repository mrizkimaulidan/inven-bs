@php
    $roleOptions = $this->roles ?? collect();
@endphp

<div>
    <x-modal title="Ubah Data Pengguna" submit="edit">
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
                type="email"
                name="form.email"
                label="Alamat Email"
                placeholder="Masukkan alamat email"
                required
            />

            <x-select name="form.role_id" label="Pilih Peran" wire:model="form.role_id" required>
                <option value="">Pilih Peran</option>
                @foreach ($roleOptions as $role)
                    <option value="{{ $role->id }}" wire:key="role-option-{{ $role->id }}">{{ $role->name }}</option>
                @endforeach
            </x-select>

            <x-input
                wire:model="form.password"
                type="password"
                name="form.password"
                label="Kata Sandi"
                placeholder="Masukkan kata sandi"
            />

            <x-input
                wire:model="form.password_confirmation"
                type="password"
                name="form.password_confirmation"
                label="Konfirmasi Kata Sandi"
                placeholder="Konfirmasi kata sandi"
            />
        </x-slot:body>

        <x-slot:footer>
            <x-button
                type="submit"
                icon="fa-save"
                label="Simpan Perubahan"
                class="btn-primary"
                wire:loading.attr="disabled"
                wire:target="edit"
            />
        </x-slot:footer>
    </x-modal>
</div>
