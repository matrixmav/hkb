
var contact = {

    el: {
        contactStep : $('#contact_button'),
        contact_hotel_button : $('#contact_hotel_button'),
        contact_press_button : $('#contact_press_button'),
        
    },
 
    init: function () { 
        contact.bindUIActions();
    },
            
    bindUIActions: function () {
        $(document).on('click', contact.el.contactStep.selector, contact.actions.contactAction);
        $(document).on('click', contact.el.contact_hotel_button.selector, contact.actions.contactHotelAction);
        $(document).on('click', contact.el.contact_press_button.selector, contact.actions.contactPressAction);
    },
    actions: {
        contactAction : function() {  
            var errorFlag = 0;
            var first_name =  requiredField('contact_first_name','contact_first_name_error','First Name required!');
            if (first_name == false) {
                errorFlag = 1;
            }
            var last_name =  requiredField('contact_last_name','contact_last_name_error','Last Name required!');
            if (last_name == false) {
                errorFlag = 1;
            }
            var emailNotEmpty =  requiredField('contact_email','contact_email_error','Email required!');
            if (emailNotEmpty == true) {
                var email_address = isValidEmail('contact_email','contact_email_error',"Enter valid email!");
                if (email_address == false) {
                    errorFlag = 1;
                }
            } else {
                errorFlag = 1;
            }
            var telephoneNotEmpty =  requiredField('contact_telephone','contact_telephone_error','Telephone required!');
            if (telephoneNotEmpty == true) {
                var telephone = numaricField('contact_telephone', 'contact_telephone_error', 'Enter only number!');
                if (telephone == false) {
                    errorFlag = 1;
                }
            } else {
                errorFlag = 1;
            }
            var message =  requiredField('contact_message','contact_message_error','Message required!');
            if (message == false) {
                errorFlag = 1;
            }
            var contactReCaptcha = requiredField('contact_frm_recaptcha_input','contact_frm_recaptcha_input_error','Please enter recaptcah code!');
            if (contactReCaptcha == false) {
                errorFlag = 1;
            } else {
                if($.trim($("#contact_frm_recaptcha").html()) != $.trim($("#contact_frm_recaptcha_input").val())){
                    $("#contact_frm_recaptcha_input_error").html("Invalid Captcha!!!");
                    errorFlag = 1;
                }
            }
            if(errorFlag == 1){
                return false;
            } else {  
                $.ajax({
                    type: "POST",
                    url: "/contact/sendcontactdetails",
                    data: $("#contactFrm").serialize(),
                    dataType: "json",
                    success: function (contactId) { 
                        $("#mail_response_message").text('Email sent!');
                        $.fancybox.close();
                    },
                     error: function (message) {
                        $("#mail_response_message").text('Email sent!');
                        $.fancybox.close();
                     }
                });
            }
        },
        contactHotelAction:function(){
            var errorFlag = 0;
            var first_name =  requiredField('contact_hotel_first_name','contact_hotel_first_name_error','First Name required!');
            if (first_name == false) {
                errorFlag = 1;
            }
            var last_name =  requiredField('contact_hotel_last_name','contact_hotel_last_name_error','Last Name required!');
            if (last_name == false) {
                errorFlag = 1;
            }
            var emailNotEmpty =  requiredField('contact_hotel_email','contact_hotel_email_error','Email required!');
            if (emailNotEmpty == true) {
                var email_address = isValidEmail('contact_hotel_email','contact_hotel_email_error',"Enter valid email!");
                if (email_address == false) {
                    errorFlag = 1;
                }
            } else {
                errorFlag = 1;
            }
            var telephoneNotEmpty =  requiredField('contact_hotel_telephone','contact_hotel_telephone_error','Telephone required!');
            if (telephoneNotEmpty == true) {
                var telephone = numaricField('contact_hotel_telephone', 'contact_hotel_telephone_error', 'Enter only number!');
                if (telephone == false) {
                    errorFlag = 1;
                }
            } else {
                errorFlag = 1;
            }
            var message =  requiredField('contact_hotel_message','contact_hotel_message_error','Message required!');
            if (message == false) {
                errorFlag = 1;
            }
            var hotel_name =  requiredField('contact_hotel_name','contact_hotel_name_error','Hotel Name required!');
            if (hotel_name == false) {
                errorFlag = 1;
            }
            var contactReCaptcha = requiredField('hotel_frm_recaptcha_input','hotel_frm_recaptcha_input_error','Please enter recaptcah code!');
            if (contactReCaptcha == false) {
                errorFlag = 1;
            } else {
                if($.trim($("#hotel_frm_recaptcha").html()) != $.trim($("#hotel_frm_recaptcha_input").val())){
                    $("#hotel_frm_recaptcha_input_error").html("Invalid Captcha!!!");
                    errorFlag = 1;
                }
            }
            if(errorFlag == 1){
                return false;
            } else {  
                $.ajax({
                    type: "POST",
                    url: "/contact/sendcontactdetails",
                    data: $("#contactHotelFrm").serialize(),
                    dataType: "json",
                    success: function (contactId) { 
                        $("#mail_response_message").text('Email sent!');
                        $.fancybox.close();
                    },
                     error: function (message) {
                        $("#mail_response_message").text('Email sent!');
                        $.fancybox.close();
                     }
                });
            }
        },
        
        contactPressAction:function(){
            var errorFlag = 0;
            var first_name =  requiredField('contact_press_first_name','contact_press_first_name_error','First Name required!');
            if (first_name == false) {
                errorFlag = 1;
            }
            var last_name =  requiredField('contact_press_last_name','contact_press_last_name_error','Last Name required!');
            if (last_name == false) {
                errorFlag = 1;
            }
            var emailNotEmpty =  requiredField('contact_press_email','contact_press_email_error','Email required!');
            if (emailNotEmpty == true) {
                var email_address = isValidEmail('contact_press_email','contact_press_email_error',"Enter valid email!");
                if (email_address == false) {
                    errorFlag = 1;
                }
            } else {
                errorFlag = 1;
            }
            var telephoneNotEmpty =  requiredField('contact_press_telephone','contact_press_telephone_error','Telephone required!');
            if (telephoneNotEmpty == true) {
                var telephone = numaricField('contact_press_telephone', 'contact_press_telephone_error', 'Enter only number!');
                if (telephone == false) {
                    errorFlag = 1;
                }
            } else {
                errorFlag = 1;
            }
            var message =  requiredField('contact_press_message','contact_press_message_error','Message required!');
            if (message == false) {
                errorFlag = 1;
            }
            var company_name =  requiredField('contact_press_company_name','contact_press_company_name_error','First Name required!');
            if (company_name == false) {
                errorFlag = 1;
            }
            $("#contact_press_recaptcha_input_error").html('');
            if($.trim($("#contact_press_recaptcha_input").val()) != $.trim($("#contact_press_recaptcha").html())){
                $("#contact_press_recaptcha_input_error").html('Invalid captcha!');
                errorFlag = 1;
            }
            if(errorFlag == 1){
                return false;
            } else {  
                $.ajax({
                    type: "POST",
                    url: "/contact/sendcontactdetails",
                    data: $("#contactPressFrm").serialize(),
                    dataType: "json",
                    success: function (contactId) { 
                        $("#mail_response_message").text('Email sent!');
                        $.fancybox.close();
                    },
                     error: function (message) {
                        $("#mail_response_message").text('Email sent!');
                        $.fancybox.close();
                     }
                });
            }
        }
        
    }
};
//required field
function requiredField1(id, errorId, message) {
    var fieldValue = $("#"+id).val();
    if (fieldValue == null || fieldValue == "") { 
        if (message == null || message == "") {
            $("#"+errorId).val("required");
        } else {
            $("#"+errorId).text(message);
            $("#"+errorId).val(message);
        }
        return false;
    } else {
        $("#"+errorId).val('');
        return true;
    }
}

$(document).ready(function () { 
    contact.init();
});
