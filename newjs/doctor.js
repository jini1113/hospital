$("#txtImg").on("change", function () {
    var img = this;
    console.log(img);
    if (img.files && img.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $("#txtImport").attr("src", e.target.result);
        }
        reader.readAsDataURL(img.files[0]);
    }

});
// get city on insert time
$("#txtState").on("change", function () {
    const json = { "state": $(this).val() };
    // console.log(json);
    $.ajax({
        type: "POST",
        method: "POST",
        url: "../crud.php?what=getInsCityV",
        data: json,
        dataType: "JSON",
        success: function (response) {
            console.log(response);
            var s = "<option value=''>Select</option>";
            for (var i = 0; i < response.length; i++) {
                s += "<option value=" + response[i].id + ">" + response[i].name + "</option>";
            }
            $("#txtCity").html(s);
        }
    });
});
// get city on update time
$("#txtState").on("change", function () {
    const json = { "main": $("#txtUId").val(), "id": $(this).val() };
    // console.log(json);
    $.ajax({
        type: "POST",
        method: "POST",
        url: "../crud.php?what=retUCity",
        data: json,
        dataType: "JSON",
        success: function (response) {
            // console.log(response);
            var s = "<option value=''>Select</option>";
            for (var i = 0; i < response.city.length; i++) {
                s += `<option value='` + response.city[i].id + `' ${(response.city_id == response.city[i].id) ? "selected" : ""}>` + response.city[i].name + `</option>`;
            }
            $("#txtCity").html(s);
        }
    });
});
$("#txtState").trigger("change");