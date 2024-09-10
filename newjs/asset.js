// update image 
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
// block asset
$("#tbl_asset").on("click", ".active_block", function () {
    const json = { "id": $(this).attr("data-id") };
    console.log(json);
    $.ajax({
        type: "POST",
        method: "POST",
        url: "../crud.php?what=blockAsset",
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
// active asset
$("#tbl_asset").on("click", ".block_active", function () {
    const json = { "id": $(this).attr("data-id") };
    console.log(json);
    $.ajax({
        type: "POST",
        method: "POST",
        url: "../crud.php?what=activeAsset",
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
            "txtS_no": {
                required: true,
                
            },
            "txtP_dte": {
                required: true,
                
            },
            "txtP_from": {
                required: true,

            },
            "txtMan": {
                required: true,
                
            },
            "txtModel": {
                required: true,
                
            },
            "txtSupplier": {
                required: true,
                
            },
            "txtWar": {
                required: true,
                
            },
            "txtPrice": {
                required: true,
                
            },
            "txtImg": {
                accept: "jpg,png,jpeg",
            },  
            "txtDes": {
                required: true,
                
            }
            
            
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
            "txtS_no":
            {
                required: "<span class='text-danger'  style='font-size:small'>This feild is required.</span>",
            },
            "txtP_dte":
            {
                required: "<span class='text-danger'  style='font-size:small'>This feild is required.</span>",
            },  
            "txtP_from":
            {
                required: "<span class='text-danger'  style='font-size:small'>This feild is required.</span>",
            },
            "txtMan":
            {
                required: "<span class='text-danger'  style='font-size:small'>This feild is required.</span>",
            },  
            "txtModel":
            {
                required: "<span class='text-danger'  style='font-size:small'>This feild is required.</span>",
            },
            "txtSupplier":
            {
                required: "<span class='text-danger'  style='font-size:small'>This feild is required.</span>",
            },      
            "txtWar":
            {
                required: "<span class='text-danger'  style='font-size:small'>This feild is required.</span>",
            },
            "txtPrice":
            {
                required: "<span class='text-danger'  style='font-size:small'>This feild is required.</span>",
            },
            "txtImg":
            {
                accept: "<span class='text-danger' style='font-size:small;'>Image must be in jpg,png or jpeg format </span>",
            }, 
            "txtDes"  :
            {
                required: "<span class='text-danger'  style='font-size:small'>This feild is required.</span>",
            },
            
            
        },
        submitHandler: function (form) {
            form.submit();
        }
    });
});
