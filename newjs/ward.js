$("#frm").validate({
    rules: {
        "txtName": {
            required: true,
        },

        "txtCap": {
            required: true,
        },
        
        "txtImg": {
            required: true,
        },


    },
    messages: {
        "txtName": {
            required: "<span class='text-danger' style='font-size:small'>This field is required.</span>",
        },

        "txtCap": {
            required: "<span class='text-danger' style='font-size:small'>This field is required.</span>",
        },
        "txtImg": {
            required: "<span class='text-danger' style='font-size:small'>This field is required.</span>",
        },

    },
});
//update image 
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
// block ward
$("#tbl_ward").on("click", ".active_block", function () {
    const json = { "id": $(this).attr("data-id") };
    console.log(json);
    $.ajax({
        type: "POST",
        method: "POST",
        url: "../crud.php?what=blockWard",
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
$("#tbl_ward").on("click", ".block_active", function () {
    const json = { "id": $(this).attr("data-id") };
    console.log(json);
    $.ajax({
        type: "POST",
        method: "POST",
        url: "../crud.php?what=activeWard",
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
$(document).ready(function () {
    $("#frm").validate({
        rules: {
            "txtName": {
                required: true,
                minlength: 3,
                pattern: "^[a-zA-Z ]{3,}$",
            },

            "txtCap": {
                required: true,
            },
            "txtImg":
            {
                accept: "jpg,png,jpeg",
            },

        },
        messages: {

            "txtName":
            {
                required: "<span class='text-danger'  style='font-size:small'>This feild is required.</span>",
                minlength: "<span class='text-danger' style='font-size:small;'>This name must be minimum 3 character required.</span>",
                pattern: "<span class='text-danger' style='font-size:small'>This name must be in capital and small alphabate  only</span>",
            },

            "txtCap":
            {
                required: "<span class='text-danger'  style='font-size:small'>This feild is required.</span>",

            },
            "txtImg":
            {
                accept: "<span class='text-danger' style='font-size:small;'>Image must be in jpg,png or jpeg format </span>",
            },

        },
        submitHandler: function (form) {
            form.submit();
        }
    });
});
