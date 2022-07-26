<!DOCTYPE html><html
  lang="en"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-template="vertical-menu-template-free"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>{{ env('APP_NAME') }}</title>

    <meta name="description" content="" />

    <link href="{{ asset('') }}img/logo.png" rel="icon">

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />

    <link rel="stylesheet" href="{{ asset('') }}assets/vendor/fonts/boxicons.css" />
    <link rel="stylesheet" href="{{ asset('') }}vendor/fontawesome-free/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('') }}assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('') }}assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('') }}assets/css/demo.css" />
    <link rel="stylesheet" href="{{ asset('') }}assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <link rel="stylesheet" href="{{ asset('') }}assets/vendor/libs/apex-charts/apex-charts.css" />

    <link rel="stylesheet" href="{{ asset('') }}vendor/DataTables/datatables.min.css" />
    <link rel="stylesheet" href="{{ asset('') }}vendor/select2/dist/css/select2.min.css">

    <style>
      .page-link {
        position: relative;
        display: block;
        color: #0d6efd;
        text-decoration: none;
        background-color: #fff;
        border: 1px solid #dee2e6;
        transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
      }
      @media (prefers-reduced-motion: reduce) {
        .page-link {
          transition: none;
        }
      }
      .page-link:hover {
        z-index: 2;
        color: #0a58ca;
        background-color: #e9ecef;
        border-color: #dee2e6;
      }
      .page-link:focus {
        z-index: 3;
        color: #0a58ca;
        background-color: #e9ecef;
        outline: 0;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
      }

      .page-item:not(:first-child) .page-link {
        margin-left: -1px;
      }
      .page-item.active .page-link {
        z-index: 3;
        color: #fff;
        background-color: #0d6efd;
        border-color: #0d6efd;
      }
      .page-item.disabled .page-link {
        color: #6c757d;
        pointer-events: none;
        background-color: #fff;
        border-color: #dee2e6;
      }

      .page-link {
        padding: 0.375rem 0.75rem;
      }

      .page-item:first-child .page-link {
        border-top-left-radius: 0.25rem;
        border-bottom-left-radius: 0.25rem;
      }
      .page-item:last-child .page-link {
        border-top-right-radius: 0.25rem;
        border-bottom-right-radius: 0.25rem;
      }

      .pagination-lg .page-link {
        padding: 0.75rem 1.5rem;
        font-size: 1.25rem;
      }
      .pagination-lg .page-item:first-child .page-link {
        border-top-left-radius: 0.3rem;
        border-bottom-left-radius: 0.3rem;
      }
      .pagination-lg .page-item:last-child .page-link {
        border-top-right-radius: 0.3rem;
        border-bottom-right-radius: 0.3rem;
      }

      .pagination-sm .page-link {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
      }
      .pagination-sm .page-item:first-child .page-link {
        border-top-left-radius: 0.2rem;
        border-bottom-left-radius: 0.2rem;
      }
      .pagination-sm .page-item:last-child .page-link {
        border-top-right-radius: 0.2rem;
        border-bottom-right-radius: 0.2rem;
      }
      ul.pagination{
          display: flex;
          list-style: none;
      }
    </style>

    @yield('css')

    <script src="{{ asset('') }}assets/vendor/js/helpers.js"></script>
    <script src="{{ asset('') }}assets/js/config.js"></script>
  </head>

  <body>
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">

        @include('layouts.admin.sidebar')
        <div class="layout-page">

          @include('layouts.admin.navbar')

          <div class="content-wrapper">

            <div class="container-xxl flex-grow-1 container-p-y">
                
                @yield('content')
                
            </div>

            <div class="content-backdrop fade"></div>
          </div>
        </div>
      </div>

      <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <script src="{{ asset('') }}assets/vendor/libs/jquery/jquery.js"></script>
    <script src="{{ asset('') }}assets/vendor/libs/popper/popper.js"></script>
    <script src="{{ asset('') }}assets/vendor/js/bootstrap.js"></script>
    <script src="{{ asset('') }}assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="{{ asset('') }}vendor/DataTables/datatables.min.js"></script>
    <script src="{{ asset('') }}vendor/select2/dist/js/select2.min.js"></script>

    <script src="{{ asset('') }}assets/vendor/js/menu.js"></script>
    <script src="{{ asset('') }}assets/vendor/libs/apex-charts/apexcharts.js"></script>
    <script src="{{ asset('') }}assets/js/main.js"></script>
    <script src="{{ asset('') }}assets/js/dashboards-analytics.js"></script>
    <script async defer src="https://buttons.github.io/buttons.js"></script>

    @yield('js')

  </body>
</html>
