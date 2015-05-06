var FormValidation = function () {
	
        var handleValidation1 = function() {
        // for more info visit the official plugin documentation: 
            // http://docs.jquery.com/Plugins/Validation

            var form1 = $('#form_category');
            var error1 = $('.alert-danger', form1);
            var success1 = $('.alert-success', form1);

            form1.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "",
                rules: {
                    'category': {
                        required: true
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
					
                   $form=$("#form_category");
					$.ajax({
						dataType:'json',
						type: "post",
						url:$form.attr("action"),
						beforeSend:function(){
							App.blockUI();
						},
						data: $form.serialize(),
						success:function(result) {
                                                        if(result.status=="SUCCESS"){
								showSucessMsg("Record generated successfully", "Generating Record");
								
									// redirect to update Job page
									showSucessMsg("Please wait while we redirecting.", "Page redirection");
									window.location.href = "/admin/accessCategory";
									return;
										
							}else {
								showError(result.msg);
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
var FormadminValidation = function () {
	
        var handleValidation1 = function() {
        // for more info visit the official plugin documentation: 
            // http://docs.jquery.com/Plugins/Validation

            var form1 = $('#form_aduser');
            var error1 = $('.alert-danger', form1);
            var success1 = $('.alert-success', form1);

            form1.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "",
                rules: {
                    'firstname': {
                        required: true
                    },
                    'lastname': {
                        required: true
                    },
                    'emailadd': {
                        required: true,
                        email: true
                    },
                    'mobno': {
                        required: true
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
					
                   $form=$("#form_aduser");
					$.ajax({
						dataType:'json',
						type: "post",
						url:$form.attr("action"),
						beforeSend:function(){
							App.blockUI();
						},
						data: $form.serialize(),
						success:function(result) {
                                                        if(result.status=="SUCCESS"){
								showSucessMsg("Record generated successfully", "Generating Record");
								
									// redirect to update Job page
									showSucessMsg("Please wait while we redirecting.", "Page redirection");
									window.location.href = "/admin/accessCategory/list";
									return;
										
							}else {
								showError(result.msg);
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
function selectAll(vname)
{
    var v = "mcheck"+vname;
    //$("."+v).val(12);
    
}