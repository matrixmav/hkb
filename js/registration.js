  function validateFrm() {
        if ($("#sponser_id").val() == "") {
            $("#sponser_id_error").html("Invalid Sponser Id");
            return false;
        }

        $("#name_error").html("");
        if ($("#name").val() == "") {
            $("#name_error").html("Enter User Name");
            return false;
        }

        $("#full_name_error").html("");
        if ($("#full_name").val() == "") {
            $("#full_name_error").html("Enter User Full Name");
            return false;
        }

        /* email validation */
        $("#email_error").html("");
        if ($("#email").val() == "") {
            $("#email_error").html("Enter User Email");
            return false;
        }

        var email = document.getElementById('email');
        var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

        if (!filter.test(email.value)) {
            $("#email_error").html("Enter valid email address ");
            return false;
        }
        /* end here */

        /* Phone Number Validation  */
        $("#phone_error").html("");
        if ($("#phone").val() == "") {
            $("#phone_error").html("Enter Mobile Number");
            return false;
        }

        var phone = document.getElementById('phone');
        var filter = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;

        if (!filter.test(phone.value)) {
            $("#phone_error").html("Enter valid phone number ");
            return false;
        }

        $("#password_error").html("");
        if ($("#password").val() == "") {
            $("#password_error").html("Enter Password");
            return false;
        }

        if ($("#confirm_password").val() == "") {
            $("#confirm_password_error").html("Enter Confirm Password");
            return false;
        }

        if ($("#password").val() != $("#confirm_password").val()) {
            $("#confirm_password_error").html("Please check that you've entered and confirmed your password");
            return false;
        }


        alert("Submit");
    }
    function isUserExisted() {
        $.ajax({
            type: "post",
            url: "/user/isuserexisted",
            data: "username=" + $("#name").val(),
            success: function (msg) {
                $("#name_error").html("");
                if(msg == 1){
                    $("#name_error").html("Existed!!!");
                }
            }
        });
    }
    function getCountryCode(id){ 
         $.ajax({
            type: "post",
            url: "/country/getcountry",
            data: "id=" + id,
            success: function (msg) { 
                $("#country_code").val("");
                if(msg){
                    $("#country_code").val(msg);
                }
            }
        });
    }
