$(function() {
  let $closeErr = $('#closeErr');
  let $alertMsgBox = $('#alertMsgBox');

  $closeErr.on('click', function() {
    $alertMsgBox.slideUp(500);
  });

  let $closeMsg = $('#closeMsg');
  let $msg = $('#msg');

  $closeMsg.on('click', function() {
    $msg.slideUp(500);
  });
})