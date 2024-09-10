// block department
$("#tbl_issue").on("click", ".active_block", function () {
    const json = { "id": $(this).attr("data-id") };
    console.log(json);
    $.ajax({
        type: "POST",
        method: "POST",
        url: "../crud.php?what=blockIssue",
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
// active department
$("#tbl_issue").on("click", ".block_active", function () {
    const json = { "id": $(this).attr("data-id") };
    console.log(json);
    $.ajax({
        type: "POST",
        method: "POST",
        url: "../crud.php?what=activeIssue",
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
$("#frm").validate({
    rules: {
        "txtPatient": {
            required: true,
        },
        "txtDoc": {
            required: true,
        },
        "txtDonor": {
            required: true,
        },
        "txtGrp": {
            required: true,
        },
        "txtAmt": {
            required: true,
        },
        "txtUse": {
            required: true,
        },
        "txtDate": {
            required: true,
        },


    },
    messages: {
        "txtPatient": {
            required: "<span class='text-danger' style='font-size:small'>This field is required.</span>",
        },
        "txtGrp": {
            required: "<span class='text-danger' style='font-size:small'>This field is required.</span>",
        },
        "txtDoc": {
            required: "<span class='text-danger' style='font-size:small'>This field is required.</span>",
        },
        "txtDonor": {
            required: "<span class='text-danger' style='font-size:small'>This field is required.</span>",
        },
        "txtDate": {
            required: "<span class='text-danger' style='font-size:small'>This field is required.</span>",
        },
        "txtAmt": {
            required: "<span class='text-danger' style='font-size:small'>This field is required.</span>",
        },
        "txtUse": {
            required: "<span class='text-danger' style='font-size:small'>This field is required.</span>",
        },

    },
});
// Add In pationts
$("#btnSubmit").click(function (event) {
    if ($("#frm").valid()) {
        event.preventDefault();
        const json = {
            "txtDate": $("#txtDate").val(),
            "txtPatient": $("#txtPatient").val(),
            "txtDoc": $("#txtDoc").val(),
            "txtDonor": $("#txtDonor").val(),
            "txtGrp": $("#txtGrp").val(),
            "txtAmt": $("#txtAmt").val(),
            "txtUse": $("#txtUse").val(),

        };
        // console.log(json);
        $.ajax({
            type: "POST",
            method: "POST",
            url: "../crud.php?what=issueadd",
            data: json,
            dataType: "JSON",
            success: function (response) {
                // console.log(response);
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
                        window.location.replace('blood-issue.php');
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
// UPDATE IN pationts
$("#btnUpdate").click(function (event) {
    if ($("#frm").valid()) {
        event.preventDefault()
        const json = {
            "txtUId": $("#txtUId").val(),
            "txtDate": $("#txtDate").val(),
            "txtPatient": $("#txtPatient").val(),
            "txtDoc": $("#txtDoc").val(),
            "txtDonor": $("#txtDonor").val(),
            "txtGrp": $("#txtGrp").val(),
            "txtAmt": $("#txtAmt").val(),
            "txtUse": $("#txtUse").val(),
        };
        console.log(json);
        $.ajax({
            type: "POST",
            method: "POST",
            url: "../crud.php?what=issueup",
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
                        window.location.replace('blood-issue.php');
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
