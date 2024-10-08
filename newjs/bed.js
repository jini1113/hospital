$("#frm").validate({
    rules: {
        "txtWard": {
            required: true,
        },
        "txtNo": {
            required: true,
        },
        "txtType": {
            required: true,
        },
        "txtPrice": {
            required: true,
        },
        "txtDes": {
            required: true,
        },
    },
    messages: {
        "txtWard": {
            required: "<span class='text-danger' style='font-size:small'>This field is required.</span>",
        },
        "txtNo": {
            required: "<span class='text-danger' style='font-size:small'>This field is required.</span>",
        },
        "txtType": {
            required: "<span class='text-danger' style='font-size:small'>This field is required.</span>",
        },
        "txtPrice": {
            required: "<span class='text-danger' style='font-size:small'>This field is required.</span>",
        },
        "txtDes": {
            required: "<span class='text-danger' style='font-size:small'>This field is required.</span>",
        },


    },
});
// block ward
$("#tbl_bed").on("click", ".active_block", function () {
    const json = { "id": $(this).attr("data-id") };
    console.log(json);
    $.ajax({
        type: "POST",
        method: "POST",
        url: "../crud.php?what=blockBed",
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
$("#tbl_bed").on("click", ".block_active", function () {
    const json = { "id": $(this).attr("data-id") };
    console.log(json);
    $.ajax({
        type: "POST",
        method: "POST",
        url: "../crud.php?what=activeBed",
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
// add bed

$("#txtType").change(function () {
    var selectedOption = $(this).find("option:selected");
    var price = selectedOption.data("price");
    $("#txtPrice").val(price); // Set the price input to the selected room type's price
});

$("#btnSubmit").click(function (event) {
    event.preventDefault();
    if ($("#frm").valid()) {
        var json = {
            txtNo: $("#txtNo").val(), // Ensure this matches the input field ID
            txtWard: $("#txtWard").val(),
            txtType: $("#txtType").val(), // Corrected to match the input field ID
            txtPrice: $("#txtPrice").val(),
            txtDes: $("#txtDes").val()
        };
        console.log(json);

        $.ajax({
            type: "POST",
            url: "../crud.php?what=addBed", // Removed redundant method
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
                        window.location.replace('bed.php');
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
// update bed
$("#btnUpdate").click(function (event) {
    event.preventDefault();
    if ($("#frm").valid()) {
        var formData = {
            txtUId: $("#txtUId").val(),
            txtBedno: $("#txtNo").val(), // Changed from txtBedno to txtNo
            txtWard: $("#txtWard").val(),
            txtRoom: $("#txtType").val(), // Added to capture room type
            txtPrice: $("#txtPrice").val(),
            txtDes: $("#txtDes").val()
        };
        $.ajax({
            type: "POST",
            url: "../crud.php?what=updateBed",
            data: formData,
            dataType: "JSON",
            success: function (response) {
                console.log(response); // Check the response in the console
                if (response.success) {
                    $.bootstrapGrowl("<div class='text-center' style='background-color:#7dcea0;opacity:1;font-weight:bold'><h1>Success!</h1><p>" + response.message + "</p></div>", {
                        delay: 2500,
                        width: 400,
                        offset: { "from": "top", "amount": 20 },
                        allow_dismiss: false,
                        align: "center",
                    });
                    setTimeout(function () {
                        window.location.replace('bed.php');
                    }, 2500);
                } else {
                    $.bootstrapGrowl("<div class='text-center' style='background-color:#ec7063;opacity:1;font-weight:bold'><h1>Error!</h1><p>" + response.message + "</p></div>", {
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