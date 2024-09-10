$("#frm").validate({
    rules: {
        "txtName": {
            required: true,
        },

        "txtDate": {
            required: true,
        },


    },
    messages: {
        "txtName": {
            required: "<span class='text-danger' style='font-size:small'>This field is required.</span>",
        },

        "txtDate": {
            required: "<span class='text-danger' style='font-size:small'>This field is required.</span>",
        },

    },
});
// Block department
$("#tbl_holiday").on("click", ".active_block", function () {
    const json = { "id": $(this).attr("data-id") };
    console.log(json);
    $.ajax({
        type: "POST",
        url: "../crud.php?what=blockHoliday",
        data: json,
        dataType: "JSON",
        success: function (response) {
            window.scrollTo({ "top": 0, "behavior": "smooth" });
            if (response["success"]) {
                // Update button text and class without replacing the element
                const button = $("#tbl_holiday").find("[data-id='" + json.id + "']");
                button
                    .text("Block")
                    .removeClass("status-green active_block")
                    .addClass("status-red block_active");

                // Display success message
                $.bootstrapGrowl("<div class='text-center' style='background-color:#7dcea0;opacity:1;font-weight:bold'><h1>Success!</h1><p>" + response['message'] + "</p></div>", {
                    delay: 2500,
                    width: 400,
                    offset: { "from": "top", "amount": 20 },
                    allow_dismiss: false,
                    align: "center",
                });
            } else {
                // Display error message
                $.bootstrapGrowl("<div class='text-center' style='background-color:#ec7063;opacity:1;font-weight:bold'><h1>Error!</h1><p>" + response['message'] + "</p></div>", {
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

// Active department
$("#tbl_holiday").on("click", ".block_active", function () {
    const json = { "id": $(this).attr("data-id") };
    console.log(json);
    $.ajax({
        type: "POST",
        url: "../crud.php?what=activeHoliday",
        data: json,
        dataType: "JSON",
        success: function (response) {
            window.scrollTo({ "top": 0, "behavior": "smooth" });
            if (response["success"]) {
                // Update button text and class without replacing the element
                const button = $("#tbl_holiday").find("[data-id='" + json.id + "']");
                button
                    .text("Active")
                    .removeClass("status-red block_active")
                    .addClass("status-green active_block");

                // Display success message
                $.bootstrapGrowl("<div class='text-center' style='background-color:#7dcea0;opacity:1;font-weight:bold'><h1>Success!</h1><p>" + response['message'] + "</p></div>", {
                    delay: 2500,
                    width: 400,
                    offset: { "from": "top", "amount": 20 },
                    allow_dismiss: false,
                    align: "center",
                });
            } else {
                // Display error message
                $.bootstrapGrowl("<div class='text-center' style='background-color:#ec7063;opacity:1;font-weight:bold'><h1>Error!</h1><p>" + response['message'] + "</p></div>", {
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
// Add holidays
$("#btnSubmit").click(function (event) {
    event.preventDefault();
    if ($("#frm").valid()) {
        var json = {
            txtName: $("#txtName").val(),
            txtDate: $("#txtDate").val(),

        };
        console.log(json);

        $.ajax({
            type: "POST",
            method: "POST",
            url: "../crud.php?what=holidayadd",
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
                        window.location.replace('holidays.php');
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
// UPDATE holidays
$("#btnUpdate").click(function (event) {
    if ($("#frm").valid()) {
        event.preventDefault()
        const json = {
            "txtUId": $("#txtUId").val(),
            "txtName": $("#txtName").val(),
            "txtDate": $("#txtDate").val(),

        };
        console.log(json);
        $.ajax({
            type: "POST",
            method: "POST",
            url: "../crud.php?what=holidayup",
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
                        window.location.replace('holidays.php');
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
    }
});


