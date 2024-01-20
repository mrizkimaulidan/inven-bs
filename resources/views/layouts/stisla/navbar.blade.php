<ul class="navbar-nav navbar-right">
	<li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
			<img alt="image" src="../assets/img/avatar/avatar-1.png" class="rounded-circle mr-1">
			<div class="d-sm-none d-lg-inline-block">Halo, {{ auth()->user()->name }}</div>
		</a>
		<div class="dropdown-menu dropdown-menu-right">
			<div class="dropdown-title">Akun sejak: {{ auth()->user()->diffForHumanDate(auth()->user()->created_at) }}</div>
			<a href="{{ route('profile.index') }}" class="dropdown-item has-icon">
				<i class="fas fa-cog"></i> Pengaturan Profil
			</a>
			<div class="dropdown-divider"></div>
			{{-- <a class="dropdown-item has-icon text-danger" href="{{ route('logout') }}">
				<i class="fas fa-sign-out-alt"></i>
				{{ __('Logout') }}
			</a> --}}
			<form id="logout-form" action="{{ route('logout') }}" method="POST">
				@csrf


				<button type="submit" class="dropdown-item has-icon btn-link text-danger logout">
					Logout
				</button>
			</form>
		</div>
	</li>
</ul>
</nav>
