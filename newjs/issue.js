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