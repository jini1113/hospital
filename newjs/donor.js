// block department
$("#tbl_donor").on("click", ".active_block", function () {
    const json = { "id": $(this).attr("data-id") };
    console.log(json);
    $.ajax({
        type: "POST",
        method: "POST",
        url: "../crud.php?what=blockDonor",
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
$("#tbl_donor").on("click", ".block_active", function () {
    const json = { "id": $(this).attr("data-id") };
    console.log(json);
    $.ajax({
        type: "POST",
        method: "POST",
        url: "../crud.php?what=activeDonor",
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
    rules :{
        "txtName" :{
            required: true,
        },
        "txtGrp" :{
            required: true,
        },
        "txtMail" :{
            required: true,
        },
        "txtPhone" :{
            required: true,
        },
        "txtDate" :{
            required: true,
        },
       
     
    },
    messages: {
        "txtName": {
            required: "<span class='text-danger' style='font-size:small'>This field is required.</span>",
        },
        "txtGrp": {
            required: "<span class='text-danger' style='font-size:small'>This field is required.</span>",
        },
        "txtMail": {
            required: "<span class='text-danger' style='font-size:small'>This field is required.</span>",
        },
        "txtPhone": {
            required: "<span class='text-danger' style='font-size:small'>This field is required.</span>",
        },
        "txtDate": {
            required: "<span class='text-danger' style='font-size:small'>This field is required.</span>",
        },
       
    },
});
// Add Donor
$("#btnSubmit").click(function (event) {
    if ($("#frm").valid()) {
        event.preventDefault();
        const json = { "txtName": $("#txtName").val(),
            "txtGrp": $("#txtGrp").val(),
            "txtMail": $("#txtMail").val(),
            "txtPhone": $("#txtPhone").val(),
            "txtDate": $("#txtDate").val(),
           
            };
        console.log(json);
        $.ajax({
            type: "POST",
            method: "POST",
            url: "../crud.php?what=donoradd",
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
                        window.location.replace('donors.php');
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
 // UPDATE Donor
 $("#btnUpdate").click(function (event) {
    if ($("#frm").valid()) {
        event.preventDefault()
        const json = { "txtUId": $("#txtUId").val(),
            "txtName": $("#txtName").val(),
            "txtGrp": $("#txtGrp").val(),
            "txtMail": $("#txtMail").val(),
            "txtPhone": $("#txtPhone").val(),
            "txtDate": $("#txtDate").val(),
            };
        console.log(json);
        $.ajax({
            type: "POST",
            method: "POST",
            url: "../crud.php?what=donorupdate",
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
                        window.location.replace('donors.php');
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
