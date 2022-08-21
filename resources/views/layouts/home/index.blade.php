<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>{{ env('APP_NAME') }}</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <link href="{{ asset('') }}img/logo.png" rel="icon">

  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <link href="{{ asset('') }}vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link href="{{ asset('') }}vendor/animate.css/animate.min.css" rel="stylesheet">
  <link href="{{ asset('') }}vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="{{ asset('') }}vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="{{ asset('') }}vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="{{ asset('') }}vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="{{ asset('') }}vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="{{ asset('') }}vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('') }}assets/vendor/fonts/boxicons.css" />

  <link rel="stylesheet" href="{{ asset('') }}assets/vendor/css/core.css" class="template-customizer-core-css" />
  <link rel="stylesheet" href="{{ asset('') }}assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
  <link rel="stylesheet" href="{{ asset('') }}assets/css/demo.css" />
  <link rel="stylesheet" href="{{ asset('') }}assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
  <link href="{{ asset('') }}css/style.css" rel="stylesheet">
  <link href="{{ asset('') }}css/grid.css" rel="stylesheet">
  
  <link rel="stylesheet" href="{{ asset('') }}vendor/select2/dist/css/select2.min.css">

  @yield('css')
</head>

<body>
  <header id="header" class="fixed-top">
    <div class="container d-flex align-items-center">

      <h1 class="logo me-auto"><a href="/"> <img src="{{ asset('') }}img/Dwella.png" alt=""></a></h1>

      <nav id="navbar" class="navbar order-last order-lg-0">
        <ul>
          <li><a class="nav-link" href="{{ route('home.index') }}#hero">Home</a></li>
          {{-- <li><a class="nav-link" href="#about">About</a></li> --}}
          <li><a class="nav-link" href="{{ route('home.index') }}#treatment">Treatments</a></li>
          <li><a class="nav-link" href="{{ route('home.index') }}#about-us">Tentang Dwella</a></li>
          <li><a class="nav-link" href="{{ route('schedule') }}">Jadwal Praktek</a></li>
          <li><a class="nav-link" href="{{ route('product') }}">Produk</a></li>
          @guest
          <li><a class="nav-link" href="{{ route('user.schedule-order.index') }}">Buat Janji</a></li>
          @endguest
          @auth
          @if(auth()->user()->level->primary == "NO")
            <li><a class="nav-link" href="{{ route('user.schedule-order.index') }}">Buat Janji</a></li>
            <li><a class="nav-link" href="{{ route('user.profile.index') }}">Profile</a></li>
            <li><a class="nav-link" href="{{ route('user.cart.index') }}">Keranjang</a></li>
            @endif
          @endauth
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->
      @auth
        @php
            $user = auth()->user();
        @endphp
        <a href="{{ $user->level->primary == 'YES'? route('admin.dashboard.index') : route('user.profile.index') }}" class="appointment-btn"><span class="d-none d-md-inline">{{ $user->name }}</a>
        <a href="{{ route('auth.logout') }}" class="appointment-btn bg-danger"><span class="d-none d-md-inline">Logout</a>
      @endauth
      @guest
        <a href="/login" class="appointment-btn scrollto"><span class="d-none d-md-inline">Login</a>
      @endguest

    </div>
  </header><!-- End Header -->

  <div id="main-app" style="min-height: 85vh">
    @yield('content')
  </div>

  <footer class="bg-dark py-5">
    <div class="container text-center text-md-start">
      <!-- Grid row -->
      <div class="row mt-1">
        <!-- Grid column -->
        <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
          <!-- Content -->
          <p class="text-white"><a class="text-white" href="{{ url('') }}">{{ env('APP_NAME') }}</a><br></p>
          <p class="text-white"><a class="text-white" href="/desclaimer">Desclaimer</a></p>
        </div>
        <!-- Grid column -->

        <!-- Grid column -->
        
        <!-- Grid column -->

        <!-- Grid column -->
      
        <!-- Grid column -->

        <!-- Grid column -->
        <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
          <!-- Links -->
          <h6 class="text-uppercase text-white fw-bold mb-4">Contact</h6>
          <p class="text-white"><i class="fas fa-home me-3"></i> Taman Hayati Salam blok E.2, Jl Munchtar Raya Sawangan Baru, Depok</p>
          <p class="text-white">
            <i class="fas fa-envelope me-3"></i>
            aazkia30@gmail.com
          </p>
          <p class="text-white"><i class="fas fa-phone me-3"></i> 081399191244</p>
        </div>
        <!-- Grid column -->
      </div>
      <!-- Grid row -->
    </div>
    {{-- <div class="container">
      <div class="row">
        <div class="col-md-8 text-center text-md-start mb-3 mb-md-0">
          <small class="text-white"><a class="text-white" href="{{ url('') }}">{{ env('APP_NAME') }}</a></small>
        </div>
        <div class="col-md-8 text-center text-md-start mb-3 mb-md-0">
          <small class="text-white"><a class="text-white" href="/desclaimer">Desclaimer</a></small>
        </div>
      </div>
    </div> --}}
  </footer>

  <div id="preloader"></div>
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <script src="{{ asset('js/jq.min.js') }}"></script>
  <script src="{{ asset ('/vendor/purecounter/purecounter.js') }}"></script>
  <script src="{{ asset ('/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset ('/vendor/glightbox/js/glightbox.min.js') }}"></script>
  <script src="{{ asset ('/vendor/swiper/swiper-bundle.min.js') }}"></script>
  <script src="{{ asset ('/vendor/php-email-form/validate.js') }}"></script>
  <script src="{{ asset('') }}js/main.js"></script>
  @yield('js')
</body>