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
  let $form = $('#form');
  let $statusSelect = $('#statusSelect');

  $statusSelect.on('change', function () {
    $form.submit();
  });
})