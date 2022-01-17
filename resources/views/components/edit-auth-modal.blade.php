<div id="editAuthModal" class="modal" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form id="edit_auth_pop_up" class="modal-content" action="{{ route('admin.update.auth') }}" method="POST">
      @csrf
      <input id="editModalUidInput" name="uid" type="hidden">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">下記ユーザーの権限を選択してください。</h5>
        <button type="button" class="close close-edit-auth" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-2">ID</div>
          <div id="editModalUid" class="col"></div>
        </div>
        <div class="row">
          <div class="col-2">名前</div>
          <div id="editModalName" class="col"></div>
        </div>
        <div class="row">
          <div class="col-2">権限</div>
          <div class="col">
            <select id="editModalRole" class="input" name="role">
              <option value="3">ユーザー</option>
              <option value="2">リーダー</option>
              <option value="1">ルート</option>
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