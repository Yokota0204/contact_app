<style>
  label input {
    display: none;
  }
  .cropper-view-box, .cropper-face {
    border-radius: 50%;
    cursor: grab;
    outline: initial;
  }
  .cropper-face:active {
    cursor: grabbing;
  }
  .modal-cropper .modal-dialog .modal-content .modal-header img {
    width: 90%;
  }
</style>
<script type="text/javascript" src="{{ asset('js/crop_profile.js') }}"></script>
<div id="cropModal" class="modal modal-cropper" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <img id="cropImg" alt="ユーザー画像">
      </div>
      <form class="modal-footer" action="{{ route('admin.logout') }}" method="POST">
        @csrf
        <button id="closeBtn" type="button" class="btn btn-secondary close-btn">閉じる</button>
        <button id="saveBtn" type="button" class="btn btn-primary">保存</button>
      </form>
    </div>
  </div>
</div>