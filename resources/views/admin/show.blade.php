@extends('layouts.dashboard')

@section('stylesheet')
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="{{ asset('lib/cropperjs/dist/cropper.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/orders/table.css') }}">
  <link rel="stylesheet" href="{{ asset('css/admin/show.css') }}">
@endsection

@section('script')
  <script>
    window.Admin = @json($admin);
    window.csrf_token = @json(csrf_token());
  </script>
@endsection

@section('content')
  <x-header/>
  <div class="container">
    <div class="profile">
      <label class="profile-image">
        @isset ($admin->avatar)
          <img id="userImg" src="{{ asset("storage/admins/$admin->uid/profile/$admin->avatar") }}" alt="ユーザー画像">
        @else
          <img id="userImg" src="{{ asset('images/user.jpeg') }}" alt="ユーザー画像">
        @endisset
        @if ($login_user->uid == $admin->uid)
          <div class="camera-icon"><i class="fas fa-camera"></i></div>
          <input id="imgInput" type="file" name="user_img" accept=".jpg,.png,image/jpeg,image/png">
          <p id="failUpload" class="text-danger">画像のアップロードに失敗しました。</p>
        @endif
      </label>
      <div class="profile-text">
        <h4>
          @if ($admin->role == "1")
            <i class="fas fa-user-graduate"></i>&nbsp;
          @elseif ($admin->role == "2")
            <i class="fas fa-user-tie"></i>&nbsp;
          @else
            <i class="fas fa-user"></i>
          @endif
          {{ $admin->name }}&nbsp;
          @if ($login_user->uid == $admin->uid)
            <a class="btn btn-outline-secondary" href="{{ route('admin.config') }}">設定</a>
          @endif
        </h4>
        <p class="mb-5">ID:&nbsp;{{ $admin->uid }}</p>
        <h5><i class="far fa-envelope"></i>&nbsp;{{ $admin->email }}</h5>
        @isset ($admin->tel_no)
          <h5><i class="fas fa-phone"></i>&nbsp;{{ $admin->tel_no }}</h5>
        @endisset
      </div>
    </div>
    <div class="orders-wrapper">
      <h3 class="text-center border-bottom pb-2 mb-5">直近の担当案件一覧</h3>
      <div class="header-row row">
        <div class="col-2">受付日時</div>
        <div class="col-2">ステータス</div>
        <div class="col">会社名</div>
        <div class="col">クライアント名</div>
        <div class="col">メールアドレス</div>
      </div>
      <div class="rows-wrapper">
        @isset ($orders)
          @foreach ($orders as $order)
            <a class="row" href="/admin/orders/{{ $order->id }}">
              <div class="col-2">{{ $order->created_at_display }}</div>
              <div class="col-2">{{ $status_arr[$order->status]['label'] }}</div>
              <div class="col">{{ $order->company }}</div>
              <div class="col">{{ $order->client }}</div>
              <div class="col">{{ $order->email }}</div>
            </a>
          @endforeach
        @endisset
      </div>
    </div>
  </div>
@endsection

@section('modal')
  <x-cropper-modal></x-cropper-modal>
@endsection