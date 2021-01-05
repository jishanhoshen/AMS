<?php
$myFile = "setting.json";
if(file_exists($myFile)){
    echo "file is exist";
    clearstatcache();
    if(filesize($myFile)) {
        $fh = fopen($myFile, 'r') or die("can't open file");
        $dta = fread($fh,filesize($myFile));
        $josonData = json_decode($dta, true);
        if($josonData['cameraName'] == '' && $josonData['cameraId'] == ''){
            echo " no cameraName exist";
            echo " no cameraId exist";
        }else{
            setcookie("cameraName", $josonData['cameraName'], time() + (86400 * 30), "/"); // 86400 = 1 day
            setcookie("cameraId", $josonData['cameraId'], time() + (86400 * 30), "/"); // 86400 = 1 day
            header('location:../index.php');
        }
    }else{
        echo " but file is empty";
    }
    // $fh = fopen($myFile, 'r') or die("can't open file");
    // $dta = fread($fh,filesize($myFile));
    // $josonData = json_decode($dta, true);
    // setcookie("cameraName", $josonData['cameraName'], time() + (86400 * 30), "/"); // 86400 = 1 day
    // setcookie("cameraId", $josonData['cameraId'], time() + (86400 * 30), "/"); // 86400 = 1 day
    // // fwrite($fh, $stringData);
    // // fclose($fh);
    // // return true;
}





?>