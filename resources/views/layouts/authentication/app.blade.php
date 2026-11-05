<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport" />
    <title>Login &mdash; Stisla</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('modules/bootstrap/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('modules/fontawesome/css/all.min.css') }}" />

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('modules/bootstrap-social/bootstrap-social.css') }}" />

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/components.css') }}" />

    <body>
        <div id="app">
            <section class="section">
                <div class="container mt-5">{{ $slot }}</div>
            </section>
        </div>

        @livewireScripts

        <!-- Template JS File -->
        <script src="assets/js/scripts.js"></script>
        <script src="assets/js/custom.js"></script>
    </body>
</html>
