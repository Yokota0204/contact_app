@extends('layouts.dashboard')

@section('title')
  問い合わせ詳細画面｜福岡システム開発　管理者画面
@endsection

@section('stylesheet')
  <link rel="stylesheet" href="{{ asset('css/form.css') }}">
  <link rel="stylesheet" href="{{ asset('css/orders/show.css') }}">
  <script type="text/javascript" src="{{ asset('js/orders/show.js') }}"></script>
@endsection

@section('content')
  <x-header/>
  <div class="container">
    <a class="back-link mb-5" href="{{ route('admin.orders.index') }}">&lt;&lt;&nbsp;戻る</a>
    <div class="order-wrapper">
      <div class="row">
        <div class="col-2">問い合わせ者</div>
        <div class="col">株式会社雑談兄弟 山田 様</div>
      </div>
      <div class="row">
        <div class="col-2">問い合わせ日時</div>
        <div class="col">2021/12/31 15:29</div>
      </div>
      <div class="row status">
        <div class="col-2">ステータス</div>
        <div class="col">
          <select class="select" name="status">
            <option value="2">未対応</option>
            <option value="3">対応中</option>
            <option value="4">保留</option>
            <option value="5">対応済み</option>
          </select>
        </div>
      </div>
      <div class="order-body">
        お世話になります。株式会社雑談兄弟　システム管理部の山田と申します。<br><br>
        現在、弊社では会社の方針としてペーパーレス化促進に取り組んでおります。<br>
        社内にシステムを導入するに当たり、外部委託にて御社のお力を借りられればと思い、ご連絡いたしました。<br>
        環境などについても、いろいろとご相談したく存じます。<br>
        ご連絡お待ちしております。<br><br>
        株式会社雑談兄弟　山田
      </div>
    </div>
    <div class="replies-wrapper">
      <div class="reply">
        <div class="header border-bottom mb-3 pb-2">
          <h5>タイトル</h5>
          <div class="datetime">2022/01/04 12:35</div>
        </div>
        <div class="row">
          <div class="replier">横田　陽平（ID:&nbsp;DAKGIKC3453）</div>
        </div>
        <div class="row to">
          <div class="col-2">To:&nbsp;</div>
          <div class="col">ChatBrothers402@gmail.com</div>
        </div>
        <div class="row bcc">
          <div class="col-2">Bcc:&nbsp;</div>
          <div class="col">yokota.technology@gmail.com</div>
        </div>
        <div class="body">
          株式会社雑談兄弟　山田　様<br><br>
          お世話になります。福岡システム開発の横田と申します。<br>
          この度はお問い合わせいただきありがとうございます。<br><br>
          お問い合わせいただいた内容について、弊社で提案できる内容であるため、詳しくお話させていただきたく存じます。<br>
          ぜひ一度、オンラインで直接会話できればと思います。<br>
          ご都合のつく日時の候補を３つほど下記のメールアドレスへ送っていただくことは可能でしょうか？<br>
          メール：yokota.technology@gmail.com<br><br>
          よろしくお願いいたします。<br>
          福岡システム開発　横田
        </div>
        <div class="">
          <a>sample.txt</a>
        </div>
      </div>
    </div>
    <form class="reply-wrapper form" action="">
      @csrf
      <h3 class="mb-5">返信フォーム</h3>
      <div class="form-group">
        <p>件名</p>
        <input class="form-item input" type="text">
      </div>
      <div class="form-group">
        <p>To</p>
        <input class="form-item input" type="text">
      </div>
      <div class="form-group">
        <p>Cc</p>
        <input class="form-item input" type="text">
      </div>
      <div class="form-group">
        <p>Bcc</p>
        <input class="form-item input" type="text">
      </div>
      <div class="form-group">
        <p>本文</p>
        <textarea class="form-item textarea" name="" rows="10"></textarea>
      </div>
      <div class="form-group file">
        <p>
          添付ファイル&nbsp;
          <span>
            <button id="plusFile" class="btn btn-primary" type="button"><i class="fas fa-plus"></i></button>
            <button id="minusFile" class="btn btn-danger" type="button"><i class="fas fa-minus"></i></button>
          </span>
        </p>
        <input id="file1" class="form-item input" type="file">
        <input id="file2" class="form-item input" type="file">
        <input id="file3" class="form-item input" type="file">
        <input id="file4" class="form-item input" type="file">
        <input id="file5" class="form-item input" type="file">
        <input id="file6" class="form-item input" type="file">
        <input id="file7" class="form-item input" type="file">
        <input id="file8" class="form-item input" type="file">
        <input id="file9" class="form-item input" type="file">
        <input id="file10" class="form-item input" type="file">
      </div>
      <div class="btn-wrapper">
        <button class="btn btn-lg btn-primary" type="submit">確認画面</button>
      </div>
    </form>
  </div>
@endsection

@section('modal')
@endsection