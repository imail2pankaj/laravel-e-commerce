<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  {{-- <title>Electra - World's Biggest Antique Collection</title> --}}

   @yield('meta-content')

  <!-- Tailwind compiled CSS -->
  {{-- <link rel="stylesheet" href="{{ asset('assets/frontend/app.css') }}"> --}}

  @vite(['resources/css/app.css', 'resources/js/app.js'])


   @yield('css-section')
</head>

<body class="bg-background text-dark relative">

  <!-- Navbar -->
  @include('frontend.layout.header')

  <!-- Content -->
  @yield('content')

  <!-- Footer -->
 @include('frontend.layout.footer')



  {{-- <div id="app"></div> --}}
<script src="{{ asset('assets/frontend/app.js') }}"></script>

   {{-- @yield('js-section') --}}
</body>

</html>