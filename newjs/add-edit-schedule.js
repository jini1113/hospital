$("#frm").validate({
    rules: {
        "txtDoc": {
            required: true,
        },
        "txtDays": {
            required: true,
        },
        "txtFtime": {
            required: true,
        },
        "txtTotime": {
            required: true,
        },
        "txtMsg": {
            required: true,
        },
    },
    messages: {
        "txtDoc": {
            required: "<span class='text-danger' style='font-size:small'>This field is required.</span>",
        },
        "txtDays": {
            required: "<span class='text-danger' style='font-size:small'>This field is required.</span>",
        },
        "txtFtime": {
            required: "<span class='text-danger' style='font-size:small'>This field is required.</span>",
        },
        "txtTotime": {
            required: "<span class='text-danger' style='font-size:small'>This field is required.</span>",
        },
        "txtMsg": {
            required: "<span class='text-danger' style='font-size:small'>This field is required.</span>",
        },
    },
});
$("#btnSubmit").click(function (event) {
    event.preventDefault();
    if ($("#frm").valid()) {
        var formData = {
            // what: 'addschedule',
            txtDoc: $("#txtDoc").val(),
            txtDays: $("#txtDays").val(),
            txtFtime: $("#txtFtime").val(),
            txtTotime: $("#txtTotime").val(),
            txtMsg: $("#txtMsg").val()
        };
        console.log(formData);

        $.ajax({
            type: "POST",
            url: "../crud.php?what=addschedule",
            data: formData,
            dataType: "JSON",
            success: function (response) {
                console.log(response);
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
                        window.location.replace('schedule.php');
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
            },
            error: function (xhr, status, error) {
                console.error("Ajax error:", status, error);
                console.log("Response text:", xhr.responseText);
                alert("An error occurred. Please check the console for details.");
            }
        });
    }
});
$("#btnUpdate").click(function (event) {
    event.preventDefault();
    if ($("#frm").valid()) {
        var formData = {
            // what: 'addschedule',
            txtUId: $("#txtUId").val(),
            txtDoc: $("#txtDoc").val(),
            txtDays: $("#txtDays").val(),
            txtFtime: $("#txtFtime").val(),
            txtTotime: $("#txtTotime").val(),
            txtMsg: $("#txtMsg").val()
        };

        $.ajax({
            type: "POST",
            url: "../crud.php?what=updateschedule",
            data: formData,
            dataType: "JSON",
            success: function (response) {
                console.log(response);
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
                        window.location.replace('schedule.php');
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
            },
            error: function (xhr, status, error) {
                console.error("Ajax error:", status, error);
                console.log("Response text:", xhr.responseText);
                alert("An error occurred. Please check the console for details.");
            }
        });
    }
});
// block asset
$("#tbl_schedule").on("click", ".active_block", function () {
    const json = { "id": $(this).attr("data-id") };
    console.log(json);
    $.ajax({
        type: "POST",
        method: "POST",
        url: "../crud.php?what=blockSchedule",
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
// active asset
$("#tbl_schedule").on("click", ".block_active", function () {
    const json = { "id": $(this).attr("data-id") };
    console.log(json);
    $.ajax({
        type: "POST",
        method: "POST",
        url: "../crud.php?what=activeSchedule",
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
