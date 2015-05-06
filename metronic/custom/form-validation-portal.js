var FormValidation = function () {

    var handleValidation1 = function() {
        // for more info visit the official plugin documentation: 
            // http://docs.jquery.com/Plugins/Validation

            var form1 = $('#form_sample_3_portal');
            var error1 = $('.alert-danger', form1);
            var success1 = $('.alert-success', form1);

            form1.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "",
                rules: {
                    'Portal[name]': {
                        required: true
                    },
					'Portal[url]': {
                        required: true,
                        url:true
                        
                    },					
					'Portal[headtitle]': {
                        required: true
                    },
					'Portal[contact_email]': {
                        required: true,
                        email:true
                    },
					'Portal[booking_email]': {
                        required: true,
                        email:true
                    },
					'Portal[telephone_std]': {
                        required: true,
                        number: true
                    },
					
                },

                invalidHandler: function (event, validator) { //display error alert on form submit              
                    success1.hide();
                    error1.show();
                    App.scrollTo(error1, -200);
                },

                highlight: function (element) { // hightlight error inputs
                    $(element)
                        .closest('.form-group').addClass('has-error'); // set error class to the control group
                },

                unhighlight: function (element) { // revert the change done by hightlight
                    $(element)
                        .closest('.form-group').removeClass('has-error'); // set error class to the control group
                },

                success: function (label) {
                    label
                        .closest('.form-group').removeClass('has-error'); // set success class to the control group
                },

                submitHandler: function (form) {
                    //success1.show();
                    error1.hide();
					
					$form=$("#form_sample_3_portal");
					$.ajax({
						dataType:'json',
						type: "get",
						url:$form.attr("action"),
						beforeSend:function(){
							App.blockUI();
						},
						data: $form.serialize(),
						success:function(result) {
							console.log(result);
							if(result.status=="SUCCESS"){
								showSucessMsg("Record saved successfully", "Save Portal");
								var currentUrl  = (window.location.pathname);
								if(currentUrl.indexOf("create") > -1 || currentUrl.indexOf("update") > -1){
									// redirect to update Job page
									showSucessMsg("Please wait while we redirecting you to edit Job page. ", "Page redirection");
									window.location.href = "/admin/portal/update?id="+result.portal.id;
									return;
								}
							}else {
								showError("Portal is already Available");
							}
							App.unblockUI();
						},
						error:function(status, respone, error) {
							showError("Unable to process the request");
							App.unblockUI();
						}
					});
                }
            });

    }


    return {
        //main function to initiate the module
        init: function () {
            handleValidation1();
        }

    };

}();
jQuery(document).ready(function() {   
	   // initiate layout and plugins
	   $("#countryval").keypress(function (e) {
		    //if the letter is not digit then display error and don't type anything
		    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
		       //display error message
		       $("#errmsgfp").html(transDigits).show().fadeOut("slow");
		              return false;
		   }
		  });
	   $('#addvalue').click(function(){
			//alert($('#country_id :selected').text());
			
			var testlabel = $('#country_id :selected').text();
			var telval = $('#countryval').val();
			var countryid = $('#country_id :selected').val();
			var countryiso = $('#country_id :selected').attr('data-iso');
			if((telval == "") || (telval == " "))
			{
				$('#countrybox').addClass("has-error");
				$('#countrytext').append("<span class='help-block' id='countryerr' >This field is required.</span>");
			}else{
				$('#countrybox').removeClass("has-error");
				$('#countryerr').remove();
				$("#country_id option[value='"+countryid+"']").remove();
				var result = $('#country_id option[value!=""]:first').html();
				
				$(".select2-chosen").text(result);
				$('#addcontact').append("<div class='form-group'><label class='control-label col-md-3' style='text-transform: uppercase;'>Tel_"+countryiso+"</label><div class='col-md-7'><input type='text' name='PortalContact["+countryid+"]' value="+telval+" class='form-control' /></div</div><br />");
				if($('#country_id > option[value!=""]').length == 0)
				{
					$('#addtelfeilds').hide();
				}
				$('#countryval').val(" ");
				}
			});
	}); 