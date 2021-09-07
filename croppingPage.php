<?php
$currentPage = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

if ($_SERVER['REQUEST_METHOD'] == "GET" && strcmp(basename($currentPage), basename(__FILE__)) == 0 && !isset($_COOKIE['username']))
{
    http_response_code(404);
    // include('myCustom404.php'); // provide your own 404 error page
    die(); /* remove this if you want to execute the rest of
              the code inside the file before redirecting. */
}
?>

<html>
    <head>
        <title>Képkivágó Alkalmazás Tanuló Adatbázishoz</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css" integrity="sha512-0SPWAwpC/17yYyZ/4HSllgaK7/gg9OlVozq8K7rf3J8LvCjYEEIfzzpnA2/SSjpGIunCSD18r3UhvDcu/xncWA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>
    <style type="text/css">
        body{
          background-image: url('./bg/bg2.jpg');
          background-repeat: no-repeat;
          background-position: 0% 0%;
          background-size: 100% 100%;
          min-height: 100vh;
          min-width: 400px;
          font-family: "Roboto", sans-serif;
          -webkit-font-smoothing: antialiased;
          -moz-osx-font-smoothing: grayscale;
        }
        img {
            display: block;
            max-width: 100%;
        }
        .preview {
            overflow: hidden;
            width: 220px;
            height: 160px;
            margin: 10px;
            border: 1px solid red;
        }
        .modal-footer{
            border-top: none;
        }
        #demo{
            margin-top: 8px;
        }
        .welcome-text{
          min-width: 400px;
          margin-bottom: 50px;
        }
        .logout-button-container{
            text-align:right;
            min-width: 400px;
        }
        #card{
          margin-top: 40px;
          position: relative;
          z-index: 1;
          background: #FFFFFF;
          width: 400px;
          margin: 0 auto 100px;
          padding: 45px;
          text-align: center;
          box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
        }
        .container{
          text-align: center;
          margin-top: 100px;
        }
        #logout-button{
          margin-right: 20px;
          margin-top: 20px;
        }

    </style>
    <body>
      <div class="logout-button-container">
        <button class="btn btn-danger" id="logout-button" type="button" name="button">Kijelentkezés</button>
      </div>
        <div class="container">
            <h1 class="welcome-text">Üdv <span id="user-name-span"></span>!</h1>
            <div id="card">
              <h5>Képkivágó Alkalmazás Tanuló Adatbázishoz</h5>
              <form method="post">
                  <input type="file" name="image" class="image btn btn-primary mt-2">
              </form>
          </div>
        </div>

        <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel">Képkivágó</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="img-container">
                            <div class="row">
                                <div class="col-md-8">
                                    <img id="image">
                                </div>
                                <div class="col-md-4">
                                    <div class="preview"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div style="width:100%;display:flex;">
                        <button class="btn btn-primary" id="matering"><i class="fas fa-expand-alt"></i></button>
                            &nbsp;&nbsp;
                            <button class="btn btn-primary" id="cropping"><i class="fas fa-vector-square"></i></button>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <button class="btn btn-primary" id="rotate-left"><i class="fas fa-undo-alt"></i></button>
                            &nbsp;&nbsp;
                            <button class="btn btn-primary" id="rotate-right"><i class="fas fa-redo-alt"></i></button>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <button class="btn btn-primary" id="plus"><i class="fas fa-search-plus"></i></button>
                            &nbsp;&nbsp;
                            <button class="btn btn-primary" id="minus"><i class="fas fa-search-minus"></i></button>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <button class="btn btn-primary" id="left"><i class="fas fa-arrow-left"></i></button>
                            &nbsp;&nbsp;
                            <button class="btn btn-primary" id="right"><i class="fas fa-arrow-right"></i></button>
                            &nbsp;&nbsp;
                            <button class="btn btn-primary" id="up"><i class="fas fa-arrow-up"></i></button>
                            &nbsp;&nbsp;
                            <button class="btn btn-primary" id="down"><i class="fas fa-arrow-down"></i></button>
                        </div>
                    </div>
                    <div class="modal-footer" id="save-distance-container" style="display:none;">
                        <label>Távolság(pixel): </label>
                        <input type="number" disabled="true" id="distance-input-pixel">
                        <label>Távolság(mm): </label>
                        <input type="number" id="distance-input-mm">
                        &nbsp;&nbsp;
                        <button class="btn btn-warning" id="see-distance"><i class="fas fa-eye"></i></button>
                        &nbsp;&nbsp;
                        <button class="btn btn-success" id="save-distance"><i class="fas fa-check"></i></button>
                    </div>
                    <div class="modal-footer">
                        <div style="width:100%">
                            <label for="cars">Milyen bogár van a képen?</label>
                            <select id="bugs">
                                <option value="poloska" selected>poloska</option>
                                <option value="katicabogar">katicabogár</option>
                                <option value="szarvasbogar">szarvasbogár</option>
                                <option value="hangya">hangya</option>
                                <option value="pok" >pók</option>
                                <option value="meh" >méh</option>
                                <option value="darazs" >darázs</option>
                                <option value="kullancs" >kullancs</option>
                                <option value="krumplibogar" >krumplibogár</option>
                                <option value="tucsok" >tücsök</option>
                                <option value="saska" >sáska</option>
                                <option value="szunyog" >szúnyog</option>
                                <option value="legy" >légy</option>
                            </select>
                        </div>

                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Mégse</button>
                        <button type="button" class="btn btn-primary" id="crop">Mentés</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>


<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js" integrity="sha512-ooSWpxJsiXe6t4+PPjCgYmVfr1NS5QXJACcR/FPpsdm6kqG1FmQ2SVyg2RXeVuCRBLr0lWHnWJP6Zs1Efvxzww==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>

    function getCookie(name) {
      const value = `; ${document.cookie}`;
      const parts = value.split(`; ${name}=`);
      if (parts.length === 2) return parts.pop().split(';').shift();
    }

    var plus = document.getElementById('plus');
    var minus = document.getElementById('minus');
    var left = document.getElementById('left');
    var right = document.getElementById('right');
    var up = document.getElementById('up');
    var down = document.getElementById('down');
    var matering = document.getElementById('matering');
    var cropping = document.getElementById('cropping');
    var rotateLeft = document.getElementById('rotate-left');
    var rotateRight = document.getElementById('rotate-right');
    var saveDistanceContainer = document.getElementById('save-distance-container');
    var seeDistance = document.getElementById('see-distance');
    var saveDistance = document.getElementById('save-distance');
    var distanceInputPixel = document.getElementById('distance-input-pixel');
    var distanceInputmm = document.getElementById('distance-input-mm');
    var userNameSpan = document.getElementById('user-name-span');
    var logoutButton = document.getElementById('logout-button');

    userNameSpan.innerHTML = getCookie('username');

    logoutButton.addEventListener('click', function(){

      $.ajax({
          type: "GET",
          dataType: "json",
          url: "deleteSessionCookie.php",
          data: {},
          success: function() {

          }
      });

      location.href = "loginPage.php"
    });


    var bs_modal = $('#modal');
    var image = document.getElementById('image');
    var cropper,reader,file;


        $("body").on("change", ".image", function(e) {
            var files = e.target.files;
            var done = function(url) {
                image.src = url;
                bs_modal.modal('show');
        };


        if (files && files.length > 0) {
            file = files[0];

            if (URL) {
                done(URL.createObjectURL(file));
            } else if (FileReader) {
                reader = new FileReader();
                reader.onload = function(e) {
                    done(reader.result);
                };
                reader.readAsDataURL(file);
            }
        }
    });

    bs_modal.on('shown.bs.modal', function() {
        cropper = new Cropper(image, {
            preview: '.preview'
        });

        plus.addEventListener('click', function(){
            cropper.zoom(0.1);
        });
        minus.addEventListener('click', function(){
            cropper.zoom(-0.1);
        });
        left.addEventListener('click', function(){
            cropper.move(2,0);
        });
        right.addEventListener('click', function(){
            cropper.move(-2,0);
        });
        up.addEventListener('click', function(){
            cropper.move(0,2);
        });
        down.addEventListener('click', function(){
            cropper.move(0,-2);
        });
        rotateLeft.addEventListener('click', function(){
            cropper.rotate(-10);
        });
        rotateRight.addEventListener('click', function(){
            cropper.rotate(10);
        });
        cropping.addEventListener('click', function(){
            cropper.clear();
            setTimeout(() => {
                cropper.crop();
                let topLeft = document.querySelector('.cropper-point.point-nw');
                topLeft.style.backgroundColor = "#39f";
                topLeft.style.width = "5px";
                topLeft.style.height = "5px";
                let bottomRight = document.querySelector('.cropper-point.point-se');
                bottomRight.style.backgroundColor = "#39f";
                bottomRight.style.width = "5px";
                bottomRight.style.height = "5px";
                document.getElementById("crop").disabled = false;
                saveDistanceContainer.style.display = "none";
            }, 100);
        });
        matering.addEventListener('click', function(){
            cropper.clear();
            setTimeout(() => {
                cropper.crop();
                let topLeft = document.querySelector('.cropper-point.point-nw');
                topLeft.style.backgroundColor = "red";
                topLeft.style.width = "10px";
                topLeft.style.height = "10px";
                let bottomRight = document.querySelector('.cropper-point.point-se');
                bottomRight.style.backgroundColor = "red";
                bottomRight.style.width = "10px";
                bottomRight.style.height = "10px";
                document.getElementById("crop").disabled = true;
                saveDistanceContainer.style.display = "block";
            }, 100);
        });
        seeDistance.addEventListener('click', function(){
            let x1 = cropper.getData().x;
            let y1 = cropper.getData().y;
            let x2 = x1 + cropper.getData().width;
            let y2 = y1 + cropper.getData().height;
            let distance = Math.sqrt( Math.pow(x2-x1,2) + Math.pow(y2-y1,2) );
            distanceInputPixel.value = distance;
        });


    }).on('hidden.bs.modal', function() {
        cropper.destroy();
        cropper = null;
        location.reload();
    });

    $("#crop").click(function() {
        canvas = cropper.getCroppedCanvas({
            width: 160,
            height: 160,
        });

        canvas.toBlob(function(blob) {
            url = URL.createObjectURL(blob);
            var reader = new FileReader();
            reader.readAsDataURL(blob);
            reader.onloadend = function() {
                var base64data = reader.result;

                var select = document.getElementById("bugs");

                let imageName = file.name;
                let imageWidth = cropper.getImageData().naturalWidth;
                let imageHeight = cropper.getImageData().naturalHeight;
                let areaInitialX = cropper.getData().x;
                let areaInitialY = cropper.getData().y;
                let areaWidth = cropper.getData().width;
                let areaHeight = cropper.getData().height;
                var bug = select.value;

                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "uploadImageAction.php",
                    data: {
                      image: base64data,
                      imageName: imageName,
                      imageWidth: imageWidth,
                      imageHeight: imageHeight,
                      areaInitialX: areaInitialX,
                      areaInitialY: areaInitialY,
                      areaWidth: areaWidth,
                      areaHeight: areaHeight,
                      bug: bug
                    },
                    success: function(data) {
                        // bs_modal.modal('hide');
                        // alert("Data saved!");
                    }
                });
            };
        });

        alert("Sikeres adatrögzítés!");

        // bs_modal.modal('hide');

    });

    $("#save-distance").click(function() {

        let imageName = file.name;
        let imageWidth = cropper.getImageData().naturalWidth;
        let imageHeight = cropper.getImageData().naturalHeight;

        if(distanceInputPixel.value === '' || distanceInputmm.value === ''){
            alert('Mindkét távolság adatot ki kell tölteni az adatrögzítéshez!');
        }else{

            let distancePixel = distanceInputPixel.value;
            let distancemm = distanceInputmm.value;

            $.ajax({
                type: "POST",
                dataType: "json",
                url: "uploadDistanceAction.php",
                data: {
                  imageName: imageName,
                  imageWidth: imageWidth,
                  imageHeight: imageHeight,
                  distancePixel: distancePixel,
                  distancemm: distancemm
                },
                success: function() {
                    // bs_modal.modal('hide');
                    // alert("Data saved!");
                }
            });

            alert("Sikeres adatrögzítés!");
        }
    });

</script>
</body>
</html>
