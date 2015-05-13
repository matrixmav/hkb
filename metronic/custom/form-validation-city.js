var FormValidation = function () {

    var handleValidation1 = function() {
        // for more info visit the official plugin documentation: 
            // http://docs.jquery.com/Plugins/Validation

            var form1 = $('#form_sample_3_city');
            var error1 = $('.alert-danger', form1);
            var success1 = $('.alert-success', form1);

            form1.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "",
                rules: {
                	'City[name]': {
                        required: true,
                    },
                    'City[latitude]': {
                        required: true,
                    },
                    'City[longitude]': {
                        required: true,
                    },
                    'City[longitude]': {
                        required: true,
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

                submitHandler: function (form,event) {
                    //success1.show();
                    error1.hide();
                    event.preventDefault();
					$form=$("#form_sample_3_city");
					var formData = new FormData();
					formData.append('file', $('input[type=file]')[0].files[0]);
					$form.serializeArray().forEach(function(field) {
						  formData.append(field.name, field.value)
					});
					$.ajax({
						dataType:'json',
						type: "post",
						url:$form.attr("action"),
						beforeSend:function(){
							App.blockUI();
						},
						data: formData,
						processData: false,
						contentType: false,
						success:function(result) {
							if(result.status=="SUCCESS"){
								showSucessMsg("Record saved successfully", "Save City");
								var currentUrl  = (window.location.pathname);
								if(currentUrl.indexOf("create") > -1){
									// redirect to update Job page
									showSucessMsg("Please wait while we redirecting you to edit City page. ", "Page redirection");
									window.location.href = "/admin/user/";
									return;
								}		
							}else if(result.errorMessage){
								showError(result.errorMessage);
							}
							else {
								showError("Error in saving record");
							}
							App.unblockUI();
						},
						error:function(status, respone, error) {
							showError("City Is Already Available");
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
   $("#ytimage").val(modelImage);
   $( "#country_id" ).change(function() {
	   $.ajax({
	   	type: "POST",
	   	url: url,
	   	data: { countryid: $('#country_id :selected').val()},
	   	success: function(result){
	   				$('#state_id').html(result);
	   		}
	   	});
	});
});