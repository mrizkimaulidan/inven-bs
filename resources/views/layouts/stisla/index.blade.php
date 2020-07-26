@include('layouts.stisla.header')

<body>
  <div id="app">
    <div class="main-wrapper">
      <div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar">
        <form class="form-inline mr-auto">
          <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
          </ul>
        </form>
        @include('layouts.stisla.navbar')

        @include('layouts.stisla.sidebar')
        <!-- Main Content -->
        <div class="main-content">
          <section class="section">
            <div class="section-header">
              <h1>{{ $page_heading }}</h1>
            </div>

            @yield('content')
          </section>
        </div>
        @include('layouts.stisla.footer')