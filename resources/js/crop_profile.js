import Cropper from 'cropperjs';

$(function () {
  // 画像切り抜き
  let $imgInput = $('#imgInput');

  let $modalCrop = $('#cropModal');
  let closeBtn = $('#closeBtn');
  let saveBtn = $('#saveBtn');

  let cropImgEl = document.getElementById('cropImg');
  let userImg = document.getElementById('userImg');

  let cropper;
  let croppable;

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
    $modalCrop.fadeOut();
  });

  saveBtn.on('click', function () {
    let croppedCanvas, roundedCanvas;

    if (!croppable) {
      console.log("false");
      return;
    }

    croppedCanvas = cropper.getCroppedCanvas();
    roundedCanvas = getRoundedCanvas(croppedCanvas);
    userImg.src = roundedCanvas.toDataURL()

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