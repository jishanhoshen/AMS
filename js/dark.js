let toggle = false;
let ThemeName;
$.getJSON( "files/darkConfig.json", function(data) {
    // // console.log( "success" );
    // console.log( data.ThemeName );
    ThemeName = data.ThemeName;
    TheaMood(ThemeName);
});
let ModeBtn = $('#ModeBtn');
ModeBtn.click(function(){
    if(ThemeName == "dark"){
        TheaMood('light');
        ThemeName = "light";
    }else{
        TheaMood('dark');
        ThemeName = "dark";
    }
});
function TheaMood(ThemeName) {
    let MoodImg = $('#MoodImg');
    let img1 = "sun.svg",
        img2 = "moon.svg";
    let eventsholded;
if(ThemeName == 'dark'){
    $('head').append( $('<link rel="stylesheet" type="text/css" id="sreachDark"/>').attr('href', 'files/Dark.css') );
    $('html, body, #preloader').addClass("darkBg");
    $('.gsc-result').addClass('theBox');
    $('.theBox, .card-body, .gsc-result').addClass("darkBox");
    $('html, body, .txt, p, h1, h2, h3, h4, h5, h6, a, button, input, span, svg, .gs-snippet').addClass("darkTxt");
    MoodImg.attr("src", img1);
    eventsholded = {"ThemeName":"dark"};
}else{
    $("#sreachDark").attr("disabled", "disabled");
    $('html, body, #preloader').removeClass("darkBg");
    $('.gsc-result').removeClass('theBox');
    $('.theBox, .card-body, .gsc-result').removeClass("darkBox");
    $('html, body, .txt, p, h1, h2, h3, h4, h5, h6, a, button, input, span, svg, .gs-snippet').removeClass("darkTxt");
    MoodImg.attr("src", img2);
    eventsholded = {"ThemeName":"light"};
}

    $.ajax
    ({
        type: "GET",
        dataType : 'json',
        async: false,
        url: 'files/darkMode.php',
        data: { data: JSON.stringify(eventsholded) },
        success: function () {alert("Thanks!"); },
        failure: function() {alert("Error!");}
    });

}