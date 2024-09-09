

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
$("#updateForm").on("submit", function (e) {
    e.preventDefault(); // Prevent default form submission

    const data = {
        txtPatient: $("#txtPatient").val(), // Patient ID from the dropdown
        txtWard: $("#txtWard").val(),       // Ward ID
        txtBno: $("#txtBno").val(),         // Bed ID
        txtAdate: $("#txtAdate").val(),     // Admit Date
        txtDate: $("#txtDate").val(),       // Discharge Date
        btnSubmit: true,                    // Indicate that this is an insert
        txtUId: $("#txtUId").val()          // Include the patient ID for update
    };
    $.ajax({
        type: "POST",
        url: "../crud.php", // URL for inserting/updating a patient
        data: data,
        success: function (response) {
            if (response.includes("Patient added successfully!") || response.includes("Patient updated successfully!")) {
                window.location.replace('b_patients.php'); // Redirect on success
            } else {
                alert(response); // Show error message
            }
        },
       
    });
});











