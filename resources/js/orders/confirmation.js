$(function() {
  let btn = $('#btnBack');
  let form = $('#form');

  btn.click(function() {
    form.attr('action', '/orders/back_create');
    form.submit();
  })
})