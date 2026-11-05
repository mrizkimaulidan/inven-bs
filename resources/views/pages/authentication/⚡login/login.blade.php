<div>
    <div class="row">
        <div class="col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4 col-12">
            <div class="login-brand">
                <img src="assets/img/stisla-fill.svg" alt="logo" width="100" class="shadow-light rounded-circle" />
            </div>

            <div class="card card-primary">
                <div class="card-header"><h4>Masuk</h4></div>

                <div class="card-body">
                    <form wire:submit="authenticate">
                        <div class="form-group">
                            <label for="form.email">Alamat Email</label>
                            <x-input
                                wire:model="form.email"
                                type="email"
                                name="form.email"
                                placeholder="Masukkan alamat email"
                                autocomplete="email"
                                required
                                autofocus
                            />
                        </div>

                        <div class="form-group">
                            <div class="d-block">
                                <label for="form.password" class="control-label">Kata Sandi</label>
                                <div class="float-right">
                                    <a href="auth-forgot-password.html" class="text-small">Lupa kata sandi?</a>
                                </div>
                            </div>
                            <x-input
                                wire:model="form.password"
                                type="password"
                                name="form.password"
                                placeholder="Masukkan kata sandi"
                                autocomplete="current-password"
                                required
                            />
                        </div>

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

                        <div class="form-group">
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
            <div class="simple-footer">Copyright &copy; Stisla 2018</div>
        </div>
    </div>
</div>
