$("#txtImg").on("change", function () {
    var img = this;
    console.log(img);
    if (img.files && img.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $("#txtImport").attr("src", e.target.result);
        }
        reader.readAsDataURL(img.files[0]);
    }

});
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

$(document).ready(function () {
    $("#frm").validate({
        rules: {
            "txtName": {
                required: true,
                minlength: 3,
                pattern: "^[a-zA-Z ]{3,}$",
            },
            "txtImg":
            {
                accept: "jpg,png,jpeg",
            },
            "txtGen": {
                required: true,
            },
            "txtAdd": {
                required: true,
            },
            "txtDob": {
                required: true,
            },
            "txtDep":
            {
                required: true,
               
            },
            "txtPhone":
            {
                required: true,
                minlength: 10,
                maxlength: 10,
                pattern: "^[0-9]{10}$",
            },
            "txtState": {
                required: true,
            },
            "txtCity":
            {
                required: true,
                // minlength: 15,
                // maxlength: 15,
                // pattern: "^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$",
            },
            "txtJob":
            {
                required: true,
                // pattern: "^[0-9]+$",
            },
            "txtMail": {
                required: true,
                email: true,
            },
        },
        messages: {

            "txtName":
            {
                required: "<span class='text-danger'  style='font-size:small'>This feild is required.</span>",
                minlength: "<span class='text-danger' style='font-size:small;'>This name must be minimum 3 character required.</span>",
                pattern: "<span class='text-danger' style='font-size:small'>This name must be in capital and small alphabate  only</span>",
            },
            "txtImg":
            {
                accept: "<span class='text-danger' style='font-size:small;'>Image must be in jpg,png or jpeg format </span>",
            },
            "txtGen":
            {
                required: "<span class='text-danger'  style='font-size:small'>This feild is required.</span>",

            },
            "txtAdd":
            {
                required: "<span class='text-danger'  style='font-size:small'>This feild is required.</span>",

            },
            "txtDob":
            {
                required: "<span class='text-danger'  style='font-size:small'>This feild is required.</span>",

            },
            "txtDep":
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
            "txtState":
            {
                required: "<span class='text-danger'  style='font-size:small'>This feild is required.</span>",
            },
            "txtCity":
            {
                required: "<span class='text-danger' style='font-size:small'>This feild is required.</span>",
                // minlength: "<span class='text-danger' style='font-size:small;'>This Gst no must be minimum 15 charcter required.</span>",
                // maxlength: "<span class='text-danger' style='font-size:small'>This Gst no must be maximum 15 charcter required.</span>",
                // pattern: "<span class='text-danger' style='font-size:small'>Please enter valid GST Number.</span>",
            },
            "txtJob":
            {
                required: "<span class='text-danger' style='font-size:small'>This feild is required.</span>",
                // pattern: "<span class='text-danger' style='font-size:small'>This commision must be 0-9 digit only. </span>"
            },
        },
        submitHandler: function (form) {
            form.submit();
        }
    });
});