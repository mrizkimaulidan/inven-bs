<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Buat Akun &mdash; {{ config('app.name') }}</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="{{ url('assets/bootstrap/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ url('assets/fontawesome/css/all.css') }}">

  <!-- Template CSS -->
  <link rel="stylesheet" href="{{ url('assets/css/style.css') }}">
  <link rel="stylesheet" href="{{ url('assets/css/components.css') }}">
</head>

<body>
  <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2">

            <div class="card card-primary">
              <div class="card-header">
                <h4>Buat Akun</h4>
              </div>

              <div class="card-body">
                <form method="POST" action="{{ route('register') }}">
                  @csrf
                  <div class="row">
                    <div class="form-group col-12">
                      <label for="name">Nama Lengkap</label>
                      <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" autofocus>
                    </div>

                    @error('name')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                  </div>

                  <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}">

                    @error('email')
                    <span class=" invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                  </div>

                  <div class="row">
                    <div class="form-group col-6">
                      <label for="password" class="d-block">Password</label>
                      <input id="password" type="password" class="form-control @error('password') is-invalid @enderror pwstrength" data-indicator="pwindicator" name="password">

                      @error('password')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                      @enderror
                      <div id="pwindicator" class="pwindicator">
                        <div class="bar"></div>
                        <div class="label"></div>
                      </div>
                    </div>
                    <div class="form-group col-6">
                      <label for="password_confirmation" class="d-block">Konfirmasi Password</label>
                      <input id="password_confirmation" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation">

                      @error('password_confirmation')
                      <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                      </span>
                      @enderror
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" name="agree" class="custom-control-input" id="agree">
                      <label class="custom-control-label" for="agree">Saya setuju dengan syarat dan ketentuan</label>
                    </div>
                  </div>

                  <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block">
                      Register
                    </button>
                  </div>

                  <div class="mt-5 text-center">
                    Sudah punya akun? <a href="{{ route('login') }}">Login</a>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <!-- General JS Scripts -->
  <script src="{{ url('assets/js/jquery-3.5.1.min.js') }}"></script>
  <script src="{{ url('assets/js/popper.min.js') }}"></script>
  <script src="{{ url('assets/bootstrap/js/bootstrap.min.js') }}"></script>
  <script src="{{ url('assets/js/jquery.nicescroll.min.js') }}"></script>
  <script src="{{ url('assets/js/moment.min.js') }}"></script>
  <script src="{{ url('assets/js/stisla.js') }}"></script>

  <!-- Template JS File -->
  <script src="{{ url('assets/js/scripts.js') }}"></script>
  <script src="{{ url('assets/js/custom.js') }}"></script>

  <!-- Page Specific JS File -->
  <script src="{{ url('assets/js/page/auth-register.js') }}"></script>
</body>

</html>