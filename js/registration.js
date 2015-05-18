  function validateFrm() {
      
       
        
        if ($("#sponser_id").val() == "") {
            $("#sponser_id_error").html("Get Sponser Id");
            return false;
        }

        $("#name_error").html("");
        if ($("#name").val() == "") {
            $("#name_error").html("Enter User Name");
            $("#name").focus();            
            return false;
        }
       
        if ($("#name").val().length < 5) {
            $("#name_error").html("Enter atleast 5 chars in the input box");
            $("#name").focus();            
            return false;
        }

        $("#full_name_error").html("");
        if ($("#full_name").val() == "") {
            $("#full_name_error").html("Enter User Full Name");
            $("#full_name").focus();   
            return false;
        }  
        
        if ($("#full_name").val().length < 5) {
            $("#full_name_error").html("Enter atleast 5 chars in the input box");
            $("#full_name").focus();   
            return false;
        }
        

        /* email validation */
        $("#email_error").html("");
        if ($("#email").val() == "") {
            $("#email_error").html("Enter User Email");
            $("#email").focus();
            return false;
        }

        var email = document.getElementById('email');
        var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

        if (!filter.test(email.value)) {
            $("#email_error").html("Enter valid email address ");
            $("#email").focus();
            return false;
        }
        /* end here */

        $("#date_error").html("");
        if ($("#d").val() == "" || $("#m").val() == "" || $("#y").val() == "" ) {
            $("#date_error").html("Enter Birth Date");
            $("#d").focus();
            return false;
        }    

        $("#country_id_error").html("");
        if ($("#country_id").val() == "") {
            $("#country_id_error").html("Please Select Country Name");
            $("#country_id").focus();   
            return false;
        }   

        /* Phone Number Validation  */
        $("#phone_error").html("");
        if ($("#phone").val() == "") {
            $("#phone_error").html("Enter Mobile Number");
            $("#phone").focus();
            return false;
        }
        

        var phone = document.getElementById('phone');
        var filter = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;

        if (!filter.test(phone.value)) {
            $("#phone_error").html("Enter valid phone number ");
            $("#phone").focus();  
            return false;
        }

        $("#password_error").html("");
        if ($("#password").val() == "") {
            $("#password_error").html("Enter Password");
            $("#password").focus();
            return false;
        }
        
         if ($("#password").val().length < 5) {
            $("#password_error").html("Enter atleast 5 chars in the input box");
            $("#password_name").focus();   
            return false;
        }
        

        if ($("#confirm_password").val() == "") {
            $("#confirm_password_error").html("Enter Confirm Password");
            $("#confirm_password").focus();
            return false;
        }
        
        if ($("#confirm_password").val().length < 5) {
            $("#confirm_password_error").html("Enter atleast 5 chars in the input box");
            $("#confirm_password").focus();
            return false;
        }

        if ($("#password").val() != $("#confirm_password").val()) {
            $("#confirm_password_error").html("Please check that you've entered and confirmed your password");
            $("#confirm_password").focus();
            return false;
        }

        $("#position_error").html("");
        if ($("#position").val() == "") {
            $("#position_error").html("Enter Select Positioin");
            $("#position").focus();
            return false;
        }
        
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
