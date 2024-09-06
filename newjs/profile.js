$(document).ready(function () {
    $("#frm").validate({
        rules: {
            "role": {
                required: true,
            },
            "name": {
                required: true,

            },
            "email": {
                required: true,
            },

            "address": {
                required: true,
            },
            "phone_no": {
                required: true,
                pattern: "^[0-9]+$",
                minlength: 10,
                maxlength: 10,
            },
        },
        messages: {
            "role": {
                required: "<span class='text-danger' style='font-size:small'>This field is required.</span>",
            },
            "name": {
                required: "<span class='text-danger' style='font-size:small'>This field is required.</span>",
            },
            "email": {
                required: "<span class='text-danger' style='font-size:small'>This field is required.</span>",
            },
            "address": {
                required: "<span class='text-danger' style='font-size:small'>This field is required.</span>",
            },
            "phone_no": {
                required: "<span class='text-danger' style='font-size:small'>This field is required.</span>",
                pattern: "<span class='text-danger' style='font-size:small;'>Please Enter Valid Number.</span>",
                minlength: "<span class='text-danger' style='font-size:small'>Minimum Length are 10 digit.</span>",
                maxlength: "<span class='text-danger' style='font-size:small'>Maxixmum Length are 10 digit.</span>",
            },

        },
        submitHandler: function (form) {
            form.submit();
        }
    });
    // $("#btnSubmit").click(function(event){
    //     if ($("#frm").valid()) {
    //         event.preventDefault();
    //     }
    // });
    $("#image").on("change", function () {
        var img = this;
        console.log("Image file selected:", img.files[0]);
        if (img.files && img.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $("#txtImport").attr("src", e.target.result);
                console.log("Image preview updated");
            }
            reader.readAsDataURL(img.files[0]);
        }
    });

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
    function populateCities(stateId) {
        $.ajax({
            url: 'edit-profile.php?what=retUCity',
            method: 'POST',
            data: { id: stateId, main: adminId },
            dataType: 'json',
            success: function (response) {
                var citySelect = $('#txtCity');
                citySelect.empty().append('<option value="">Select City</option>');

                if (response.cities && response.cities.length > 0) {
                    $.each(response.cities, function (index, city) {
                        var option = $('<option></option>')
                            .attr('value', city.id)
                            .text(city.name);

                        if (city.id == response.selected_city_id) {
                            option.attr('selected', 'selected');
                        }

                        citySelect.append(option);
                    });
                } else {
                    console.log("No cities found for this state");
                }
            },
            error: function (xhr, status, error) {
                console.error("Error fetching cities:", error);
            }
        });
    }

    // Populate cities on page load if state is selected
    var initialStateId = $('#txtState').val();
    if (initialStateId) {
        populateCities(initialStateId);
    }

    // Handle state change
    $('#txtState').change(function () {
        var stateId = $(this).val();
        if (stateId) {
            populateCities(stateId);
        } else {
            $('#txtCity').empty().append('<option value="">Select City</option>');
        }
    });

    console.log("Current Gender:", currentGender);
    if (typeof currentGender !== 'undefined' && currentGender) {
        $('#txtGen').val(currentGender);
        console.log("Gender set to:", $('#txtGen').val());
    } else {
        console.log("currentGender is undefined or empty");
    }

    // Handle gender change
    $('#txtGen').on('change', function () {
        console.log("Gender changed to:", $(this).val());
    });

});
