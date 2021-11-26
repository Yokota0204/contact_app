<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>トップページ</title>
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/'.$page.'.css') }}" rel="stylesheet">
    @if($page == "orders/confirmation")
      <link href="{{ asset('/css/orders/create.css') }}" rel="stylesheet">
    @endif
    <link rel="stylesheet" href="{{ url('lib/fontawesome6.0.0/css/all.min.css') }}">
  </head>
  <body class="antialiased">
    <div class="contents">
      <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="/">福岡システム開発</a>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
          <ul class="navbar-nav ml-auto my-2 my-lg-0">
            <li class="nav-item">
              <a class="nav-link" href="#">開発エンジニア紹介</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">料金</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('orders.create') }}">お問い合わせ</a>
            </li>
          </ul>
        </div>
      </nav>
      <main>
        {{ $slot }}
      </main>
      <footer class="bg-dark">
        <p>営業時間：平日・土日　10:00~18:00</p>
        <p><i class="far fa-envelope"></i>&nbsp;yokota.technology@gmail.com</p>
        <ul class="sns-icons">
          <li class="sns"><a href="https://twitter.com/YoheiYokota" class="sns-link"><i class="fab fa-twitter"></i></a></li>
          <li class="sns"><a href="https://www.facebook.com/youhei.yokota.5" class="sns-link"><i class="fab fa-facebook"></i></a></li>
          <li class="sns"><a href="https://github.com/Yokota0204" class="sns-link"><i class="fab fa-github"></i></a></li>
        </ul>
      </footer>
    </div>
  </body>
</html>