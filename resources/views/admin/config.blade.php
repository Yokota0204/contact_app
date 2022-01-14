@extends('layouts.dashboard')

@section('stylesheet')
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="{{ asset('lib/cropperjs/dist/cropper.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/form.css') }}">
  <link rel="stylesheet" href="{{ asset('css/message_box.css') }}">
  <link rel="stylesheet" href="{{ asset('css/admin/config.css') }}">
@endsection

@section('script')
  <script type="text/javascript" src="{{ asset('js/admin/config.js') }}"></script>
  <script>
    window.Admin = @json($login_user);
    window.csrf_token = @json(csrf_token());
  </script>
@endsection

@section('content')
  <x-header></x-header>
  <x-message-box></x-message-box>
  <div class="config-wrapper">
    <ul class="side-bar">
      <h2 class="page-title mb-5 pb-2">設定画面</h2>
      <li class="bar-item"><a class="link" href="{{ route('admin.show', ['uid' => $login_user->uid]) }}">自分のプロフィールへ戻る</a></li>
      <li id="menuProf" class="bar-item active">プロフィール</li>
      @if ($login_user->role == "1")
        <li id="menuUser" class="bar-item">ユーザー管理</li>
      @endif
    </ul>
    <div id="confProf" class="config profile-config">
      <label class="image">
        @isset ($login_user->avatar)
          <img id="userImg" src="{{ asset("storage/admins/$login_user->uid/profile/$login_user->avatar") }}" alt="ユーザー画像">
        @else
          <img id="userImg" src="{{ asset('images/user.jpeg') }}" alt="ユーザー画像">
        @endisset
        <div class="camera-icon"><i class="fas fa-camera"></i></div>
        <input id="imgInput" type="file" name="user_img" accept=".jpg,.png,image/jpeg,image/png">
        <p id="failUpload" class="text-danger">画像のアップロードに失敗しました。</p>
      </label>
      <form class="form" action="{{ route('admin.update', ['uid' => $login_user->uid]) }}" method="POST">
        @csrf
        <div class="row">
          <div class="col-2">電話番号</div>
          <div class="form-group col tel">
            <input class="input" name="tel_no" type="text" value="{{ $login_user->tel_no }}">
          </div>
        </div>
        <div class="row">
          <div class="col-2">メールアドレス</div>
          <div class="form-group col email">
            <input class="input" name="email" type="text" value="{{ $login_user->email }}">
          </div>
        </div>
        <div class="btn-wrapper">
          <button class="btn btn-sm btn-primary">保存</button>
        </div>
      </form>
    </div>
    @if ($login_user->role == "1")
      <div id="confUser" class="config user-config">
        <form class="users-wrapper" action="/admin/destroy" method="POST">
          <div class="btns-wrapper">
            <a class="btn btn-primary" href="{{ route('admin.register') }}">新規追加</a>
            <button id="deleteBtn" class="btn btn-danger" type="button"><i class="far fa-trash-alt"></i>&nbsp;削除</button>
          </div>
          {{-- 削除モーダル --}}
          <div id="deleteModal" class="modal" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div id="deletePopUp" class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="modalLabel">選択した項目を削除しますか？</h5>
                  <button type="button" class="close delete-modal-close" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary delete-modal-close">閉じる</button>
                  <button type="submit" class="btn btn-danger">削除</button>
                </div>
              </div>
            </div>
          </div>
          <div class="users">
            @csrf
            <div class="row header-row">
              <div for="checkAll" class="col-check column check">
                <input id="checkAll" type="checkbox">
              </div>
              <div class="col-2 column">権限</div>
              <div class="col column">名前</div>
              <div class="col-2 column">登録日</div>
              <div class="col-2 column">更新日</div>
              <div class="col-edit column"></div>
            </div>
            <div class="row body-row user">
              <div class="col-check column check">
                <input class="user-check" type="checkbox" name="users[]">
              </div>
              <div class="col-2 column select-row">ルート</div>
              <div class="col column select-row">横田 陽平</div>
              <div class="col-2 column select-row">2021/12/29 10:08</div>
              <div class="col-2 column select-row">2021/12/29 10:08</div>
              <div class="col-edit column edit-open">編集</div>
            </div>
            <div class="row body-row user">
              <div class="col-check column check">
                <input class="user-check" type="checkbox" name="users[]">
              </div>
              <div class="col-2 column select-row">リーダー</div>
              <div class="col column select-row">横田 健太郎</div>
              <div class="col-2 column select-row">2021/12/29 10:08</div>
              <div class="col-2 column select-row">2021/12/29 10:08</div>
              <div class="col-edit column edit-open">編集</div>
            </div>
          </div>
        </form>
      </div>
    @endif
  </div>
@endsection

@section('modal')
  <x-cropper-modal></x-cropper-modal>
  <x-edit-auth-modal></x-edit-auth-modal>
@endsection