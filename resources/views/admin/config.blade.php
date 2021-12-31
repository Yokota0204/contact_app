@extends('layouts.dashboard')

@section('stylesheet')
  <link rel="stylesheet" href="{{ asset('lib/cropperjs/dist/cropper.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/form.css') }}">
  <link rel="stylesheet" href="{{ asset('css/message_box.css') }}">
  <link rel="stylesheet" href="{{ asset('css/admin/config.css') }}">
@endsection

@section('script')
  <script type="text/javascript" src="{{ asset('js/admin/config.js') }}"></script>
@endsection

@section('content')
  <x-header></x-header>
  <x-message-box></x-message-box>
  <div class="config-wrapper">
    <ul class="side-bar">
      <h2 class="page-title mb-5 pb-2">設定画面</h2>
      <li class="bar-item"><a class="link" href="{{ route('admin.show') }}">戻る</a></li>
      <li id="menuProf" class="bar-item active">プロフィール</li>
      <li id="menuUser" class="bar-item">ユーザー管理</li>
    </ul>
    <div id="confProf" class="config profile-config">
      <label class="image">
        <img id="userImg" src="{{ asset('images/user.jpeg') }}" alt="ユーザー画像">
        <input id="imgInput" type="file" name="user_img" accept=".jpg,.gif,.png,image/gif,image/jpeg,image/png">
        <div class="camera-icon"><i class="fas fa-camera"></i></div>
      </label>
      <form class="form" action="">
        @csrf
        <div class="row">
          <div class="col-2">電話番号</div>
          <div class="form-group col tel">
            <input class="input" type="text">
          </div>
        </div>
        <div class="row">
          <div class="col-2">メールアドレス</div>
          <div class="form-group col email">
            <input class="input" type="text">
          </div>
        </div>
        <div class="btn-wrapper">
          <button class="btn btn-sm btn-primary">保存</button>
        </div>
      </form>
    </div>
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
            <div for="checkAll" class="col-1 check">
              <label for="checkAll">全選択</label>
              <input id="checkAll" type="checkbox">
            </div>
            <div class="col-2">権限</div>
            <div class="col">名前</div>
            <div class="col">登録日</div>
            <div class="col-1"></div>
          </div>
          <div class="row body-row user">
            <div class="col-1 check">
              <input class="user-check" type="checkbox" name="users[]">
            </div>
            <div class="col-2">ルート</div>
            <div class="col">横田 陽平</div>
            <div class="col">2021/12/29 10:08</div>
            <div class="col-1"><a href="">編集</a></div>
          </div>
          <div class="row body-row user">
            <div class="col-1 check">
              <input class="user-check" type="checkbox" name="users[]">
            </div>
            <div class="col-2">リーダー</div>
            <div class="col">横田 健太郎</div>
            <div class="col">2021/12/29 10:08</div>
            <div class="col-1"><a href="">編集</a></div>
          </div>
        </div>
      </form>
    </div>
  </div>
@endsection

@section('modal')
  <x-cropper-modal></x-cropper-modal>
@endsection