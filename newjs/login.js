radioflag = false;
radioflag1 = false;

$(document).ready(function () {
    $("#frm").validate({  // For validation
        rules: {
            "txtMail": {
                required: true
                // email: true
            },
            "txtPass": {
                required: true
                // minlength: 5,
                // pattern: "^.*(?=.{5,})(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).*$"
            }
        },
        messages: {
            "txtMail": {
                required: "<span class='text-danger' style='font-size:small;'>This field is required.</span>"
                // email: "<span class='text-danger' style='font-size:small;'>Your email address must be in this format name@domain.com</span>"
            },
            "txtPass": {
                required: "<span class='text-danger' style='font-size:small;'>This field is required.</span>"
                // minlength: "<span class='text-danger' style='font-size:small;'>Your password must be minimum 5 characters required.</span>",
                // pattern: "<span class='text-danger' style='font-size:small'>Your password must include at least one capital and small letter, one digit, and one special character with a minimum of 5 characters required.</span>"
            }
        },
        highlight: function (element) {
            if (element.type == "email" && !radioflag) {
                $("#errMail").html("<span class='text-danger' style='font-size:small;'>Please enter your email address</span>");
                radioflag = true;
            }
            if (element.type == "password" && !radioflag1) {
                $("#errPass").html("<span class='text-danger' style='font-size:small;'>Please enter your password.</span>");
                radioflag1 = true;
            }
        },
        unhighlight: function (element) {
            if (element.type == "email") {
                $("#errMail").html("");
                radioflag = false;
            }
            if (element.type == "password") {
                $("#errPass").html("");
                radioflag1 = false;
            }
        }
    });

    $("#txtSubmit").click(function (event) {
        event.preventDefault(); // Prevent form from refreshing the page
        if ($("#frm").valid()) {
            const json = {
                "email": $("#txtMail").val(),
                "pass": $("#txtPass").val()
            };

            // Make AJAX request
            $.ajax({
                type: "POST",
                url: "crud.php?what=admin_login",
                data: json,
                dataType: "JSON",
                success: function (response) {
                    console.log(response);
                    if (response.role == "Admin") {
                        handleSuccess(response, 'admin/index.php');
                    } else if (response.role == "Doctor") {
                        handleSuccess(response, 'doctor/index.php');
                    } else {
                        handleSuccess(response, 'staff/index.php');
                    }
                }
            });
        }
    });
    function handleSuccess(response, redirectUrl) {
        window.scrollTo({
            "top": 0,
            "behavior": "smooth"
        });
        if (response.success) {
            $.bootstrapGrowl("<div class='text-center' style='background-color:#7dcea0;opacity:1;font-weight:bold'><h1>Success!</h1><p>" + response.message + "</p></div>", {
                delay: 2500,
                width: 400,
                offset: {
                    "from": "top",
                    "amount": 20
                },
                allow_dismiss: false,
                align: "center",
            });
            setTimeout(function () {
                window.location.replace(redirectUrl);
            }, 2500);
        } else {
            $.bootstrapGrowl("<div class='text-center' style='background-color:#ec7063;opacity:1;font-weight:bold'><h1>Error!</h1><p>" + response.message + "</p></div>", {
                delay: 2500,
                width: 400,
                offset: {
                    "from": "top",
                    "amount": 20
                },
                allow_dismiss: false,
                align: "center",
            });
        }
    }
});
