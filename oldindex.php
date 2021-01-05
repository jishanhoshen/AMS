<html>
<head>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/webrtc-adapter/3.3.3/adapter.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.1.10/vue.min.js"></script>
  <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
</head>
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <video id="preview" width="100%"></video>
                </div>
                <div class="col-md-6">
                    <label>SCAN QR CODE</label>
                    <input type="text" name="text" id="text" readonyy="" placeholder="scan qrcode" class="form-control">
                </div>
            </div>
        </div>
        <script>
           let scanner = new Instascan.Scanner({ video: document.getElementById('preview'),mirror: false});
           Instascan.Camera.getCameras().then(function(cameras){
               if(cameras.length > 0 ){
                   scanner.start(cameras[1]);
               } else{
                   alert('No cameras found');
               }

           }).catch(function(e) {
               console.error(e);
           });

           scanner.addListener('scan',function(c){
              let id = document.getElementById('text').value=c;
            //   window.location.href='page.html?id='+id;
           });

        </script>
</html>