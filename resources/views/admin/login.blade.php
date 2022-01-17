@extends('layouts.dashboard')

@section('title')
  管理者ログイン｜福岡システム開発
@endsection

@section('stylesheet')
  <link rel="stylesheet" href="{{ asset('css/admin/login.css') }}">
  <link rel="stylesheet" href="{{ asset('css/form.css') }}">
  <link rel="stylesheet" href="{{ asset('css/message_box.css') }}">
@endsection

@section('content')
  <x-message-box></x-message-box>
  <form class="form" action="/admin/login" method="POST">
    @csrf
    <h3 class="text-center mb-5">ログインフォーム</h3>
    <div class="form-group">
      <label for="inputEmail1">Email address</label>
      <input name="email" type="email" class="form-control" id="inputEmail1" placeholder="Enter email">
    </div>
    <div class="form-group">
      <label for="inputPassword1">Password</label>
      <input name="password" type="password" class="form-control" id="inputPassword1" placeholder="Password">
    </div>
    <div class="forget-password mt-4">
      @if (Route::has('admin.password.request'))
        <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('admin.password.request') }}">
          {{ __('パスワードを忘れた方') }}
        </a>
      @endif
    </div>
    <div class="btn-wrapper">
      <button type="submit" class="btn btn-primary">ログイン</button>
    </div>
  </form>
@endsection