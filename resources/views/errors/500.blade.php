<x-layout>
  <x-slot name="page">
    errors/500
  </x-slot>
  <div class="message-wrapper">
    <h1 class="text-center mb-3">システム内部でエラーが発生しました。</h1>
    <h5 class="text-center mb-5">誠に恐れ入りますが、しばらく時間を置いてお試しください。</h5>
    <img src="{{ url('images/business_ojigi_woman.png') }}" alt="お辞儀の女性">
  </div>
</x-layout>