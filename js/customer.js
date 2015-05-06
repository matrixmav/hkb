
var customer = {

    el: {
    	login : $('#login'),
    	signup : $('#signup'),
    	save : $('#save'),
    	sendcode : $('#sendcode'),
    	validate : $('#validate'),
    },

    init: function () { 
    	customer.bindUIActions();
    },
            
    bindUIActions: function () { 
        $(document).on('click', customer.el.login.selector, customer.actions.login);
        $(document).on('click', customer.el.signup.selector, customer.actions.signup);
        $(document).on('click', customer.el.save.selector, customer.actions.save);
        $(document).on('click', customer.el.sendcode.selector, customer.actions.sendcode);
        $(document).on('click', customer.el.validate.selector, customer.actions.validate);
    },
    actions: {
    	login : function() {
    		if(($('#telephone').val()=="") && ($('#password_login').val()==""))
			{
				$('#telephone').addClass("error_field");
				$('#password_login').addClass("error_field");
				$('#errorlogin').text(validationMessage);
				return false;
			}
			if($('#telephone').val()=="")
			{
				$('#telephone').addClass("error_field");
				$('#errorlogin').text(validationMessage);
				return false;
			}
			if($('#password_login').val()=="")	
			{
				$('#password_login').addClass("error_field");
				$('#errorlogin').text(validationMessage);
				return false;
			}
			//alert($('#password_login').val().substring(1));
			$('#loaderlog').show();
			if(mobile != 'mobile'){
			$.ajax({
				type: "POST",
				url: loginUrl,
				data: { telephone: $('#telephone').val(), password: $('#password_login').val()},
				success: function(result){
							if(result == "match")
							{
								$('#errorlogin').text("Login Success");
								var curr_page = window.location.href;
								if(window.location.href.indexOf("hotel") > -1) {
       								location.reload(); exit
    							}else{
   								window.location.href = window.location.href + "customer/myreservations";
   								//location.reload();
								}
								//location.reload();
								return false;
							}else{
								$('#loaderlog').hide();
								$('#errorlogin').text(InvalidCreds);
								return false;
							}
					}
				});	
			return false;
			}
			
        },
        signup : function() {
        	if(($('#fname').val()=="") || ($('#lanme').val()=="") || ($('#email').val()=="") || ($('#signuppassword').val()=="") || ($('#signuptelephone').val()=="") || ($('#confirmemail').val()=="")|| ($('#confirmpassword').val()==""))
			{
				$('#errormsg1').text(validationMessage);
				$('.singin input').each(function(){
					if($(this).val() == "")
					{
						$(this).addClass("error_field");
					}else
					{
						$(this).removeClass("error_field");
					}
				});
				
			}
			if($('#email').val()!=""){
				if (validateEmail($('#email').val())) {
					$('#errormsg').text("");
					}
					else {
						$('#errormsg').text(Emailerror);
						return false;
					}
				}
			
			if($('#email').val() != $('#confirmemail').val())
			{
				$('#errormsg').text(Emailnotmatch);
				return false;
			}
			if($('#signuppassword').val() != $('#confirmpassword').val())
			{
				$('#errormsg').text(Passwordnotmatch);
				return false;
			}
			
			var validatetel =  $('#signuptelephone').val();
			var validateemail = $('#email').val();
			if((validatetel != "") && (validateemail !=""))
			{
				$('#loaderlog').show();
			$.ajax({
				type: "POST",
				url: validateUrl,
				data: { validatetel: validatetel, validateemail: validateemail },
				success: function(result){
					
					if(result == "present")
					{
						$('#loaderlog').hide();
						$('#errormsg1').text(Emailpresent);
						return false;
					}else{
						$( "#signup-form-id" ).submit();
						return true;
					}
					}
				});	
			}
			return false;
        },
        save : function() {
        	
        	/*For Password */
			$('#msg').hide();
			if(($('#fname').val()=="") || ($('#lanme').val()=="") || ($('#email_myacc').val()=="") ||  ($('#telephone_myacc').val()==""))
			{
				$('#errormsg1').text(validationMessage);
				$('.mandtory').each(function(){
					if($(this).val() == "")
					{
						$(this).addClass("error_field");
					}else
					{
						$(this).removeClass("error_field");
					}
				});
				return false;
			}else
			{
				$('#errormsg1').text("");
			}
			if (validateEmail($('#email_myacc').val())) {
				$('#errormsg').text("");
				}
				else {
					$('#errormsg').text(Emailerror);
					return false;
				}
			
			/*For Change Password */
			if(($('#currentpswd').val()!="") || ($('#newpswd').val()!="") || ($('#confirmpswd').val()!=""))
			{
				
				if(($('#currentpswd').val()=="") || ($('#newpswd').val()=="") || ($('#confirmpswd').val()==""))
				{
					$('#pswderrormsg').text(validationMessage);
					$('.pswdmandtory').each(function(){
						if($(this).val() == "")
						{
							$(this).addClass("error_field");
						}else
						{
							$(this).removeClass("error_field");
						}
					});
					return false;
				}
				if($('#newpswd').val() != $('#confirmpswd').val())
				{
					$('#pswderrormsg').text(Passwordnotmatch);
					return false;
				}else
				{
					$('#pswderrormsg').text("");
				}
			}
        },
        sendcode : function() {
        	if(($('#emailfp').val() == "") || ($('#telephonefp').val() == ""))
			{
				$('#errorfp').text(validationMessage);
				if($('#emailfp').val() == "")
				{
					$('#emailfp').addClass("error_field");
					return false;
				}else{
					var sEmail = $('#emailfp').val();
					if (validateEmail(sEmail)) {
						$('#errorfp').text("");
						}
						else {
							$('#errorfp').text(Emailerror);
							return false;
						}
					}
				if($('#telephonefp').val() == "")
				{
					$('#telephonefp').addClass("error_field");
					$('#errorfp').text(validationMessage);
					return false;
				}
			}else{
				var useremail = $('#emailfp').val();
				var userphone = $('#telephonefp').val();
				$('#loaderfp').show();
				$.ajax({
					type: "POST",
					url: fpUrl,
					data: { useremail: useremail, userphone: userphone},
					success: function(result){
						$('#loaderfp').hide	();
						$('#errorfp').text(result);
						}
					});	
				}
			var sEmail = $('#emailfp').val();
			if (validateEmail(sEmail)) {
				//alert('Nice!! your Email is valid, now you can continue..');
				}
				else {
					$('#errorfp').text(Emailerror);
					return false;
				}
        },
        validate : function() {
        	if($('#code').val() == ""){
    			$('#code').addClass("error_field");
    			$('#codeerr').text(Entercode);
    			return false;
    		}else{
    			$('#loaderfp').show();
    			var validationcode =  $('#code').val();
    			$.ajax({
    				type: "POST",
    				url: fpUrl,
    				data: { validationcode: validationcode },
    				success: function(result){
    					$('#loaderfp').hide();
    					$('#errorfp').text(result);
    					}
    				});	
    		}
    	return false;
        },
        }
};

$(document).ready(function () { 	
	customer.init();
	$('#currentpswd').val("");
	$('#emailfp').focusout(function(){
		var sEmail = $('#emailfp').val();
		if(sEmail != ""){
		if (validateEmail(sEmail)) {
			$('#errorfp').text("");
			}
			else {
				$('#errorfp').text(Emailerror);
				return false;
			}
		}else
		{
			$('#errorfp').text("");
		}
		});
	$("#signuptelephone").keypress(function (e) {
	     //if the letter is not digit then display error and don't type anything
	     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
	        //display error message
	        $("#errmsg").html(DigitsOnly).show().fadeOut("slow");
	               return false;
	    }
	   });
	$("#telephone").keypress(function (e) {
	     //if the letter is not digit then display error and don't type anything
	     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
	        //display error message
	        $("#errmsg1").html(DigitsOnly).show().fadeOut("slow");
	               return false;
	    }
	   });
	
	$('#email').focusout(function(){
		var sEmail = $('#email').val();
		if (validateEmail(sEmail)) {
			//alert('Nice!! your Email is valid, now you can continue..');
			}
			else {
				$('#errormsg').text(Emailerror);
				return false;
			}
		});
	$('#confirmemail').focusout(function() {
		if($('#email').val() != $('#confirmemail').val())
		{
			$('#errormsg').text(Emailnotmatch);
			return false;
		}else{
			$('#errormsg').text("");
		}
		
	});
	$('#confirmpassword').focusout(function() {
		if($('#signuppassword').val() != $('#confirmpassword').val())
		{
			$('#errormsg').text(Passwordnotmatch);
			return false;
		}else
		{
			$('#errormsg').text("");
		}
		
	});
	$("#telephone_myacc").keypress(function (e) {
	     //if the letter is not digit then display error and don't type anything
	     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
	        //display error message
	        $("#errmsg").html(DigitsOnly).show().fadeOut("slow");
	               return false;
	    }
	   });
  $('#email_myacc').focusout(function(){
		var sEmail = $('#email_myacc').val();
		if (validateEmail(sEmail)) {
			$('#errormsg').text("");
			}
			else {
				$('#errormsg').text(Emailerror);
				return false;
			}
		});
  $("#telephonefp").keypress(function (e) {
	    //if the letter is not digit then display error and don't type anything
	    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
	       //display error message
	       $("#errmsgfp").html(DigitsOnly).show().fadeOut("slow");
	              return false;
	   }
	  });

	
});
//
var searchOuter = {
	    
	    el : {
	        febHotel : $(".fevimg_un")
	        
	    },
	    init: function () { 
	        searchOuter.bindUIActions();
	    },
	    bindUIActions: function () {        
	        $(document).on('click', searchOuter.el.febHotel.selector, searchOuter.actions.makeFavorite);
	        
	    },
	    actions: {
	        makeFavorite : function(){                
	                //var userstatus = "";
	                var userstatus = $(this).attr('uid') ;
	                var hid = $(this).attr('hid') ;
	                var pData = {hid:hid,userId:userstatus}; //Array postdata
	    
	                if(userstatus){
	                    $.ajax({
	                        url:"/search/makefavorite",
	                        type:'POST',
	                        context: this,
	                        data: pData,
	                        datatype: 'json',
	                        beforeSend: function(){
	                            $(".fullpgloader").show();
	                        },
	                        success: function(datares){
	                            var jsonRes = JSON.parse(datares);
	                            $(".fullpgloader").hide();
	                            location.reload();
	                            if(jsonRes.error){
	                                $(this).addClass('fail');
	                            }else{
	                                $(this).attr('src','/images/feveritSel_50x50.png');
	                                location.reload();
	                            }
	                        }
	                    });
	                }else{
	                    alert('please login to make favorite.');
	                }
	        }
	    }
	};
	searchOuter.init();
	//

function validateEmail(sEmail) {
    var filter = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
    if (filter.test(sEmail)) {
        return true;
    }
    else {
        return false;
    }
}