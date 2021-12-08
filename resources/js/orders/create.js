$(function() {
  let closeErr = $('#closeErr');
  let alert = $('#alert');

  closeErr.on('click', function() {
    alert.slideUp(500);
  });

  let closeMsg = $('#closeMsg');
  let message = $('#message');

  closeMsg.on('click', function() {
    message.slideUp(500);
  });
})