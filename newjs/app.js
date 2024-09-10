$("#frm").validate({
    rules: {
        "txtDoc": {
            required: true,
        },
        "txtPatient": {
            required: true,
        },
        "txtMail":
            {
                required: true,
                email: true,
            },
            "txtPhone":
            {
                required: true,
                minlength: 10,
                maxlength: 10,
                pattern: "^[0-9]{10}$",
            },
        "txtDate": {
            required: true,
        },
        "txtTime": {
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
        "txtPatient": {
            required: "<span class='text-danger' style='font-size:small'>This field is required.</span>",
        },
        "txtMail":
        {
            required: "<span class='text-danger' style='font-size:small'>This feild is required.</span>",
            email: "<span class='text-danger' style='font-size:small;'>Your email address must be in this format name@domain.com</span>",
        },
        "txtPhone":
        {
            required: "<span class='text-danger' style='font-size:small'>This feild is required.</span>",
            minlength: "<span class='text-danger' style='font-size:small;'>This phone no must be minimum 10 digit required.</span>",
            maxlength: "<span class='text-danger' style='font-size:small'>This phone no must be maximum 10 digit required.</span>",
            pattern: "<span class='text-danger' style='font-size:small'>This phone no must be 0-9 digit only and only 10 digit allow. </span>"
        },
        "txtTime": {
            required: "<span class='text-danger' style='font-size:small'>This field is required.</span>",
        },
        "txtDate": {
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
            method: "POST",
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
            method: "POST",
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