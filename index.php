<?php
$title = "AMS";
include 'files/header.php';
include 'files/preload.php';
if (!isset($_COOKIE["cameraId"])) {
    header('location:files/checkSetting.php');
}
?>
<div class="container">
    <div class="row" id="contentArea">
        <div class=" col-8 tutorial">
            <div class="theBox mt-4 py-4 px-3">
                <h1>Please Enter Your ID Card</h1>
            </div>
            <div class="theBox mt-4 py-4 px-3">
                <img src="imgs/tutorial.jpg">
            </div>
        </div>
        <div class="col-8" id="userResult">
            <div class="row">
                <div class="col-4">
                    <div class="profile theBox">
                        <div class="roundProfile mb-4 p-2">
                            <img class="userImage" src="https://lh3.googleusercontent.com/a-/AOh14GicZC9Yq5TLPgrnqodpLApUGrYS_8nbazLKg4lkMA=s300-c" alt="Jishan hoshen">
                        </div>
                    </div>
                </div>
                <div class="col-8">
                    <div class="bio theBox py-4 px-3 mt-4">
                        <div class="row">
                            <div class="col-3 fw-bold" id="empName">Name</div>
                            <div class="col-9" id="empNameVal"></div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-3 fw-bold" id="emlDep">Depertment</div>
                            <div class="col-9" id="emlDepVal"></div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-3 fw-bold" id="emlJob">Job</div>
                            <div class="col-9" id="emlJobVal"></div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-3 fw-bold" id="emlBirth">Birth</div>
                            <div class="col-9" id="emlBirthVal"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="details theBox py-4 px-3">
                        <div class="row mt-2">
                            <div class="col-3 fw-bold" id="empNid">NID</div>
                            <div class="col-9" id="empNidVal"></div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-3 fw-bold" id="empPhone">Phone </div>
                            <div class="col-9" id="empPhoneVal"></div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-3 fw-bold" id="empAddr">Address </div>
                            <div class="col-9" id="empAddrVal"></div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-3 fw-bold" id="empEmail">Email</div>
                            <div class="col-9" id="empEmailVal"></div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-3 fw-bold" id="empWeb">Website</div>
                            <div class="col-9" id="empWebVal"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="scanner mt-4">
                <video id="preview" width="100%"></video>
                <canvas id="canvas"></canvas>
            </div>
            <div class="scandata theBox mt-4">
                <div class="form-outline">
                    <input type="text" name="text" id="qrcode" placeholder="scan qrcode" class="form-control" />
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include 'files/footer.php';
?>
<script>
    $(document).ready(function() {
        let camId = "<?php echo $_COOKIE["cameraId"]; ?>";
        let camName = "<?php echo $_COOKIE["cameraName"]; ?>";
        let scanner;
        scanner = new Instascan.Scanner({
            video: document.getElementById('preview'),
            captureImage: true,
            refractoryPeriod: 10000,
            scanPeriod: 1,
            mirror: false
        });
        // scanner.addListener('scan', function (content) {
        //     capture();
        //     console.log(content);
        //     scanner.stop();
        // $('#preview').hide();
        // $('#canvas').show();
        //     $('.tutorial').hide();
        // 	$('#userResult').show();
        //     setTimeout(function(){
        //         mycamera();
        //         $('#preview').show();
        //         $('#canvas').hide();
        //         $('.tutorial').show();
        //         $('#userResult').hide();
        //     },10000);
        // });
        scanner.addListener('scan', function(c) {
            capture();
            console.log(c);
            scanner.stop();
            $.getJSON("localdatabase.json", function(data) {
                for (let i = 0; i < data.length; i++) {
                    if (data[i].NID == c) {
                        // console.log( data[i].NID );
                        // console.log(c);
                        // $('#contentArea').append('<div class="col-8 " id="userResult"></div>');
                        // myAjax(type="GET", 'files/userProfile.php', 'userResult', "errorAlert");
                        // myAjax(type="GET", 'files/qrinput.php', 'userResult', "errorAlert");
                        // // $('#qrcode').val(c);
                        $('#preview').hide();
                        $('#canvas').show();
                        $('.tutorial').hide();
                        $('#userResult').show();
                        $('.scanMessage').show();
                        $('.scanMessage').removeClass('alert-danger');
                        $('.scanMessage').addClass('alert-success');
                        $('.scanMessage').html("Scan Success !");
                        $('#empNameVal').html(data[i].Name);
                        $('#emlDepVal').html(data[i].Depertment);
                        $('#emlJobVal').html(data[i].Job);
                        $('#emlBirthVal').html(data[i].Birth);
                        $('#empNidVal').html(data[i].NID);
                        $('#empPhoneVal').html(data[i].Phone);
                        $('#empAddrVal').html(data[i].Address);
                        $('#empEmailVal').html(data[i].Email);
                        $('#empWebVal').html(data[i].Website);
                        // setInterval( function(){
                        // 	$('#qrcode').val("");
                        // 	$('.tutorial').show();
                        // 	$('#userResult').hide();
                        // 	$('.scanMessage').hide();
                        // }, 30000 );
                    }
                    //   else{
                    // $('#qrcode').val("");
                    // $('.tutorial').show();
                    // $('#userResult').hide();
                    // $('.scanMessage').show();
                    // $('.scanMessage').removeClass('alert-success');
                    // $('.scanMessage').addClass('alert-danger');
                    // $('.scanMessage').html("Not Valid !");
                    //   }
                }
            });
        });
        mycamera();

        function mycamera() {
            Instascan.Camera.getCameras().then(function(cameras) {
                if (cameras.length > 0) {
                    for (let i = 0; i < cameras.length; i++) {
                        if (cameras[i]['id'] == camId) {
                            console.log(cameras[i]['id']);
                            scanner.start(cameras[i]);
                        }
                    }
                } else {
                    console.error('No cameras found.');
                }
            }).catch(function(e) {
                console.error(e);
            });
        }

        function capture() {
            var canvas = document.getElementById('canvas');
            var video = document.getElementById('preview');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            canvas.getContext('2d').drawImage(video, 0, 0, video.videoWidth, video.videoHeight); // for drawing the video element on the canvas
        }

    });
</script>
</body>

</html>