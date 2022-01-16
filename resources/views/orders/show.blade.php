@extends('layouts.dashboard')

@section('title')
  問い合わせ詳細画面｜福岡システム開発　管理者画面
@endsection

@section('stylesheet')
  <link rel="stylesheet" href="{{ asset('css/form.css') }}">
  <link rel="stylesheet" href="{{ asset('css/message_box.css') }}">
  <link rel="stylesheet" href="{{ asset('css/orders/show.css') }}">
@endsection

@section('script')
  <script type="text/javascript" src="{{ asset('js/orders/show.js') }}"></script>
@endsection

@section('content')
  <x-header/>
  <x-message-box></x-message-box>
  <div class="container">
    <a class="back-link mb-5" href="{{ route('admin.orders.search')."?".$inputs_params }}">&lt;&lt;&nbsp;戻る</a>
    <div class="order-wrapper">
      <div class="row">
        <div class="col-2">問い合わせ者</div>
        <div class="col">{{ $order->company."  ".$order->client }}&nbsp;&nbsp;様&nbsp;&nbsp;&lt;&nbsp;{{ $order->email }}&nbsp;&gt;</div>
      </div>
      <div class="row">
        <div class="col-2">問い合わせ日時</div>
        <div class="col">{{ $order->created_at_display }}</div>
      </div>
      <form id="statusForm" class="row status" action="{{ route('admin.orders.update.status') }}" method="POST">
        @csrf
        <input name="id" type="hidden" value="{{ $order->id }}">
        <div class="col-2">ステータス</div>
        <div class="col">
          <select id="statusSelect" class="select" name="status">
            @foreach ($status_arr as $status)
              <option value="{{ $status['val'] }}" @if ($order->status == $status['val']) selected @endif>
                {{ $status['label'] }}
              </option>
            @endforeach
          </select>
        </div>
      </form>
      @if ($login_user->role == "1" || $login_user->role == "2")
        <form id="inChargeForm" class="row status" action="{{ route('admin.orders.update.in_charge') }}" method="POST">
          @csrf
          <input name="id" type="hidden" value="{{ $order->id }}">
          <div class="col-2">担当者</div>
          <div class="col">
            <select id="inChargeSelect" class="select" name="in_charge">
              <option value="">担当者を選択してください。</option>
              @foreach ($users as $user)
                <option value="{{ $user->uid }}" @if ($order->in_charge == $user->uid) selected @endif>
                  {{ $user->name }}(UID: {{ $user->uid }})
                </option>
              @endforeach
            </select>
          </div>
        </form>
      @endif
      <div class="order-body">
        {{ $order->question }}
      </div>
    </div>
    <div class="replies-wrapper">
      @foreach ($emails as $email)
        <div class="reply">
          <div class="header border-bottom mb-3 pb-2">
            <h5>{{ $email->subject }}</h5>
            <div class="datetime">{{ $email->created_at }}</div>
          </div>
          <div class="row">
            <div class="replier">{{ $email->admin()->first()->name }}（ID:&nbsp;{{ $email->sender_id }}）</div>
          </div>
          <div class="row to">
            <div class="col-2">Reply To:&nbsp;</div>
            <div class="col">{{ $order->email }}</div>
          </div>
          @foreach ($email->destinations()->get() as $destination)
            @if ($destination->type == "1")
              <div class="row to">
                <div class="col-2">To:&nbsp;</div>
                <div class="col">{{ $destination->address }}</div>
              </div>
            @elseif ($destination->type == "2")
              <div class="row cc">
                <div class="col-2">Cc:&nbsp;</div>
                <div class="col">{{ $destination->address }}</div>
              </div>
            @else
              <div class="row bcc">
                <div class="col-2">Bcc:&nbsp;</div>
                <div class="col">{{ $destination->address }}</div>
              </div>
            @endif
          @endforeach
          <div class="body">{{ $email->body }}</div>
          <div class="files">
            @foreach ($email->files()->get() as $file)
              <a class="file" href="/storage/reply/{{ $order->id }}/{{ $email->id }}/{{ $file->name }}">{{ $file->name }}</a>
            @endforeach
          </div>
        </div>
      @endforeach
    </div>
    <form class="reply-wrapper form" action="{{ route('admin.orders.reply', ['order_id' => $order->id]) }}" method="POST" enctype="multipart/form-data">
      @csrf
      <h3 class="mb-5">返信フォーム</h3>
      <div class="form-group">
        <p>件名</p>
        <input class="form-item input" name="subject" type="text" value="{{ old('subject') }}" required>
      </div>
      <div class="form-group reply-to">
        <p>Reply To</p>
        <div class="form-item input">{{ $order->email }}</div>
      </div>
      <div class="form-group">
        <p>To（カンマ区切り）</p>
        <input class="form-item input" name="to" type="text" value="{{ old('to') }}">
      </div>
      <div class="form-group">
        <p>Cc（カンマ区切り）</p>
        <input class="form-item input" name="cc" type="text" value="{{ old('cc') }}">
      </div>
      <div class="form-group">
        <p>Bcc（カンマ区切り）</p>
        <input class="form-item input" name="bcc" type="text" value="{{ old('bcc') }}">
      </div>
      <div class="form-group">
        <p>本文</p>
        <textarea class="form-item textarea" name="body" rows="10" required>{{ old('body') }}</textarea>
      </div>
      <div class="form-group file">
        <p>
          添付ファイル&nbsp;
          <span>
            <button id="plusFile" class="btn btn-primary" type="button"><i class="fas fa-plus"></i></button>
            <button id="minusFile" class="btn btn-danger" type="button"><i class="fas fa-minus"></i></button>
          </span>
        </p>
        <input id="file1" class="form-item input" name="file1" type="file">
        <input id="file2" class="form-item input" name="file2" type="file">
        <input id="file3" class="form-item input" name="file3" type="file">
        <input id="file4" class="form-item input" name="file4" type="file">
        <input id="file5" class="form-item input" name="file5" type="file">
        <input id="file6" class="form-item input" name="file6" type="file">
        <input id="file7" class="form-item input" name="file7" type="file">
        <input id="file8" class="form-item input" name="file8" type="file">
        <input id="file9" class="form-item input" name="file9" type="file">
        <input id="file10" class="form-item input" name="file10" type="file">
        <input id="fileCount" name="file_count" type="hidden" value="1">
      </div>
      <div class="btn-wrapper">
        <button class="btn btn-lg btn-primary" type="submit">送信</button>
      </div>
    </form>
  </div>
@endsection

@section('modal')
@endsection