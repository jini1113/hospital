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
// ... existing code ...
$("#txtWard").on("change", function () {
    const json = { "main": $("#txtUId").val(), "id": $(this).val() };
    $.ajax({
        type: "POST",
        url: "../crud.php?what=getUpBed",
        data: json,
        dataType: "JSON",
        success: function (response) {
            console.log(response); // Log the response for debugging
            var s = "<option value=''>Select</option>";
            if (response.beds && response.beds.length > 0) {
                for (var i = 0; i < response.beds.length; i++) {
                    s += `<option value='` + response.beds[i].id + `' ${(response.bed_id == response.beds[i].id) ? "selected" : ""}>` + response.beds[i].name + `</option>`;
                }
            } else {
                s += "<option value=''>No beds available</option>"; // Handle no beds case
            }
            $("#txtBno").html(s);
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error: ", status, error); // Log any errors
        }
    });
});
// ... existing code ...


