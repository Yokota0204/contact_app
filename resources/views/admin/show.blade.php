@extends('layouts.dashboard')

@section('stylesheet')
  <link rel="stylesheet" href="{{ asset('css/orders/table.css') }}">
  <link rel="stylesheet" href="{{ asset('css/admin/show.css') }}">
@endsection

@section('content')
  <x-header/>
  <div class="container">
    <div class="profile">
      <div class="profile-image">
        <img src="{{ asset('images/user.jpeg') }}" alt="ユーザー画像">
        <div class="camera-icon"><i class="fas fa-camera"></i></div>
      </div>
      <div class="profile-text">
        <h4>
          <i class="fas fa-user-graduate"></i>&nbsp;
          横田　陽平&nbsp;
          <a class="btn btn-outline-secondary">設定</a>
        </h4>
        <p class="mb-5">GNDKNG325KD</p>
        <h5>test@gmail.com</h5>
        <h5>090-xxxx-xxxx</h5>
      </div>
    </div>
    <div class="orders-wrapper">
      <h3 class="text-center border-bottom pb-2 mb-5">担当案件一覧</h3>
      <div class="header-row row">
        <div class="col-2">受付日時</div>
        <div class="col-2">ステータス</div>
        <div class="col">会社名</div>
        <div class="col">クライアント名</div>
        <div class="col">メールアドレス</div>
      </div>
      <div class="rows-wrapper">
        <a class="row" href="{{ route('admin.orders.show') }}">
          <div class="col-2">2021/05/31 22:33</div>
          <div class="col-2">対応中</div>
          <div class="col">株式会社雑談兄弟</div>
          <div class="col">横田 陽平</div>
          <div class="col">yokota.02210301@gmail.com</div>
        </a>
        <a class="row" href="{{ route('admin.orders.show') }}">
          <div class="col-2">2021/05/31 22:33</div>
          <div class="col-2">対応中</div>
          <div class="col">株式会社雑談兄弟</div>
          <div class="col">横田 陽平</div>
          <div class="col">yokota.02210301@gmail.com</div>
        </a>
      </div>
    </div>
  </div>
@endsection

@section('modal')
@endsection