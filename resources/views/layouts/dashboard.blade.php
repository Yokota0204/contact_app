<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('lib/fontawesome6.0.0/css/all.min.css') }}">
    @yield('stylesheet')
    <script src="{{ asset('js/admin/navbar.js') }}" type="text/javascript"></script>
  </head>
  <body>
    <div class="contents">
      @yield('content')
    </div>
    <x-logout-modal/>
    @yield('modal')
  </body>
</html>