<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Verifikasi Barang')</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('modules/bootstrap/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('modules/fontawesome/css/all.min.css') }}" />

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/components.css') }}" />

    @stack('styles')
</head>
<body class="bg-light">
    <div class="container py-4" style="max-width: 520px">
        @yield('content')
    </div>

    @stack('scripts')
</body>
</html>
