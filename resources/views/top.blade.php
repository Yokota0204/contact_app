<x-layout>
  <x-slot name="page">
    top
  </x-slot>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.8.0/gsap.min.js"></script>
  <script src="lib/leonsans/dist/leon.js" type="text/javascript"></script>
  <div id="top" class="first-impression">
    <iframe src="lib/leonsans/examples/plants-pixi.html" frameborder="0" width="100%" height="100%"></iframe>
  </div>
  <div class="message info-wrapper">
    <video type="video/mp4" src="{{ url('videos/pexels-joshua-6738974.mp4') }}" class="bg" webkit-playsinline playsinline muted autoplay loop></video>
    <div class="text">
      <h1 class="line">ウェブ開発のご依頼はお任せください！</h1>
      <h1>プロのエンジニアが責任を持って対応させていただきます。</h1>
      <a href="{{ route('orders.create') }}" class="btn btn-lg btn-primary">お問い合わせ</a>
    </div>
  </div>
  <div class="receivable-orders info-wrapper">
    <div class="content">
      <h2 class="title border-bottom pb-3">受注可能案件</h2>
      <ul class="orders">
        <li class="order">ホームページ制作（デザインはあらかじめご用意ください）</li>
        <li class="order">Excel、Googleスプレッドシート自動化（VBA、GAS）</li>
        <li class="order">RPA（データ入力などの単純作業自動化）</li>
        <li class="order">社内システム開発（顧客データ管理、社内承認などをシステム化）</li>
        <li class="order">クラウド導入サポート（ペーパーレス化）</li>
        <li class="order">ウェブシステム開発（予約、お問い合わせ、管理などシステム化）</li>
        <li class="order">LINEボット開発（LINE公式アカウントのシステム構築）</li>
      </ul>
    </div>
  </div>
  <div class="development-techs info-wrapper">
    <div class="content">
      <h2 class="title pb-3">対応技術</h2>
      <div class="tech-part">
        <h5>【対応言語・技術】</h5>
        <p>HTML、CSS、JavaScript、PHP、VBA、GAS、AWS、Autoit、MySQL</p>
      </div>
      <div class="tech-part">
        <h5>【対応ライブラリ/フレームワーク】</h5>
        <p>Ruby on Rails、Laravel、Vue.js、jQuery、Bootstrap</p>
      </div>
      <div class="tech-part">
        <h5>【対応API】</h5>
        <p>LINE Messaging API、Slack</p>
      </div>
    </div>
  </div>
</x-layout>