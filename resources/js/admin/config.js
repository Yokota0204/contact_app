const { cssNumber } = require("jquery");

$(function () {
  // 表示切り替え
  let confProf = $('#confProf');
  let confUser = $('#confUser');
  var selected = confProf;

  let menuProf = $('#menuProf');
  let menuUser = $('#menuUser');
  var activeMenu = menuProf;

  selected.show();

  menuProf.on('click', function() {
    toggleConf('profile');
  });

  menuUser.on('click', function() {
    toggleConf('user');
  });

  function toggleConf(menu) {
    let menus = {
      profile: { menu: menuProf, conf: confProf },
      user: { menu: menuUser, conf: confUser }
    };

    selected.hide();
    activeMenu.removeClass('active');
    selected = menus[menu].conf;
    activeMenu = menus[menu].menu;
    selected.show();
    activeMenu.addClass('active');
  }

  // チェックボックス 全選択
  const selectedColor = '#D0E4FD';
  const unSelectedColor = '#f8fafc';

  const selectedBorderBtm = '1px solid #ccc';
  const unSelectedBorderBtm = '1px solid #eee';

  const selectedStyle = {
    backgroundColor: selectedColor,
    'border-bottom': selectedBorderBtm,
  };

  const unSelectedStyle = {
    backgroundColor: unSelectedColor,
    'border-bottom': unSelectedBorderBtm,
  };

  let $checkAll = $('#checkAll');
  let $userChecks = $('.user .check input');

  let $userRows = $('.user');

  $checkAll.on('change', function () {
    if ($checkAll.prop('checked')) {
      $userChecks.prop('checked', true);
      $userRows.css(selectedStyle);
    } else {
      $userChecks.prop('checked', false);
      $userRows.css(unSelectedStyle);
    }
  });

  // チェックボックス 単体選択
  $userRows.on('click', function () {
    let $check = $(this).children('.check').children('input');
    let isChecked = $check.prop('checked');

    if (isChecked) {
      $check.prop('checked', false);
      $(this).css(unSelectedStyle);
    } else {
      $check.prop('checked', true);
      $(this).css(selectedStyle);
    }
  });

  // 削除モーダル
  let $deleteBtn = $('#deleteBtn');
  let $deleteModal = $('#deleteModal');
  let $closeBtn = $('.delete-modal-close');

  $deleteBtn.on('click', function () {
    $deleteModal.show()
  });

  $closeBtn.on('click', function () {
    $deleteModal.fadeOut();
  });

  $(document).on('click', function(e) {
    if(!$(e.target).closest('#deletePopUp').length && !$(e.target).closest('#deleteBtn').length){
      $deleteModal.fadeOut();
    }
  });
});