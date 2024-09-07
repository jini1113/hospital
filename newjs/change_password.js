$(document).ready(function() {
    $("#changpwd").click(function () {
        if ($("#txtFCur").val() == "" || $("#txtFCur").val() == null ||
            $("#txtFNew").val() == "" || $("#txtFNew").val() == null ||
            $("#txtFCon").val() == "" || $("#txtFCon").val() == null) {
            $.bootstrapGrowl("<div class='text-center' style='background-color:#ec7063;opacity:1;'><h1>Error!</h1><p>All fields are required.</p></div>", {
                delay: 2500,
                width: 400,
                offset: { "from": "top", "amount": 20 },
                allow_dismiss: false,
                align: "center",
            });
        } else if ($("#txtFNew").val() != $("#txtFCon").val()) {
            $.bootstrapGrowl("<div class='text-center' style='background-color:#7dcea0;opacity:1;'><h1>Error!</h1><p>New Password and Confirm password do not match.</p></div>", {
                delay: 2500,
                width: 400,
                offset: { "from": "top", "amount": 20 },
                allow_dismiss: false,
                align: "center",
            });
        } else {
            const json = {
                "old": $("#txtFCur").val(),
                "pwd": $("#txtFNew").val()
            };
            console.log(json);
            $.ajax({
                type: "POST",
                url: "crud.php?what=sendChangePwd", // Ensure this matches your PHP endpoint
                data: json,
                dataType: "json",
                success: function (response) {
                    console.log(response);
                    window.scrollTo({ "top": 0, "behavior": "smooth" });
                    if (response.success) {
                        $.bootstrapGrowl("<div class='text-center' style='background-color:#7dcea0;opacity:1;font-weight:bold;'><h1>Success!</h1><p>" + response.message + "</p></div>", {
                            delay: 2500,
                            width: 400,
                            offset: { "from": "top", "amount": 20 },
                            allow_dismiss: false,
                            align: "center",
                        });
                        setTimeout(function () {
                            if (response.role === "Admin") {
                                window.location.replace('admin/index.php');
                            } else if (response.role === "Doctor") {
                                window.location.replace('doctor/index.php');
                            } else {
                                window.location.replace('staff/index.php');
                            }
                        }, 2500);
                    } else {
                        $.bootstrapGrowl("<div class='text-center' style='background-color:#ec7063;opacity:1;font-weight:bold;'><h1>Error!</h1><p>" + response.message + "</p></div>", {
                            delay: 2500,
                            width: 400,
                            offset: { "from": "top", "amount": 20 },
                            allow_dismiss: false,
                            align: "center",
                        });
                    }
                },
                error: function () {
                    $.bootstrapGrowl("<div class='text-center' style='background-color:#ec7063;opacity:1;font-weight:bold;'><h1>Error!</h1><p>Failed to process request. Please try again.</p></div>", {
                        delay: 2500,
                        width: 400,
                        offset: { "from": "top", "amount": 20 },
                        allow_dismiss: false,
                        align: "center",
                    });
                }
            });
        }
    });
});
