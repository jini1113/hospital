// get city on insert time
$("#txtState").on("change", function () {
    const json = { "state": $(this).val() };
    // console.log(json);
    $.ajax({
        type: "POST",
        method: "POST",
        url: "../crud.php?what=getInsCityV",
        data: json,
        dataType: "JSON",
        success: function (response) {
            console.log(response);
            var s = "<option value=''>Select</option>";
            for (var i = 0; i < response.length; i++) {
                s += "<option value=" + response[i].id + ">" + response[i].name + "</option>";
            }
            $("#txtCity").html(s);
        }
    });
});
// get city on update time
$("#txtState").on("change", function () {
    const json = { "main": $("#txtUId").val(), "id": $(this).val() };
    // console.log(json);
    $.ajax({
        type: "POST",
        method: "POST",
        url: "../crud.php?what=retUCity",
        data: json,
        dataType: "JSON",
        success: function (response) {
            // console.log(response);
            var s = "<option value=''>Select</option>";
            for (var i = 0; i < response.city.length; i++) {
                s += `<option value='` + response.city[i].id + `' ${(response.city_id == response.city[i].id) ? "selected" : ""}>` + response.city[i].name + `</option>`;
            }
            $("#txtCity").html(s);
        }
    });
});
$("#txtState").trigger("change");
// block patients
$("#tbl_patients").on("click", ".active_block", function () {
    const json = { "id": $(this).attr("data-id") };
    console.log(json);
    $.ajax({
        type: "POST",
        method: "POST",
        url: "../crud.php?what=blockPatient",
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
// active patients
$("#tbl_patients").on("click", ".block_active", function () {
    const json = { "id": $(this).attr("data-id") };
    console.log(json);
    $.ajax({
        type: "POST",
        method: "POST",
        url: "../crud.php?what=activePatient",
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

// Add Patients
$("#btnSubmit").click(function (event) {
    if ($("#frm").valid()) {
        event.preventDefault();
        const json = {
            "txtName": $("#txtName").val(),
            "txtMail": $("#txtMail").val(),
            "txtPhone": $("#txtPhone").val(),
            "txtDob": $("#txtDob").val(),
            "txtAdd": $("#txtAdd").val(),
            "txtGen": $("#txtGen").val(),
            "txtState": $("#txtState").val(),
            "txtCity": $("#txtCity").val(),
        };

        console.log(json);
        $.ajax({
            type: "POST",
            url: "../crud.php?what=patientadd",
            data: json,
            dataType: "JSON",
            success: function (response) {
                console.log(response);
                window.scrollTo({ "top": 0, "behavior": "smooth" });
                if (response["success"]) {
                    $.bootstrapGrowl("<div class='text-center' style='background-color:#7dcea0;opacity:1;font-weight:bold'><h1>Success!</h1><p>" + response['message'] + "</p></div>", {
                        delay: 2500,
                        width: 400,
                        offset: { "from": "top", "amount": 20 },
                        allow_dismiss: false,
                        align: "center",
                    });
                    setTimeout(function () {
                        window.location.replace('patients.php');
                    }, 2500);
                } else {
                    $.bootstrapGrowl("<div class='text-center' style='background-color:#ec7063;opacity:1;font-weight:bold'><h1>Error!</h1><p>" + response['message'] + "</p></div>", {
                        delay: 2500,
                        width: 400,
                        offset: { "from": "top", "amount": 20 },
                        allow_dismiss: false,
                        align: "center",
                    });
                }
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
                $.bootstrapGrowl("<div class='text-center' style='background-color:#ec7063;opacity:1;font-weight:bold'><h1>Error!</h1><p>Something went wrong. Please try again.</p></div>", {
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

// UPDATE Donor
$("#btnUpdate").click(function (event) {
    if ($("#frm").valid()) {
        event.preventDefault();
        const json = {
            "txtUId": $("#txtUId").val(),
            "txtName": $("#txtName").val(),
            "txtAdd": $("#txtAdd").val(),
            "txtState": $("#txtState").val(),
            "txtCity": $("#txtCity").val(),
            "txtGen": $("#txtGen").val(),
            "txtDob": $("#txtDob").val(),
            "txtMail": $("#txtMail").val(),
            "txtPhone": $("#txtPhone").val(),
        };

        $.ajax({
            type: "POST",
            url: "../crud.php?what=patientupdate",
            data: json,
            dataType: "JSON",
            success: function (response) {
                window.scrollTo({ "top": 0, "behavior": "smooth" });
                if (response["success"]) {
                    $.bootstrapGrowl("<div class='text-center' style='background-color:#7dcea0;opacity:1;font-weight:bold'><h1>Success!</h1><p>" + response['message'] + "</p></div>", {
                        delay: 2500,
                        width: 400,
                        offset: { "from": "top", "amount": 20 },
                        allow_dismiss: false,
                        align: "center",
                    });
                    setTimeout(function () {
                        window.location.replace('patients.php');
                    }, 2500);
                } else {
                    $.bootstrapGrowl("<div class='text-center' style='background-color:#ec7063;opacity:1;font-weight:bold'><h1>Error!</h1><p>" + response['message'] + "</p></div>", {
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


$("#frm").validate({
    rules: {

        "txtName": {
            required: true,
            minlength: 3,
            pattern: "^[a-zA-Z ]{3,}$",
        },
        "txtAdd": {
            required: true,
        },
        "txtState": {
            required: true,
        },
        "txtCity": {
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
        "txtGen": {
            required: true,
        },
        "txtDob":
        {
            required: true,

        },
       
    },
    messages: {

        "txtName":
        {
            required: "<span class='text-danger'  style='font-size:small'>This feild is required.</span>",
        },
        "txtAdd":
        {
            required: "<span class='text-danger'  style='font-size:small'>This feild is required.</span>",

        },
        "txtState":
        {
            required: "<span class='text-danger'  style='font-size:small'>This feild is required.</span>",

        },
        "txtCity":
        {
            required: "<span class='text-danger'  style='font-size:small'>This feild is required.</span>",

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
        "txtGen":
        {
            required: "<span class='text-danger'  style='font-size:small'>This feild is required.</span>",
        },
        "txtDob":
        {
            required: "<span class='text-danger' style='font-size:small'>Please enter GST Number.</span>",

        },
    },
    submitHandler: function (form) {
        form.submit();
    }
});