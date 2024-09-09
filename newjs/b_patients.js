$("#txtWard").on("change", function () {
    const wardId = $(this).val();
    $.ajax({
        type: "POST",
        url: "../crud.php?what=getInBed",
        data: { wardId: wardId },
        dataType: "JSON",
        success: function (response) {
            var s = "<option value=''>Select</option>";
            for (var i = 0; i < response.length; i++) {
                s += "<option value='" + response[i].id + "'>" + response[i].bed_no + "</option>";
            }
            $("#txtBno").html(s);
        },
        error: function (xhr, status, error) {
            console.error("Error fetching beds:", error); // Log error
        }
    });
});
// Function to fetch current bed information when the ward changes
$("#txtWard").on("change", function () {
    const json = { "main": $("#txtUId").val(), "id": $(this).val() }; // Assuming "txtUId" is the patient ID
    $.ajax({
        type: "POST",
        url: "../crud.php?what=getUpBed",
        data: json,
        dataType: "JSON",
        success: function (response) {
            console.log(response); // Debugging line to check the response structure
            var s = "<option value=''>Select</option>";
            if (response.beds && response.beds.length > 0) {
                // Loop through each bed and add it to the dropdown
                for (var i = 0; i < response.beds.length; i++) {
                    s += `<option value='${response.beds[i].id}' ${(response.bed_id == response.beds[i].id) ? "selected" : ""}>${response.beds[i].name}</option>`;
                }
            } else {
                s += "<option value=''>No beds available</option>"; // Handle no beds case
            }
            $("#txtBno").html(s); // Update the Bed No. dropdown
        },
        error: function (xhr, status, error) {
            console.error("Error fetching beds:", error); // Log error
        }
    });
});
// Add b_patients
$("#btnSubmit").click(function (event) {
    if ($("#frm").valid()) {
        event.preventDefault();
        const json = {
            "txtPatient": $("#txtPatient").val(),
            "txtWard": $("#txtWard").val(),
            "txtBno": $("#txtBno").val(),
            "txtAdate": $("#txtAdate").val(),
            "txtDate": $("#txtDate").val(),

        };
        // console.log(json);
        $.ajax({
            type: "POST",
            method: "POST",
            url: "../crud.php?what=b_patientadd",
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
                        window.location.replace('b_patients.php');
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
// update b_patients
$("#btnUpdate").click(function (event) {
    if ($("#frm").valid()) {
        event.preventDefault();
        const json = {
            "txtUId": $("#txtUId").val(), // Added this line to include the patient ID
            "txtPatient": $("#txtPatient").val(),
            "txtWard": $("#txtWard").val(),
            "txtBno": $("#txtBno").val(),
            "txtAdate": $("#txtAdate").val(),
            "txtDate": $("#txtDate").val(),
        };
        // console.log(json);
        $.ajax({
            type: "POST",
            method: "POST",
            url: "../crud.php?what=b_patientup",
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
                        window.location.replace('b_patients.php');
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