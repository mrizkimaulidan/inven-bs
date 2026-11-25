@php
    $documentTitle = trim($__env->yieldContent('title', 'Verifikasi Barang'));
    $resolvedTitle = $documentTitle !== '' ? $documentTitle : 'Verifikasi Barang';
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Halaman verifikasi data barang sistem inventaris." />
    <title>{{ $resolvedTitle }}</title>

    <link rel="stylesheet" href="{{ asset('modules/bootstrap/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('modules/fontawesome/css/all.min.css') }}" />

    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/components.css') }}" />

    @stack('styles')
</head>
<body class="bg-light">
    <main class="container py-4" style="max-width: 520px">
        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>
