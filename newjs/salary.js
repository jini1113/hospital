$("#frm").validate({
    rules: {
        "txtEmp": {
            required: true,
        },
        "txtAmt": {
            required: true,
        },
        "txtType": {
            required: true,
        },
        "txtDes": {
            required: true,
        },
    },
    messages: {
        "txtEmp": {
            required: "<span class='text-danger' style='font-size:small'>This field is required.</span>",
        },
        "txtAmt": {
            required: "<span class='text-danger' style='font-size:small'>This field is required.</span>",
        },
        "txtType": {
            required: "<span class='text-danger' style='font-size:small'>This field is required.</span>",
        },
        "txtDes": {
            required: "<span class='text-danger' style='font-size:small'>This field is required.</span>",
        },


    },
});
//add salary
$("#btnSubmit").click(function (event) {
    event.preventDefault();
    if ($("#frm").valid()) {
        var formData = {
            // what: 'addsalary',
            txtEmp: $("#txtEmp").val(),
            txtAmt: $("#txtAmt").val(),
            txtType: $("#txtType").val(),
            // txtDate: $("#txtDate").val(),
            txtDes: $("#txtDes").val()
        };
        console.log(formData);

        $.ajax({
            type: "POST",
            url: "../crud.php?what=addsalary",
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
                        window.location.replace('salary.php');
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
//update salary 
$("#btnUpdate").click(function (event) {
    event.preventDefault();
    if ($("#frm").valid()) {
        var formData = {
            txtUId: $("#txtUId").val(),
            txtEmp: $("#txtEmp").val(),
            txtAmt: $("#txtAmt").val(),
            txtType: $("#txtType").val(), // Ensure this retrieves the selected value
            txtDate: $("#txtDate").val(),
            txtDes: $("#txtDes").val()
        };
        $.ajax({
            type: "POST",
            url: "../crud.php?what=updatesalary",
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
                        window.location.replace('salary.php');
                    }, 2500);
                } else {
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

// pending status of salary
// $("#tbl_salary").on("click", ".active_block", function () {

//     const json = { "id": $(this).attr("data-id") };
//     console.log(json);
//     $.ajax({
//         type: "POST",
//         method: "POST",
//         url: "../crud.php?what=salUnPaid",
//         data: json,
//         dataType: "JSON",
//         success: function (response) {
//             window.scrollTo({ "top": 0, "behavior": "smooth" });
//             if (response["success"]) {
//                 $.bootstrapGrowl("<div class='text-center' style='background-color:#7dcea0;opacity:1;font-weight:bold'><h1>Success!</h1><p>" + response['message'] + "</p></div>",
//                     {
//                         delay: 2500,
//                         width: 400,
//                         offset: { "from": "top", "amount": 20 },
//                         allow_dismiss: false,
//                         align: "center",
//                     });
//                 setTimeout(function () {
//                     window.location.reload();
//                 }, 2500);
//             }
//             else {
//                 $.bootstrapGrowl("<div class='text-center' style='background-color:#ec7063;opacity:1;font-weight:bold'><h1>Error!</h1><p>" + response['message'] + "</p></div>",
//                     {
//                         delay: 2500,
//                         width: 400,
//                         offset: { "from": "top", "amount": 20 },
//                         allow_dismiss: false,
//                         align: "center",
//                     });
//             }
//         }
//     });

// });
