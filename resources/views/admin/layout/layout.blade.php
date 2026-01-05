<!doctype html>

<html
  lang="en"
  class=" layout-navbar-fixed layout-menu-fixed layout-compact "
  dir="ltr"
  data-skin="default"
  data-bs-theme="light"
  data-assets-path="{{ asset('assets/admin') }}/"
  data-template="vertical-menu-template">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <meta name="robots" content="noindex, nofollow" />
    <meta name="csrf-token" content="{{ csrf_token() }}">


     @yield('meta-content')

    <link rel="icon" type="image/x-icon" href="{{ asset('assets/admin/img/favicon/favicon.ico')}}" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&ampdisplay=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/fonts/iconify-icons.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/css/core.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/admin/css/demo.css')}}" />
    <script src="{{ asset('assets/admin/vendor/js/helpers.js')}}"></script>
    <script src="{{ asset('assets/admin/js/config.js')}}"></script>

    @yield('css-section')
    
     
  </head>

  <body class="min-vh-100">
    <div class="layout-wrapper layout-content-navbar  ">
      <div class="layout-container">

          @include('admin.layout.sidebar')

        
        <div class="layout-page">
           @include('admin.layout.header')

            @include('components.admin.success')
            
            <div class="content-wrapper">
              @yield('content')

              @include('admin.layout.footer')
      
              <div class="content-backdrop fade"></div>
            </div>
        
        </div>
      </div>

      <div class="layout-overlay layout-menu-toggle"></div>

      <div class="drag-target"></div>
    </div>

    <form id="global-delete-form" method="POST" style="display:none;">
        @csrf
        @method('DELETE')
    </form>

    <script src="{{ asset('assets/admin/vendor/libs/jquery/jquery.js')}}"></script>
    <script src="{{ asset('assets/admin/vendor/js/bootstrap.js')}}"></script>
    <script src="{{ asset('assets/admin/vendor/js/menu.js')}}"></script>
    <script src="{{ asset('assets/admin/js/main.js')}}"></script>

    @yield('js-section')

  </body>
</html>



