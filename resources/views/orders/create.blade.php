<x-layout>
  <x-slot name="page">
    orders/create
  </x-slot>
  @if ($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif
  <form action="{{ route('orders.confirmation') }}" method="POST" class="form">
    @csrf
    <h3 class="text-center border-bottom pb-3 mb-5">お問い合わせ</h3>
    <div class="row form-group">
      <div class="col-3"><label>会社名</label></div>
      <div class="col">
        <input
          name="company"
          type="text"
          class="input"
          placeholder="会社名をご入力ください。"
          @isset($order)
            value="{{ old('company') }}"
          @endisset
        >
      </div>
    </div>
    <div class="row form-group">
      <div class="col-3"><label>ご担当者様　氏名&nbsp;<span class="text-danger">&#8251;必須</span></label></div>
      <div class="col">
        <input
          name="client"
          type="text"
          class="input"
          placeholder="ご担当者様の氏名を入力してください。"
          required
          @isset($order)
            value="{{ $order->client }}"
          @endisset
        >
      </div>
    </div>
    <div class="row form-group">
      <div class="col-3"><label>メールアドレス&nbsp;<span class="text-danger">&#8251;必須</span></label></div>
      <div class="col">
        <input
          name="email"
          type="email"
          class="input"
          placeholder="メールアドレスを入力してください。"
          required
          @isset($order)
            value="{{ $order->email }}"
          @endisset
        >
      </div>
    </div>
    <div class="row form-group">
      <div class="col-3"><label>お問い合わせ内容&nbsp;<span class="text-danger">&#8251;必須</span></label></div>
      <div class="col">
        <textarea
          name="question"
          cols="30"
          rows="15"
          class="input"
          placeholder="お問い合わせ内容を入力してください。"
          required
        >@isset($order){{ $order->question }}@endisset</textarea>
      </div>
    </div>
    <div class="btn-wrapper">
      <button type="submit" class="btn btn-primary">確認画面へ</button>
    </div>
  </form>
</x-layout>