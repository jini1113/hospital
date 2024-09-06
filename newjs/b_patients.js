$("#txtWard").on("change", function () {
    const wardId = $(this).val();
    $.ajax({
        type: "POST",
        url: "../crud.php?what=getInBed",
        data: { wardId: wardId },
        dataType: "JSON",
        success: function (response) {
            console.log(response);
            var s = "<option value=''>Select</option>";
            for (var i = 0; i < response.length; i++) {
                s += "<option value='" + response[i].bed_no + "'>" + response[i].bed_no + "</option>";
            }
            $("#txtBno").html(s);
        }
    });
});
// get city on update time
$("#txtWard").on("change", function () {
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
            $("#txtBno").html(s);
        }
    });
});
$("#txtWard").trigger("change");