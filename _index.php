<?php
$title = "AMS";
include 'files/header.php';
?>

<div class="container">
	<div class="row" id="contentArea">
		<div id="thesetting"></div>
		
	</div>
</div>

<?php
include 'files/footer.php';
?>
<script>
	function myAjax(type="GET", url, sucessResult, errorResult){
		$.ajax({
			type: type,
			url: url,
			success: function (e) {
				$('#'+sucessResult).prepend(e);
			},
			failure: function(r) {
				$('#'+errorResult).prepend(r);
			}
		});
	}
	
	myAjax(type="GET", 'files/setting.php', 'thesetting', "errorAlert");
	myAjax(type="GET", 'files/scanner.php', 'addScanner', "errorAlert");

	let camList;
	let SelectCam = {};
	let scanner;
	let camName;
	let camId;
	Instascan.Camera.getCameras().then(function(cameras){
		getMycameras(cameras);
		camList = cameras;
		// settingCam(cameras);
		console.log(camList);
		$(function(){
			var SelectedCam = function(sel){
				console.log(sel);
				for(let c = 0;c < camList.length;c++){
					// console.log(camList[c]['id']);
					if(camList[c]['id'] == sel){
						console.log(camList[c]['id']);
						camName = camList[c]['name'];
						camId = camList[c]['id'];
						scanner.start(camList[c]);
					}
				}
			};
			SelectCam.Cam = SelectedCam;
		});
	}).catch(function(e) {
	   console.error(e);
	});


	function getMycameras(cameras){
		// $.getJSON( "files/settings.json", function(data) {
		// 	// console.log(data);
		// 	let cameraName = '<option value="">Cameras</option>';
		// 	if(cameras.length > 0 ){
		// 	for(let i = 0; i < cameras.length; i++){
		// 		// console.log(cameras[i].name);
		// 		if(cameras[i].id == data.cameraId){
		// 			cameraName += '<option value="'+cameras[i].id+'" selected>'+cameras[i].name+'</option>';
		// 			SelectCam.Cam(data.cameraId);
		// 		}else{
		// 			cameraName += '<option value="'+cameras[i].id+'">'+cameras[i].name+'</option>';
		// 		}
				
		// 	}
		// 	$('#cameraName').html(cameraName);
		// 	// 	       scanner.start(cameras[1]);
		// 	} else{
		// 		$('#cameraName').html('No cameras found');
		// 	}
		// });	

		$.getJSON('files/setting.json')
    		.done(function (data, textStatus, jqXHR) { 
				// console.log(data);
				let cameraName = '<option value="">Cameras</option>';
				if(cameras.length > 0 ){
				for(let i = 0; i < cameras.length; i++){
					// console.log(cameras[i].name);
					if(cameras[i].id == data.cameraId){
						cameraName += '<option value="'+cameras[i].id+'" selected>'+cameras[i].name+'</option>';
						SelectCam.Cam(data.cameraId);
					}else{
						cameraName += '<option value="'+cameras[i].id+'">'+cameras[i].name+'</option>';
					}
					
				}
				$('#cameraName').html(cameraName);
				// 	       scanner.start(cameras[1]);
				} else{
					$('#cameraName').html('No cameras found');
				}
			 })
			.fail(function (jqXHR, textStatus, errorThrown) { alert('setting json file not exist') });






	}

	function saveSettings(){
		eventsholded = {
			"cameraName":camName,
			"cameraId":camId
		}
		$.ajax
		({
			type: "GET",
			dataType : 'json',
			async: false,
			url: 'files/ajaxSet.php',
			data: { data: JSON.stringify(eventsholded) },
			success: function () {alert("Thanks!"); },
			failure: function() {alert("Error!");}
		});
		// scanner.stop();
		$('#contentArea').append('<div class="col-8" id="addTutorial"></div>');
		myAjax(type="GET", 'files/tutorial.php', 'addTutorial', "errorAlert");
		$('#contentArea').append('<div class="col-4 " id="NewScanner"></div>');
		$('.scanner').appendTo('#NewScanner');
		
		$('#thesetting').remove();
		
		// for(let i = 0;i < camList.length;i++){
		// 	if(camList[i].id == camId){
		// 		scanner.start(camList[i][camId]);
		// 		console.log(camList);
		// 	}
		// }
		// console.log(camList);
		// console.log(camId);
		scanner.addListener('scan',function(c){
			console.log(c);
			$.getJSON( "localdatabase.json", function(data) {
				console.log('scanner worked');
				for(let i = 0; i < data.length ; i++){
					console.log('scanner working');
					if(data[i].NID == c){
						console.log( data[i].NID );
						// console.log(c);
						$('#contentArea').append('<div class="col-8 " id="userResult"></div>');
						myAjax(type="GET", 'files/userProfile.php', 'userResult', "errorAlert");
						myAjax(type="GET", 'files/qrinput.php', 'userResult', "errorAlert");
						// $('#qrcode').val(c);
						$('.addTutorial').remove();
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
						setInterval( function(){
							$('#qrcode').val("");
							$('.tutorial').show();
							$('#userResult').hide();
							$('.scanMessage').hide();
						}, 30000 );
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

	} 










// $('#cameraName').on('change', function() {
//   alert( this.value );
// });
// function settingCam(cameras){
//    if(cameras.length > 0 ){
//    		return cameras;
// // 	       scanner.start(cameras[1]);
//    } else{
//        alert('No cameras found');
//    }
// }

// $( "#cameraName" )
//   .change(function() {
//     var str = "";
//     $( "#cameraName option:selected" ).each(function() {
//       str += $( this ).val() + " ";
//     });
// //     $( "div" ).text( str );
//     console.log(str);
//     scanner.start(str);
//   })
//   .trigger( "change" );
</script>
</body>
</html>