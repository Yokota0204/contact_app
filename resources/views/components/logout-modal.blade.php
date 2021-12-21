<div id="modal" class="modal" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div id="pop_up" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">ログアウトしますか？</h5>
        <button type="button" class="close close-btn" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="modal-footer" action="{{ route('admin.logout') }}" method="POST">
        @csrf
        <button type="button" class="btn btn-secondary close-btn">閉じる</button>
        <button type="submit" class="btn btn-primary">ログアウト</button>
      </form>
    </div>
  </div>
</div>