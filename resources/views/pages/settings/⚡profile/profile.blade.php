<div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form wire:submit="edit">
                        {{-- Section: Informasi Akun --}}
                        <h6 class="text-uppercase text-muted font-weight-bold mb-3">
                            <i class="fas fa-user-circle mr-1"></i> Informasi Akun
                        </h6>

                        <div class="row">
                            <div class="col-md-6">
                                <x-input
                                    wire:model="form.name"
                                    name="form.name"
                                    label="Nama Lengkap"
                                    icon="fa-user"
                                    placeholder="Masukkan nama lengkap"
                                    required
                                    autofocus
                                />
                            </div>

                            <div class="col-md-6">
                                <x-input
                                    wire:model.live="form.email"
                                    name="form.email"
                                    type="email"
                                    label="Alamat Email"
                                    icon="fa-envelope"
                                    placeholder="contoh@email.com"
                                    help="Email digunakan untuk login dan notifikasi"
                                    required
                                />
                            </div>
                        </div>

                        <hr class="my-4" />

                        {{-- Section: Ubah Kata Sandi --}}
                        <h6 class="text-uppercase text-muted font-weight-bold mb-3">
                            <i class="fas fa-lock mr-1"></i> Ubah Kata Sandi
                            <small class="text-muted text-lowercase font-weight-normal ml-1">
                                (biarkan kosong jika tidak ingin mengubah)
                            </small>
                        </h6>

                        <div class="row">
                            <div class="col-md-6">
                                <x-input
                                    name="form.current_password"
                                    type="password"
                                    label="Kata Sandi Sekarang"
                                    icon="fa-lock"
                                    placeholder="Masukkan kata sandi sekarang"
                                />
                            </div>

                            <div class="col-md-6">
                                <x-input
                                    name="form.new_password"
                                    type="password"
                                    label="Kata Sandi Baru"
                                    icon="fa-key"
                                    placeholder="Masukkan kata sandi baru"
                                    help="Minimal 8 karakter"
                                />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <x-input
                                    name="form.new_password_confirmation"
                                    type="password"
                                    label="Konfirmasi Kata Sandi Baru"
                                    icon="fa-check-circle"
                                    placeholder="Ulangi kata sandi baru"
                                />
                            </div>
                        </div>

                        <hr class="my-4" />

                        {{-- Actions --}}
                        <div class="d-flex justify-content-between align-items-center flex-wrap pb-3">
                            <div class="d-flex flex-wrap">
                                <a href="/" class="btn btn-outline-secondary mr-2 mb-2">
                                    <i class="fas fa-arrow-left"></i>
                                    Kembali
                                </a>
                                <x-button
                                    type="reset"
                                    icon="fa-rotate-left"
                                    label="Reset"
                                    class="btn-outline-warning mr-2 mb-2"
                                />
                            </div>
                            <x-button type="submit" icon="fa-save" label="Simpan Perubahan" class="btn-primary mb-2" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
