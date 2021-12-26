@extends('layouts.dashboard')

@section('title')
  ダッシュボード｜福岡システム開発
@endsection

@section('stylesheet')
  <link rel="stylesheet" href="{{ asset('css/orders/table.css') }}">
  <link rel="stylesheet" href="{{ asset('css/orders/index.css') }}">
@endsection

@section('content')
  <x-header/>
  {{--メインコンテンツ --}}
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
  <nav class="pagination-nav">
    <ul class="pagination">
      <li class="page-item pre">
        <a class="page-link" href="#" aria-label="Previous">
          <span aria-hidden="true">&laquo;</span>
          <span class="sr-only">Previous</span>
        </a>
      </li>
      <li class="page-item next">
        <a class="page-link" href="#" aria-label="Next">
          <span aria-hidden="true">&raquo;</span>
          <span class="sr-only">Next</span>
        </a>
      </li>
    </ul>
  </nav>
  <div class="orders-wrapper">
    <div class="header-row row">
      <div class="col-2">受付日時</div>
      <div class="col-1">ステータス</div>
      <div class="col">会社名</div>
      <div class="col">クライアント名</div>
      <div class="col">メールアドレス</div>
    </div>
    <div class="rows-wrapper">
      <a class="row" href="{{ route('admin.orders.show') }}">
        <div class="col-2">2021/05/31 22:33</div>
        <div class="col-1">対応中</div>
        <div class="col">株式会社雑談兄弟</div>
        <div class="col">横田 陽平</div>
        <div class="col">yokota.02210301@gmail.com</div>
      </a>
      <a class="row" href="{{ route('admin.orders.show') }}">
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
@endsection