var FormValidation = function () {

    var handleValidation1 = function() {
        // for more info visit the official plugin documentation: 
            // http://docs.jquery.com/Plugins/Validation

            var form1 = $('#form_admin_user');
            var error1 = $('.alert-danger', form1);
            var success1 = $('.alert-success', form1);

            form1.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "",
                rules: {
                    'AdminUser[first_name]': {
                        required: true
                    },
                    'AdminUser[last_name]': {
                        required: true
                    },
                    'AdminUser[telephone]': {
                        required: true
                    },
                    'AdminUser[email_address]': {
                        required: true,
                        email: true
                    }
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
					
					$form=$("#form_admin_user");
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
								showSucessMsg("Record saved successfully", "Save Admin User");
								var currentUrl  = (window.location.pathname);
								if(currentUrl.indexOf("create") > -1 || currentUrl.indexOf("update") > -1){
									// redirect to update Job page
									showSucessMsg("Please wait while we redirecting.", "Page redirection");
									window.location.href = "/admin/admin/index";
									return;
								}		
							}
                                                        else {
                                                            if(result.errorMessage!=''){
                                                             showError(result.errorMessage);   
                                                            }else{
                                                             showError("Error in saving record");   
                                                            }	
								
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
		    		   "<li style='margin-top:5px;'><input type='text' name='AdminUser[hotel][]' class='form-control textbox'/>"+
		    		   "<input type='hidden' name='AdminUser[hotel_id][]' class='form-control hotelid' value=''/>"+
					   "<a href='#' class='btn green removeBtn pull-right' id='removebutton'>Remove</a></li>"
		       );
		       e.preventDefault();
		     }
		     $(".removeBtn").on("click",function(e){
				   $(this).parent().remove();
				   e.preventDefault();
			   });
		     autoComplete("textbox","/admin/hotel/hotellist");
		});
	   $(".removeBtn").on("click",function(e){
		   $(this).parent().remove();
		   e.preventDefault();
	   });
	   autoComplete("textbox","/admin/hotel/hotellist");
});

 function split( val ) {
    return val.split( /,\s*/ );
 }
 function extractLast( term ) {
    return split( term ).pop();
 }
 function autoComplete(id,path){
	 $( "."+id )
	 .bind( "keydown", function( event ) {
	 	if ( event.keyCode === $.ui.keyCode.TAB && $( this ).autocomplete( "instance" ).menu.active ) {
	 		event.preventDefault();
	 	}
	 })
	 .autocomplete({source: function( request, response ) {
	 	$.getJSON(path, {
	 		term: extractLast( request.term )
	 	}, response );
	 },
	 search: function() {
	 // custom minLength
	 	var term = extractLast( this.value );
	 	if ( term.length < 2 ) {
	 		return false;
	 	}
	 },
	 focus: function() {
	 	// prevent value inserted on focus
	 	return false;
	 },
	 select: function( event, ui ) {
	 	var terms = split( this.value );
	 	// remove the current input
	 	terms.pop();
	 	// add the selected item
	 	terms.push( ui.item.value );
	 	// add placeholder to get the comma-and-space at the end
	 	//terms.push( "" );
	 	//this.value = terms.join( ", " );
	 	this.value = terms;
	 	$(this).next().val(ui.item.id);
	 	return false;
	 }
	 }); 
 }

