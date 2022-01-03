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
  {{ $orders->links('vendor.pagination.pagination', ['inputs_params' => $inputs_params]) }}
  <div class="search-board">
    <form class="search-form" action="{{ url('/admin/orders/search') }}" method="GET">
      @csrf
      <div class="form-item date">
        <input
          class="input"
          name="start_date"
          type="date"
          placeholder="開始"
          @isset ($inputs['start_date'])
            value="{{ $inputs['start_date'] }}"
          @else
            value="{{ old('start_date') }}"
          @endisset
        >
        &nbsp;~&nbsp;
        <input
          class="input"
          name="end_date"
          type="date"
          placeholder="終わり"
          @isset ($inputs['end_date'])
            value="{{ $inputs['end_date'] }}"
          @else
            value="{{ old('end_date') }}"
          @endisset
        >
      </div>
      <div class="form-item">
        <select class="input" name="status">
          <option value="">全てのステータス</option>
          @foreach ($status_arr as $status)
            <option
              value="{{ $status['value'] }}"
              @if (old('status')==$status['value']
              || (isset($inputs) && $inputs['status'] == $status['value']))
                selected
              @endif>
              {{ $status['label'] }}
            </option>
          @endforeach
        </select>
      </div>
      <div class="form-item client">
        <input
          class="input"
          name="company"
          type="text"
          placeholder="会社名"
          @isset ($inputs['company'])
            value="{{ $inputs['company'] }}"
          @else
            value="{{ old('company') }}"
          @endif>
      </div>
      <div class="form-item client">
        <input
          class="input"
          name="client"
          type="text"
          placeholder="クライアント名"
          @isset($inputs['client'])
            value="{{ $inputs['client'] }}"
          @else
            value="{{ old('client') }}"
          @endisset>
      </div>
      <div class="form-item client">
        <input
          class="input"
          name="email"
          type="text"
          placeholder="メール"
          @isset($inputs['email'])
            value="{{ $inputs['email'] }}"
          @else
            value="{{ old('email') }}"
          @endisset>
      </div>
      <div class="form-item button">
        <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
      </div>
    </form>
  </div>
  <div class="orders-wrapper">
    <div class="header-row row">
      <div class="col-2">受付日時</div>
      <div class="col-2">ステータス</div>
      <div class="col">会社名</div>
      <div class="col">クライアント名</div>
      <div class="col">メールアドレス</div>
    </div>
    <div class="rows-wrapper">
      @isset($orders)
        @for ($i = 0; $i < count($orders); $i++)
          <a class="row" href="{{ route('admin.orders.show') }}">
            <div class="col-2">{{ $orders[$i]->created_at_string }}</div>
            <div class="col-2">{{ $status_arr[$orders[$i]->status]['label'] }}</div>
            <div class="col">{{ $orders[$i]->company }}</div>
            <div class="col">{{ $orders[$i]->client }}&nbsp;様</div>
            <div class="col">{{ $orders[$i]->email }}</div>
          </a>
        @endfor
      @endisset
    </div>
  </div>
  {{ $orders->links('vendor.pagination.pagination', ['inputs_params' => $inputs_params]) }}
@endsection

@section('modal')
@endsection