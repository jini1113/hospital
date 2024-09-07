
$(document).ready(function () {
    $("#frm").validate({
        rules: {
        "name": {
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
        
        "name": {
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
});