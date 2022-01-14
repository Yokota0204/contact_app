<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="{{ route('admin.orders.index') }}">福岡システム開発　ダッシュボード</a>
  <div class="collapse navbar-collapse">
    <ul class="navbar-nav ml-auto my-2 my-lg-0">
      <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.show', ['uid' => $login_user->uid]) }}">
          @isset($login_user->avatar)
            <img id="headerIcon" class="user-icon" src="{{ asset("storage/admins/$login_user->uid/profile/$login_user->avatar") }}" alt="ユーザー画像">
          @else
            <img id="headerIcon" class="user-icon" src="{{ asset('images/user.jpeg') }}" alt="ユーザー画像">
          @endisset
          &nbsp;{{ $login_user->name }}
        </a>
      </li>
      <li class="nav-item">
        <button id="logoutBtn" class="nav-link btn-logout" type="button">
          <i class="fas fa-sign-out-alt"></i>&nbsp;ログアウト
        </button>
      </li>
    </ul>
  </div>
</nav>
<x-logout-modal/>