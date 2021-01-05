<div class="settingsBg">
    <div class="setting theBox">
        <div class="row">
            <div class="col">
                <h1 class="d-flex justify-content-center mb-2">Camera Setting</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="form-outline">
                    <!-- <input type="text" name="text" id="qrcode" placeholder="scan qrcode" class="form-control" /> -->
                    <select name="" id="cameraName" class="form-control" onchange="SelectCam.Cam(this.value);">
                    </select>
                </div>
            </div>
            <div class="col-6" id="addScanner">
            </div>
        </div>
        <div class="row">
            <div class="col">
                <button type="button" class="btn btn-success" onclick="saveSettings()">Save</button>
            </div>
        </div>
    </div>
</div>