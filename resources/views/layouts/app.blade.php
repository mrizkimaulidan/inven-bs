<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" />
    <title>{{ $title ?? config('app.name') }} &mdash; {{ config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('modules/bootstrap/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('modules/fontawesome/css/all.min.css') }}" />

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/components.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}" />

    @stack('styles')
    @livewireStyles
</head>

<body>
    @php
        $currentUser = auth()->user();
        $userName = is_string($currentUser?->name) && trim($currentUser->name) !== ''
            ? trim($currentUser->name)
            : 'Pengguna';
        $appName = (string) config('app.name');
        $shortAppName = \Illuminate\Support\Str::take($appName, 2);
    @endphp

    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>

            <nav class="navbar navbar-expand-lg main-navbar">
                <ul class="navbar-nav mr-auto">
                    <li>
                        <a href="#" data-toggle="sidebar" class="nav-link nav-link-lg" aria-label="Toggle sidebar">
                            <i class="fas fa-bars" aria-hidden="true"></i>
                        </a>
                    </li>
                </ul>

                <ul class="navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                            <img
                                alt="Foto profil {{ $userName }}"
                                src="{{ asset('img/avatar/avatar-1.png') }}"
                                class="rounded-circle mr-1"
                            />
                            <div class="d-sm-none d-lg-inline-block">Halo, {{ $userName }}</div>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="{{ route('pengaturan.profil') }}" wire:navigate class="dropdown-item has-icon">
                                <i class="far fa-user" aria-hidden="true"></i> Profil
                            </a>
                            <div class="dropdown-divider"></div>
                            @livewire('logout')
                        </div>
                    </li>
                </ul>
            </nav>

            <div class="main-sidebar sidebar-style-2">
                <aside id="sidebar-wrapper">
                    <div class="sidebar-brand">
                        <a href="{{ route('beranda') }}" wire:navigate>{{ $appName }}</a>
                    </div>
                    <div class="sidebar-brand sidebar-brand-sm">
                        <a href="{{ route('beranda') }}" wire:navigate>{{ $shortAppName }}</a>
                    </div>

                    <ul class="sidebar-menu">
                        <li class="menu-header">Beranda</li>
                        <li @class(['active' => request()->routeIs('beranda')])>
                            <a wire:navigate class="nav-link" href="{{ route('beranda') }}">
                                <i class="fas fa-house" aria-hidden="true"></i>
                                <span>Beranda</span>
                            </a>
                        </li>

                        <li class="menu-header">Manajemen</li>
                        @can('lihat barang')
                            <li @class(['active' => request()->routeIs('barang.*')])>
                                <a wire:navigate class="nav-link" href="{{ route('barang.index') }}">
                                    <i class="fas fa-boxes-stacked" aria-hidden="true"></i>
                                    <span>Data Barang</span>
                                </a>
                            </li>
                        @endcan
                        @can('lihat perolehan')
                            <li @class(['active' => request()->routeIs('perolehan.*')])>
                                <a wire:navigate class="nav-link" href="{{ route('perolehan.index') }}">
                                    <i class="fas fa-hand-holding" aria-hidden="true"></i>
                                    <span>Data Perolehan</span>
                                </a>
                            </li>
                        @endcan
                        @can('lihat ruangan')
                            <li @class(['active' => request()->routeIs('ruangan.*')])>
                                <a wire:navigate class="nav-link" href="{{ route('ruangan.index') }}">
                                    <i class="fas fa-map-location-dot" aria-hidden="true"></i>
                                    <span>Data Ruangan</span>
                                </a>
                            </li>
                        @endcan
                        @can('lihat merek')
                            <li @class(['active' => request()->routeIs('merek.*')])>
                                <a wire:navigate class="nav-link" href="{{ route('merek.index') }}">
                                    <i class="fas fa-tag" aria-hidden="true"></i>
                                    <span>Data Merek</span>
                                </a>
                            </li>
                        @endcan
                        @can('lihat bahan')
                            <li @class(['active' => request()->routeIs('bahan.*')])>
                                <a wire:navigate class="nav-link" href="{{ route('bahan.index') }}">
                                    <i class="fas fa-cube" aria-hidden="true"></i>
                                    <span>Data Bahan</span>
                                </a>
                            </li>
                        @endcan
                        @can('lihat pengguna')
                            <li @class(['active' => request()->routeIs('pengguna.*')])>
                                <a wire:navigate class="nav-link" href="{{ route('pengguna.index') }}">
                                    <i class="fas fa-users" aria-hidden="true"></i>
                                    <span>Data Pengguna</span>
                                </a>
                            </li>
                        @endcan

                        <li class="menu-header">Pengaturan</li>
                        <li @class(['active' => request()->routeIs('pengaturan.profil')])>
                            <a wire:navigate class="nav-link" href="{{ route('pengaturan.profil') }}">
                                <i class="fas fa-gear" aria-hidden="true"></i>
                                <span>Pengaturan Profil</span>
                            </a>
                        </li>
                        @can('lihat peran')
                            <li @class(['active' => request()->routeIs('peran-dan-hak-akses.*')])>
                                <a wire:navigate class="nav-link" href="{{ route('peran-dan-hak-akses.index') }}">
                                    <i class="fas fa-user-shield" aria-hidden="true"></i>
                                    <span>Peran &amp; Hak Akses</span>
                                </a>
                            </li>
                        @endcan
                        @can('lihat log aktivitas')
                            <li @class(['active' => request()->routeIs('log-aktivitas.*')])>
                                <a wire:navigate class="nav-link" href="{{ route('log-aktivitas.index') }}">
                                    <i class="fas fa-clock-rotate-left" aria-hidden="true"></i>
                                    <span>Log Aktivitas</span>
                                </a>
                            </li>
                        @endcan
                    </ul>

                    <div class="hide-sidebar-mini mt-4 mb-4 p-3">
                        @livewire('logout', ['placement' => 'sidebar'])
                    </div>
                </aside>
            </div>

            <div class="main-content">
                <section class="section">
                    <div class="section-header">
                        <h1>{{ $title ?? $appName }}</h1>
                    </div>

                    {{ $slot }}
                </section>
            </div>

            <footer class="main-footer">
                <div class="footer-left">
                    Copyright &copy; {{ now()->year }}
                    <div class="bullet"></div>
                    {{ $appName }}
                </div>
                <div class="footer-right"></div>
            </footer>
        </div>
    </div>

    @livewireScripts

    <!-- General JS Scripts -->
    <script src="{{ asset('modules/jquery.min.js') }}" data-navigate-once></script>
    <script src="{{ asset('modules/popper.js') }}" data-navigate-once></script>
    <script src="{{ asset('modules/tooltip.js') }}" data-navigate-once></script>
    <script src="{{ asset('modules/bootstrap/js/bootstrap.min.js') }}" data-navigate-once></script>
    <script src="{{ asset('modules/nicescroll/jquery.nicescroll.min.js') }}" data-navigate-once></script>
    <script src="{{ asset('modules/moment.min.js') }}" data-navigate-once></script>
    <script src="{{ asset('js/stisla.js') }}" data-navigate-once></script>

    <!-- JS Libraies -->
    <script src="{{ asset('modules/chart.min.js') }}" data-navigate-once></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/index-0.js') }}" data-navigate-once></script>

    <!-- Template JS File -->
    <script src="{{ asset('js/scripts.js') }}" data-navigate-once></script>
    <script src="{{ asset('js/custom.js') }}" data-navigate-once></script>

    @stack('scripts')
</body>
</html>
