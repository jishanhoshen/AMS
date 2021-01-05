
    <div class="scanner mt-4">
        <video id="preview" width="100%"></video>
        <script>
        scanner = new Instascan.Scanner({ video: document.getElementById('preview'),  mirror: false});
        </script>
    </div>
    <div class="scandata theBox mt-4">
        <div class="form-outline">
            <input type="text" name="text" id="qrcode" placeholder="scan qrcode" class="form-control" />
        </div>
    </div>
    <!-- <div class="scanMessage mt-4 py-4 px-3 alert alert-success" data-mdb-color="success" role="alert"></div>
