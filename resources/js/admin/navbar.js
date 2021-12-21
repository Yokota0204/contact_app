$(function() {
  let modal = $('#modal');
  let btn = $('#logoutBtn');
  let closeBtn = $('.close-btn');

  btn.on('click', function() {
    modal.fadeIn();
  });

  closeBtn.on('click', function() {
    modal.fadeOut();
  });

  $(document).on('click', function(e) {
    if(!$(e.target).closest('#pop_up').length && !$(e.target).closest('#logoutBtn').length){
      $('#modal').fadeOut();
    }
  });
})