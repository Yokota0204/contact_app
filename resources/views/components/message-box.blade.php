<script type="text/javascript" src="{{ asset('js/message_box.js') }}"></script>
@if ($errors->any())
  <div id="alertMsgBox" class="message-box alert alert-danger">
    <ul>
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
    <span id="closeErr" class="close-btn">×</span>
  </div>
@endif
@if (session('success'))
  <div id="msg" class="message-box message alert">
    <p>{{ session('success') }}</p>
    <span id="closeMsg" class="close-btn">×</span>
  </div>
@endif