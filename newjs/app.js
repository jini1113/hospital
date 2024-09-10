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
// block asset
$("#tbl_app").on("click", ".active_block", function () {
    const json = { "id": $(this).attr("data-id") };
    console.log(json);
    $.ajax({
        type: "POST",
        method: "POST",
        url: "../crud.php?what=blockApp",
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
$("#tbl_app").on("click", ".block_active", function () {
    const json = { "id": $(this).attr("data-id") };
    console.log(json);
    $.ajax({
        type: "POST",
        method: "POST",
        url: "../crud.php?what=activeApp",
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
$("#btnSubmit").click(function (event) {
    event.preventDefault();
    if ($("#frm").valid()) {
        var json = {
            txtPatient: $("#txtPatient").val(),
            txtPhone: $("#txtPhone").val(),
            txtMail: $("#txtMail").val(),
            txtDoc: $("#txtDoc").val(),
            txtDate: $("#txtDate").val(),
            txtTime: $("#txtTime").val(),
            txtMsg: $("#txtMsg").val()
        };
        console.log(json);

        $.ajax({
            type: "POST",
            method : "POST",
            url: "../crud.php?what=addappoi",
            data: json,
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
                        window.location.replace('appointments.php');
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

        });
    }
});
$("#btnUpdate").click(function (event) {
    event.preventDefault();
    if ($("#frm").valid()) {
        var json = {
            txtUId: $("#txtUId").val(), // {{ edit_1 }} Added to include user ID
            txtPatient: $("#txtPatient").val(),
            txtPhone: $("#txtPhone").val(),
            txtMail: $("#txtMail").val(),
            txtDoc: $("#txtDoc").val(),
            txtDate: $("#txtDate").val(),
            txtTime: $("#txtTime").val(),
            txtMsg: $("#txtMsg").val()
        };
        console.log(json);

        $.ajax({
            type: "POST",
            method : "POST",
            url: "../crud.php?what=upappoi",
            data: json,
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
                        window.location.replace('appointments.php');
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

        });
    }
});