import Cropper from 'cropperjs';

$(function () {
  // 画像切り抜き
  let $imgInput = $('#imgInput');

  let $modalCrop = $('#cropModal');
  let closeBtn = $('#closeBtn');
  let saveBtn = $('#saveBtn');

  let cropImgEl = document.getElementById('cropImg');
  let userImg = document.getElementById('userImg');
  let headerIcon = document.getElementById('headerIcon');

  let cropper;
  let croppable;

  let $failUpload = $('#failUpload');
  if($failUpload) $failUpload.hide();

  $imgInput.on('change', function(e){
    let reader;
    let file = e.target.files[0];

    if(file.type.indexOf("image") < 0){
      alert("画像ファイルを指定してください。");
      return false;
    }

    let done = function(url) {
      cropImgEl.src = url;
    }

    if (URL) {
      done(URL.createObjectURL(file));
    } else if (FileReader) {
      reader = new FileReader();
      reader.onload = function(e){
        done(reader.result);
      };
      reader.readAsDataURL(file);
    }

    if (cropper instanceof Cropper) {
      cropper.destroy();
    }
    cropper = cropField(cropImgEl);
    $modalCrop.show();
  });

  closeBtn.on('click', function () {
    $imgInput.val(null);
    $modalCrop.fadeOut();
  });

  saveBtn.on('click', function () {
    let croppedCanvas, roundedCanvas;

    if (!croppable) {
      return;
    }

    croppedCanvas = cropper.getCroppedCanvas();
    roundedCanvas = getRoundedCanvas(croppedCanvas);

    roundedCanvas.toBlob(function(blob) {
      let reader = new FileReader();
      reader.readAsDataURL(blob);
      reader.onloadend = function() {
        var base64data = reader.result;
        $.ajax({
          type: 'POST',
          header:{
            'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
          },
          url: '/admin/update_avatar/' + Admin.uid,
          data: {
            _token: csrf_token,
            dataType: 'json',
            contentType:'application/json',
            image: base64data,
          },
          dataType: 'json', //json形式で受け取る
          // beforeSend: function () {
          // } // ajax送信前の処理
        }).done(function (data) {
          console.log(data);
          if (data == 'success') {
            $failUpload.hide();
            userImg.src = roundedCanvas.toDataURL();
            headerIcon.src = roundedCanvas.toDataURL();
          } else {
            $failUpload.show();
            $imgInput.val(null);
            $failUpload.show();
          }
        }).fail(function () {
          $imgInput.val(null);
          $failUpload.show();
          console.log('Something failed in ajax.');
        });
      }
    });

    $modalCrop.fadeOut();
  })

  function cropField(image) {
    croppable = false;
    return new Cropper(image, {
      aspectRatio: 1,
      viewMode: 1,
      ready: function () {
        croppable = true;
      },
    });
  }

  function getRoundedCanvas(sourceCanvas) {
    var canvas = document.createElement('canvas');
    var context = canvas.getContext('2d');
    var width = sourceCanvas.width;
    var height = sourceCanvas.height;

    canvas.width = width;
    canvas.height = height;
    context.imageSmoothingEnabled = true;
    context.drawImage(sourceCanvas, 0, 0, width, height);
    context.globalCompositeOperation = 'destination-in';
    context.beginPath();
    context.arc(width / 2, height / 2, Math.min(width, height) / 2, 0, 2 * Math.PI, true);
    context.fill();
    return canvas;
  }
});