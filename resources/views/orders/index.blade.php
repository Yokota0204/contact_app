@extends('layouts.dashboard')

@section('title')
  ダッシュボード｜福岡システム開発
@endsection

@section('stylesheet')
  <link rel="stylesheet" href="{{ asset('css/orders/index.css') }}">
  <link rel="stylesheet" href="{{ asset('lib/fontawesome6.0.0/css/all.min.css') }}">
  <script src="{{ asset('js/orders/index.js') }}" type="text/javascript"></script>
@endsection

@section('content')
  {{--メインコンテンツ --}}
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="/">福岡システム開発　ダッシュボード</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav ml-auto my-2 my-lg-0">
        <li class="nav-item">
          <a class="nav-link"><i class="fas fa-user"></i>&nbsp;User: #KDGKGEW</a>
        </li>
        <li class="nav-item">
          <button id="logoutBtn" class="nav-link btn-logout" type="button">
            <i class="fas fa-sign-out-alt"></i>&nbsp;ログアウト
          </button>
        </li>
      </ul>
    </div>
  </nav>
  <div class="search-board">
    <form class="search-form" action="" method="GET">
      @csrf
      <div class="form-item date">
        <input class="input" type="date" placeholder="開始">
        &nbsp;~&nbsp;
        <input class="input" type="date" placeholder="終わり">
      </div>
      <div class="form-item">
        <select class="input" name="status">
          <option value="">ステータス</option>
          <option value="1">未開封</option>
          <option value="2">未対応</option>
          <option value="3">対応中</option>
          <option value="4">保留</option>
          <option value="5">対応済み</option>
        </select>
      </div>
      <div class="form-item client">
        <input class="input" type="text" placeholder="会社名">
      </div>
      <div class="form-item client">
        <input class="input" type="text" placeholder="クライアント名">
      </div>
      <div class="form-item client">
        <input class="input" type="text" placeholder="メール">
      </div>
      <div class="form-item button">
        <button class="btn btn-primary"><i class="fas fa-search"></i></button>
      </div>
    </form>
  </div>
  <div class="orders-wrapper">
    <div class="header-row row">
      <div class="col-2">受付日時</div>
      <div class="col-1">ステータス</div>
      <div class="col">会社名</div>
      <div class="col">クライアント名</div>
      <div class="col">メールアドレス</div>
    </div>
    <div class="rows-wrapper">
      <a class="row">
        <div class="col-2">2021/05/31 22:33</div>
        <div class="col-1">対応中</div>
        <div class="col">株式会社雑談兄弟</div>
        <div class="col">横田 陽平</div>
        <div class="col">yokota.02210301@gmail.com</div>
      </a>
      <a class="row">
        <div class="col-2">2021/05/31 22:33</div>
        <div class="col-1">対応中</div>
        <div class="col">株式会社雑談兄弟</div>
        <div class="col">横田 陽平</div>
        <div class="col">yokota.02210301@gmail.com</div>
      </a>
    </div>
  </div>
@endsection

@section('modal')
  {{-- モーダル --}}
  <div id="modal" class="modal" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div id="pop_up" class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalLabel">ログアウトしますか？</h5>
          <button type="button" class="close close-btn" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form class="modal-footer" action="{{ route('admin.logout') }}" method="POST">
          @csrf
          <button type="button" class="btn btn-secondary close-btn">閉じる</button>
          <button type="submit" class="btn btn-primary">ログアウト</button>
        </form>
      </div>
    </div>
  </div>
@endsection