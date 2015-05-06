var Login = function () {

	var handleLogin = function() {
		$('.login-form').validate({
	            errorElement: 'span', //default input error message container
	            errorClass: 'help-block', // default input error message class
	            focusInvalid: false, // do not focus the last invalid input
	            rules: {
	                'username': {
	                    required: true
	                },
	                'password': {
	                    required: true
	                },
	            },

	            messages: {
	                username: {
	                    required: "Email Address is required."
	                },
	                password: {
	                    required: "Password is required."
	                }
	            },

	            invalidHandler: function (event, validator) { //display error alert on form submit   
	                $('.alert-danger', $('.login-form')).show();
	            },

	            highlight: function (element) { // hightlight error inputs
	                $(element)
	                    .closest('.form-group').addClass('error_field'); // set error class to the control group
	            },

	            success: function (label) {
	                label.closest('.form-group').removeClass('error_field');
	                label.remove();	              
	            },

	            errorPlacement: function (error, element) {
	                error.insertAfter(element.closest('.input-icon'));
	            },

	            submitHandler: function (form) {
					SubmitLoginForm();
					//form.submit();
	            }
	        });
	}
    return {
        //main function to initiate the module
        init: function () {
        	
            handleLogin();
        }

    };

}();

function SubmitLoginForm() {
	var dataString = 'LoginForm[username]='+ $('#username').val() + '&LoginForm[password]=' + $('#password').val() + '&LoginForm[rememberMe]=' + $('#on_off').val();
	$.ajax({  
		  type: "POST",  
		  url: "/admin/default/managerlogin",  
		  data: dataString,  
		  success: function(response) { 
		  	if(response == 1){
				//showSucessMsg("Login Success", "Login");
				//showSucessMsg("Please wait a while... ", "Page Redirection");
		  		window.location.href='/admin/admin';
				//setTimeout( "window.location.href='/admin/admin'", 2000); 
			}else{
				alert("Incorrect Username or Password!");
			}
		  	return false;
		  } ,
		  error: function(response) {
                      
			  if(response.responseText==100)
				  showError("Your Account is Deactivated Please contact Administrator!");
			  else
				  showError("Incorrect Username or Password!");
			  return false;
		  }
		});  
		return false;  
}