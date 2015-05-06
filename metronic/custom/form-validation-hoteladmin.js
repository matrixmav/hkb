var FormValidation = function () {

    var handleValidation1 = function() {
        // for more info visit the official plugin documentation: 
            // http://docs.jquery.com/Plugins/Validation

            var form1 = $('#form_sample_3_hoteladmin');
            var error1 = $('.alert-danger', form1);
            var success1 = $('.alert-success', form1);

            form1.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "",
                rules: {
                    'HotelAdministrative[account_no]': {
                        required: true
                    },
                    /*'HotelAdministrative[hotel_ownfirst_name]': {
                        required: true
                    },
                    'HotelAdministrative[hotel_ownlast_name]': {
                        required: true
                    },*/
                    /*
					'HotelAdministrative[contract_file]': {
                        required: true
                    },
                    */
                    'HotelAdministrative[contract_start_date]': {
                        required: true
                    },
                    /*
                    'HotelAdministrative[registration_no]': {
                        required: true
                    },
                    'HotelAdministrative[vat_no]': {
                        required: true
                    },
                    'HotelAdministrative[accounting_info]': {
                        required: true
                    },	*/
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
					
					$form=$("#form_sample_3_hoteladmin");
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
								showSucessMsg("Record saved successfully", "Save Administrative");
								var currentUrl  = (window.location.pathname);
								if(currentUrl.indexOf("update") > -1){
									// redirect to update Job page
									showSucessMsg("Please wait while we redirecting.", "Page redirection");
									//window.location.href = "/admin/hotel";
									window.location.href = "/admin/hotel/update?id="+result.hotel_id+"&type=administratif";									
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
    jQuery(document).ready(function() {   
	  $('#addbutton').click(function(e){
		     if($(".addedfields").length < 10){		    
		       $(".addedfields").append(
		    		   "<li style='margin-top:5px;'><input type='text' name='HotelAdministrative[email_address][]' class='form-control textbox'/>"+
					   "<a href='#' class='btn green removeBtn pull-right' id='removebutton'>Remove</a></li>"
		       );
		       e.preventDefault();
		     }
		     $(".removeBtn").on("click",function(e){
				   $(this).parent().remove();
				   e.preventDefault();
			   });
		});
	   $(".removeBtn").on("click",function(e){
		   $(this).parent().remove();
		   e.preventDefault();
	   });
		
	});
	function resetFile(){
	    $('input#contract_file').val('');
	    $('#fileUploadMessage').text('');
		  
	    return false;
	}
	function fileUpload(response,fileName){
	    $('#fileUploadMessage').text(fileName);
		   $('input#contract_file').val(response.filename);
		   return false;
	}