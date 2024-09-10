$("#frm").validate({
    rules :{
        "txtName" :{
            required: true,
        },
        "txtDep" :{
            required: true,
        },
        "txtType" :{
            required: true,
        },
        "txtReason" :{
            required: true,
        },
        "txtFrom" :{
            required: true,
        },
        "txtTo" :{
            required: true,
        },
        "txtDay" :{
            required: true,
        },
     
    },
    messages: {
        "txtName": {
            required: "<span class='text-danger' style='font-size:small'>This field is required.</span>",
        },
        "txtDep": {
            required: "<span class='text-danger' style='font-size:small'>This field is required.</span>",
        },
        "txtType": {
            required: "<span class='text-danger' style='font-size:small'>This field is required.</span>",
        },
        "txtReason": {
            required: "<span class='text-danger' style='font-size:small'>This field is required.</span>",
        },
        "txtFrom": {
            required: "<span class='text-danger' style='font-size:small'>This field is required.</span>",
        },
        "txtTo": {
            required: "<span class='text-danger' style='font-size:small'>This field is required.</span>",
        },
        "txtDay": {
            required: "<span class='text-danger' style='font-size:small'>This field is required.</span>",
        },
       
    },
});
$("#btnSubmit").click(function (event) {
    if ($("#frm").valid()) {
        event.preventDefault();
        const json = { "txtDoc": $("#txtDoc").val(),
            "txtDep": $("#txtDep").val(),
             "txtType": $("#txtType").val(),
              "txtReason": $("#txtReason").val(), 
              "txtFrom": $("#txtFrom").val(), 
              "txtTo": $("#txtTo").val(), 
              "txtDay": $("#txtDay").val(),
            };
        console.log(json);
        $.ajax({
            type: "POST",
            method: "POST",
            url: "../crud.php?what=leaveadd",
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
                        window.location.replace('leave.php');
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