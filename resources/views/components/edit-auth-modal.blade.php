<div id="editAuthModal" class="modal" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form id="edit_auth_pop_up" class="modal-content" action="{{ route('admin.update.auth') }}" method="POST">
      @csrf
      <input name="id" type="hidden">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">下記ユーザーの権限を選択してください。</h5>
        <button type="button" class="close close-edit-auth" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-2">ID</div>
          <div class="col">DAJKFLDK34</div>
        </div>
        <div class="row">
          <div class="col-2">名前</div>
          <div class="col">横田 陽平</div>
        </div>
        <div class="row">
          <div class="col-2">権限</div>
          <div class="col">
            <select class="input" name="authority">
              <option value="1">ルート</option>
              <option value="2">リーダー</option>
              <option value="3">ユーザー</option>
            </select>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary close-edit-auth">閉じる</button>
        <button id="updateBtn" type="submit" class="btn btn-primary">更新</button>
      </div>
    </form>
  </div>
</div>