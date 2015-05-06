var FormValidation = function () {

    var handleValidation1 = function() {
        // for more info visit the official plugin documentation: 
            // http://docs.jquery.com/Plugins/Validation

            var form1 = $('#form_sample_3_client');
            var error1 = $('.alert-danger', form1);
            var success1 = $('.alert-success', form1);

            form1.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "",
                rules: {
		     'Client[name]': {
                        required: true
                    },
                    'Client[client_no]': {
                        required: true
                    },
                    'Client[address]': {
                        required: true
                    },
                    'Client[postal_code]': {
                        required: true,
                        number : true
                    },
//                    'Client[city]': {
//                        required: true
//                    },
                    'Client[country_id]': {
                        required: true
                    },
                    'Client[email_add]': {
                        required: true,
                        email:true
                        
                    },
                    'Client[language_id]': {
                        required: true
                    },
                    'Client[vat_no]': {
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
					
					$form=$("#form_sample_3_client");
					var type = $form.attr('data-type');
					$.ajax({
						dataType:'json',
						type: "post",
						url:$form.attr("action"),
						beforeSend:function(){
							App.blockUI();
						},
						data: $form.serialize(),
						success:function(result) { 
                                                    if(result){  
                                                        showSucessMsg("Record saved successfully", "Save Client");
                                                        var currentUrl  = (window.location.pathname);
                                                        if(currentUrl.indexOf("create") > -1 || currentUrl.indexOf("update") > -1){
                                                            // redirect to update Job page
                                                            showSucessMsg("Please wait while we redirecting. ", "Page redirection");
                                                            window.location.href = "/admin/client/";
                                                            return;
                                                        }
                                                        window.location.href = "/admin/client/";
                                                        return;

                                                    }
                                                    else if(result.status=="NAME-ERROR"){
                                                        showError(result.errorMessage);
                                                    }
                                                    else {
                                                        showError("Error in saving record");
                                                    }
                                                    App.unblockUI();
						},
						error:function(status, respone, error) {
                                                    showError("Client is already registered");
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
            
            $("#citytextbox").val("");
        }

    };

}();

function getCountryCityList(id){
    $.ajax({
        dataType:'json',
        type: "post",
        url:'/admin/client/readcitylist',
        beforeSend:function(){
                App.blockUI();
        },
        data: {'countryId':id},
        success:function(result) {
            
            if(result != "1"){
                $("#citydropdownList").show();
                $("#citydropdownList").html(result);
                $("#citytextbox").hide();
            } else {
                $("#citydropdownList").html("");
                $("#citydropdownList").hide();
                $("#citytextbox").show();
            }
            App.unblockUI();
             
        }
    });
    
}