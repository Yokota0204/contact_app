$(function() {
  // ファイル添付
  for(let i = 2; i <= 10; i++) {
    $('#file' + i).hide();
  }

  let minusBtn = $('#minusFile');
  let plusBtn = $('#plusFile');
  let $fileCount = $('#fileCount');
  let count = 1;

  $(plusBtn).on('click', function() {
    count++;
    $('#file' + count).show();
    $fileCount.val(count);
  });

  $(minusBtn).on('click', function() {
    $('#file' + count).hide();
    count--;
    $fileCount.val(count);
  });

  // ステータス更新
  let $statusForm = $('#statusForm');
  let $statusSelect = $('#statusSelect');

  $statusSelect.on('change', function () {
    $statusForm.submit();
  });

  // 担当者を更新
  let $inChargeForm = $('#inChargeForm');
  let $inChargeSelect = $('#inChargeSelect');

  $inChargeSelect.on('change', function () {
    $inChargeForm.submit();
  });

  // 返信内容確認モーダル
  const $confReply = $('#confReply');
  const $replyModal = $('#replyModal');
  const $submitReply = $('#submitReply');
  const $closeReplyConf = $('.close-reply-conf');

  $confReply.on('click', () => {
    $replyModal.show();
  });

  $closeReplyConf.on('click', () => {
    $replyModal.fadeOut();
  });

  $submitReply.on('click', () => {
    $replyModal.hide();
  });

  $(document).on('click', function(e) {
    if(!$(e.target).closest('#reply_confirmation_pop_up').length && !$(e.target).closest('#confReply').length){
      $replyModal.fadeOut();
    }
  });
})