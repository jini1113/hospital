$("#frm").validate({
    rules :{
        "txtPatient" :{
            required: true,
        },
        "txtDoc" :{
            required: true,
        },
        "txtSurname" :{
            required: true,
        },
        "txtWard" :{
            required: true,
        },
        "txtBno" :{
            required: true,
        },
        "txtAdate" :{
            required: true,
        },
        "txtDate" :{
            required: true,
        },
        "txtDis" :{
            required: true,
        },
        "txtHour" :{
            required: true,
        },
        "txtAtime" :{
            required: true,
        },  
        "txtTime" :{
            required: true,
        },
        "txtSurname" :{
            required: true,
        },
     
    },
    messages: {
        "txtPatient": {
            required: "<span class='text-danger' style='font-size:small'>This field is required.</span>",
        },
        "txtDoc": {
            required: "<span class='text-danger' style='font-size:small'>This field is required.</span>",
        },
        "txtSurname": {
            required: "<span class='text-danger' style='font-size:small'>This field is required.</span>",
        },
        "txtWard": {
            required: "<span class='text-danger' style='font-size:small'>This field is required.</span>",
        },
        "txtBno": {
            required: "<span class='text-danger' style='font-size:small'>This field is required.</span>",
        },
        "txtAdate": {
            required: "<span class='text-danger' style='font-size:small'>This field is required.</span>",
        },
        "txtDate": {
            required: "<span class='text-danger' style='font-size:small'>This field is required.</span>",
        },
        "txtDis": {
            required: "<span class='text-danger' style='font-size:small'>This field is required.</span>",
        },
        "txtHour": {
            required: "<span class='text-danger' style='font-size:small'>This field is required.</span>",
        },
        "txtAtime": {
            required: "<span class='text-danger' style='font-size:small'>This field is required.</span>",
        },
        "txtTime": {
            required: "<span class='text-danger' style='font-size:small'>This field is required.</span>",
        },
        "txtSurname": {
            required: "<span class='text-danger' style='font-size:small'>This field is required.</span>",
        },
       
    },
});
// Add In pationts
$("#btnSubmit").click(function (event) {
    if ($("#frm").valid()) {
        event.preventDefault();
        const json = { "txtPatient": $("#txtPatient").val(),
            "txtDoc": $("#txtDoc").val(),
             
              "txtWard": $("#txtWard").val(), 
              "txtBno": $("#txtBno").val(), 
              "txtAdate": $("#txtAdate").val(), 
              "txtDate": $("#txtDate").val(),
              "txtDis": $("#txtDis").val(),
              "txtHour": $("#txtHour").val(),
              "txtAtime": $("#txtAtime").val(),
              "txtTime": $("#txtTime").val() 
            };
        console.log(json);
        $.ajax({
            type: "POST",
            method: "POST",
            url: "../crud.php?what=out_patientadd",
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
                        window.location.replace('view_opd.php');
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

  // UPDATE Out pationts
  $("#btnUpdate").click(function (event) {
    if ($("#frm").valid()) {
        event.preventDefault()
        const json = { "txtUId": $("#txtUId").val(),
           "txtPatient": $("#txtPatient").val(),
            "txtDoc": $("#txtDoc").val(),
             
              "txtWard": $("#txtWard").val(), 
              "txtBno": $("#txtBno").val(), 
              "txtAdate": $("#txtAdate").val(), 
              "txtDate": $("#txtDate").val(),
              "txtDis": $("#txtDis").val(),
              "txtHour": $("#txtHour").val(),
              "txtAtime": $("#txtAtime").val(),
              "txtTime": $("#txtTime").val() 
            };
        console.log(json);
        $.ajax({
            type: "POST",
            method: "POST",
            url: "../crud.php?what=outpatientupdate",
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
                        window.location.replace('view_opd.php');
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
        }
    });
});
// get city on update time

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