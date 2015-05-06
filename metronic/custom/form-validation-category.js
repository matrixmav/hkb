var FormValidation = function () {

    var handleValidation1 = function() {
        // for more info visit the official plugin documentation: 
            // http://docs.jquery.com/Plugins/Validation

            var form1 = $('#form_sample_3_category');
            var error1 = $('.alert-danger', form1);
            var success1 = $('.alert-success', form1);

            form1.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "",
                rules: {
					'CategoryName[0][name]': {required: true}, 'CategoryName[1][name]': {required: true}, 'CategoryName[2][name]': {required: true}, 'CategoryName[3][name]': {required: true},
					'CategoryName[4][name]': {required: true}, 'CategoryName[5][name]': {required: true}, 'CategoryName[6][name]': {required: true}, 'CategoryName[7][name]': {required: true},
					'CategoryName[8][name]': {required: true}, 'CategoryName[9][name]': {required: true}, 'CategoryName[10][name]': {required: true}, 'CategoryName[11][name]': {required: true},
					'CategoryName[12][name]': {required: true}, 'CategoryName[13][name]': {required: true}, 'CategoryName[14][name]': {required: true}, 'CategoryName[15][name]': {required: true}
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
					
					$form=$("#form_sample_3_category");
					$.ajax({
						dataType:'json',
						type: "get",
						url:$form.attr("action"),
						beforeSend:function(){
							App.blockUI();
						},
						data: $form.serialize(),
						success:function(result) {
							if(result.status=="SUCCESS"){
								showSucessMsg("Record saved successfully", "Save Category");
								var currentUrl  = (window.location.pathname);
								if(currentUrl.indexOf("create") > -1){
									// redirect to update Job page
									showSucessMsg("Please wait while we redirecting you to edit category page. ", "Page redirection");
									window.location.href = "/admin/category/update?id="+result.category.id;
									return;
								}		
							}else {
								showError("Error in saving record");
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