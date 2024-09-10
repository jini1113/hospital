$("#requeted").click(function () {
    $("#view1").hide();
    $("#view2").hide();
    $("#view2").removeAttr("hidden").show();
    $("#requeted").removeClass("txt_header").addClass("txt1");
    $("#active").removeClass("txt1").addClass("txt_header");
});
$("#active").click(function () {
    $("#view1").hide();
    $("#view2").hide();
    $("#view1").removeAttr("hidden").show();
    $("#active").removeClass("txt_header").addClass("txt1");
    $("#requeted").removeClass("txt1").addClass("txt_header");
});
