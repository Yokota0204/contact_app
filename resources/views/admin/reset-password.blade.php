@extends('layouts.dashboard')

@section('stylesheet')
  <link rel="stylesheet" href="{{ asset('css/form.css') }}">
@endsection

@section('content')
  <form class="form" method="POST" action="{{ route('admin.password.update') }}">
    @csrf
    <h2 class="text-center mb-4">パスワード変更用リンク送信</h2>
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <x-auth-validation-errors class="mb-4" :errors="$errors" />
    <input type="hidden" name="token" value="{{ $request->route('token') }}">
    <div class="form-group">
      <x-label for="email" :value="__('Email')" />
      <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus />
    </div>
    <div class="form-group">
      <x-label for="password" :value="__('Password')" />
      <x-input id="password" class="block mt-1 w-full" type="password" name="password" required />
    </div>
    <div class="form-group">
      <x-label for="password_confirmation" :value="__('Confirm Password')" />
      <x-input id="password_confirmation" class="block mt-1 w-full" type="password"
        name="password_confirmation" required />
    </div>
    <div class="btn-wrapper">
      <button class="btn btn-primary">認証メール送信</button>
    </div>
  </form>
@endsection

@section('modal')
@endsection