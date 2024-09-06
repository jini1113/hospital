$(document).ready(function () {
    $("#frm").validate({
        rules: {
            "txtName": {
                required: true,
                minlength: 3,
                pattern: "^[a-zA-Z ]{3,}$",
            },
            "txtMail": {
                required: true,
                email: true,
            },
            "txtPass":
            {
                required: true,
                minlength: 5,
                pattern: "^.*(?=.{5,})(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).*$",
            },
            // "txtPhone":
            // {
            //     required: true,
            //     minlength: 10,
            //     maxlength: 10,
            //     pattern: "^[0-9]{10}$",
            // },
        },
        messages: {
            "txtName":
            {
                required: "<span class='text-danger'  style='font-size:small'>This feild is required.</span>",
                minlength: "<span class='text-danger' style='font-size:small;'>Your name must be minimum 3 character required.</span>",
                pattern: "<span class='text-danger' style='font-size:small'>Your name must be in capital and small alphabate  only</span>",
            },
            "txtMail":
            {
                required: "<span class='text-danger' style='font-size:small;'>This feild is required.</span>",
                email: "<span class='text-danger' style='font-size:small;'>Your email address must be in this format name@domain.com</span>",
            },
            "txtPass":
            {
                required: "<span class='text-danger' style='font-size:small;'>This feild is required.</span>",
                minlength: "<span class='text-danger' style='font-size:small;'>Your password must be minimum 5 character required.</span>",
                pattern: "<span class='text-danger' style='font-size:small'>Your password must be atleast one capital and small alphabate ,one digit,one special charcter with minimum rage 5 required.</span>"
            },
            // "txtPhone":
            // {
            //     required: "<span class='text-danger' style='font-size:small'>This feild is required.</span>",
            //     minlength: "<span class='text-danger' style='font-size:small;'>Your phone no must be minimum 10 digit required.</span>",
            //     maxlength: "<span class='text-danger' style='font-size:small'>Your phone no must be maximum 10 digit required.</span>",
            //     pattern: "<span class='text-danger' style='font-size:small'>Your phone no must be 0-9 digit only and only 10 digit allow. </span>"
            // },
        }

    });

    $("#txtSubmit").click(function (event) {
        if ($("#frm").valid()) {
            event.preventDefault();

            const json = { "name": $("#txtName").val(), "mail": $("#txtMail").val(), "pass": $("#txtPass").val() };
            console.log(json);
            $.ajax({
                type: "POST",
                method: "POST",
                url: "../crud.php?what=admin_registration",
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
                            window.location.replace('login.php');
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
});