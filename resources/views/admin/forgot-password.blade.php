@extends('layouts.dashboard')

@section('stylesheet')
  <link rel="stylesheet" href="{{ asset('css/main.css') }}">
  <link rel="stylesheet" href="{{ asset('css/form.css') }}">
  <link rel="stylesheet" href="{{ asset('css/admin/forgot-password.css') }}">
@endsection

@section('content')
  <form class="form" method="POST" action="{{ route('admin.password.email') }}">
    @csrf
    <h2 class="text-center mb-4">パスワード変更用リンク送信</h2>
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <x-auth-validation-errors class="mb-4" :errors="$errors" />
    <div class="form-group">
      <x-label for="email" :value="__('auth.form.email')" />
      <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
    </div>
    <div class="btns-wrapper">
      <button class="btn btn-primary">認証メール送信</button>
      <a class="btn btn-secondary" href="{{ route('admin.login') }}">戻る</a>
    </div>
  </form>
@endsection

@section('modal')
@endsection