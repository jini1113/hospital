//update image 
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
// block emp
$("#tbl_emp").on("click", ".active_block", function () {
    const json = { "id": $(this).attr("data-id") };
    console.log(json);
    $.ajax({
        type: "POST",
        method: "POST",
        url: "../crud.php?what=blockEmp",
        data: json,
        dataType: "JSON",
        success: function (response) {
            window.scrollTo({ "top": 0, "behavior": "smooth" });
            if (response["success"]) {
                $.bootstrapGrowl("<div class='text-center' style='background-color:#7dcea0;opacity:1;font-weight:bold'><h1>Success!</h1><p>" + response['message'] + "</p></div>",
                    {
                        delay: 2500,
                        width: 400,
                        offset: { "from": "top", "amount": 20 },
                        allow_dismiss: false,
                        align: "center",
                    });
                setTimeout(function () {
                    window.location.reload();
                }, 2500);
            }
            else {
                $.bootstrapGrowl("<div class='text-center' style='background-color:#ec7063;opacity:1;font-weight:bold'><h1>Error!</h1><p>" + response['message'] + "</p></div>",
                    {
                        delay: 2500,
                        width: 400,
                        offset: { "from": "top", "amount": 20 },
                        allow_dismiss: false,
                        align: "center",
                    });
            }
        }
    });
});
// active emp
$("#tbl_emp").on("click", ".block_active", function () {
    const json = { "id": $(this).attr("data-id") };
    console.log(json);
    $.ajax({
        type: "POST",
        method: "POST",
        url: "../crud.php?what=activeEmp",
        data: json,
        dataType: "JSON",
        success: function (response) {
            window.scrollTo({ "top": 0, "behavior": "smooth" });
            if (response["success"]) {
                $.bootstrapGrowl("<div class='text-center' style='background-color:#7dcea0;opacity:1;font-weight:bold'><h1>Success!</h1><p>" + response['message'] + "</p></div>",
                    {
                        delay: 2500,
                        width: 400,
                        offset: { "from": "top", "amount": 20 },
                        allow_dismiss: false,
                        align: "center",
                    });
                setTimeout(function () {
                    window.location.reload();
                }, 2500);
            }
            else {
                $.bootstrapGrowl("<div class='text-center' style='background-color:#ec7063;opacity:1;font-weight:bold'><h1>Error!</h1><p>" + response['message'] + "</p></div>",
                    {
                        delay: 2500,
                        width: 400,
                        offset: { "from": "top", "amount": 20 },
                        allow_dismiss: false,
                        align: "center",
                    });
            }
        }
    });
});
