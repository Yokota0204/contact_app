<x-layout>
  <x-slot name="page">
    orders/confirmation
  </x-slot>
  <script src="{{ asset('/js/orders/confirmation.js') }}" type="text/javascript"></script>
  <form id="form" action="{{ route('orders.store') }}" method="POST" class="form confirmation-form">
    @csrf
    <h3 class="text-center border-bottom pb-3 mb-5">確認画面</h3>
    <div class="row form-group">
      <div class="col-3"><label>会社名</label></div>
      <div class="col">{{ $order->company }}</div>
      <input type="hidden" name="company" value="{{ $order->company }}">
    </div>
    <div class="row form-group">
      <div class="col-3"><label>ご担当者様　氏名</label></div>
      <div class="col">{{ $order->client }}</div>
      <input type="hidden" name="client" value="{{ $order->client }}">
    </div>
    <div class="row form-group">
      <div class="col-3"><label>メールアドレス</label></div>
      <div class="col">{{ $order->email }}</div>
      <input type="hidden" name="email" value="{{ $order->email }}">
    </div>
    <div class="row form-group">
      <div class="col-3"><label>お問い合わせ内容</label></div>
      <div class="col">{!! nl2br($order->question) !!}</div>
      <input type="hidden" name="question" value="{{ $order->question }}">
    </div>
    <p class="text-center mt-5">この内容で送信します。よろしいですか？</p>
    <div class="btns-wrapper">
      <button id="btnBack" type="button" class="btn btn-secondary">戻る</button>
      <button type="submit" class="btn btn-primary">送信</button>
    </div>
  </form>
</x-layout>