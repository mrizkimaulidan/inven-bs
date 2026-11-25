<div>
    <div class="row">
        <div class="col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4 col-12">
            <div class="card card-primary">
                <div class="card-header"><h4>Masuk</h4></div>

                <div class="card-body">
                    <form wire:submit="authenticate">
                        <x-input
                            wire:model="form.email"
                            type="email"
                            name="form.email"
                            label="Alamat Email"
                            placeholder="Masukkan alamat email"
                            autocomplete="email"
                            required
                            autofocus
                        />

                        <x-input
                            wire:model="form.password"
                            type="password"
                            name="form.password"
                            label="Kata Sandi"
                            placeholder="Masukkan kata sandi"
                            autocomplete="current-password"
                            required
                        />

                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input
                                    type="checkbox"
                                    wire:model="form.remember"
                                    name="form.remember"
                                    class="custom-control-input"
                                    tabindex="3"
                                    id="remember-me"
                                />
                                <label class="custom-control-label" for="remember-me">Ingat saya</label>
                            </div>
                        </div>

                        <div class="form-group mb-0">
                            <button
                                type="submit"
                                class="btn btn-primary btn-lg btn-block"
                                tabindex="4"
                                wire:loading.attr="disabled"
                                wire:target="authenticate"
                            >
                                <span wire:loading.remove wire:target="authenticate">Masuk</span>
                                <span wire:loading wire:target="authenticate">Memproses...</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="simple-footer">Copyright &copy; {{ now()->year }} {{ config('app.name') }}</div>
        </div>
    </div>
</div>
