<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="{{ route('admin.orders.index') }}">福岡システム開発　ダッシュボード</a>
  <div class="collapse navbar-collapse">
    <ul class="navbar-nav ml-auto my-2 my-lg-0">
      <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.show', ['uid' => $login_user->uid]) }}"><i class="fas fa-user"></i>&nbsp;User: {{ $login_user->uid }}</a>
      </li>
      <li class="nav-item">
        <button id="logoutBtn" class="nav-link btn-logout" type="button">
          <i class="fas fa-sign-out-alt"></i>&nbsp;ログアウト
        </button>
      </li>
    </ul>
  </div>
</nav>