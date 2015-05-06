
var reservation = {

    el: {
        reservationStep : $('#reservation_step'),
        conformation : $('#validate_button'),
        existingCustomerSubmit : $('#existing_customer_submit'),
        adminReservationSubmit : $('#admin_reservation'),
        modifyBtnStepOne : $("#modify_btn_step_one"),
        modifyBtnStepTwo : $("#modify_btn_step_two"),
        adminReservatinoEdit : $("#admin_reservation_modify"),
        resendEmail : $("#resend_email"),
    },

    init: function () { 
        reservation.bindUIActions();
    },
            
    bindUIActions: function () {
        console.log(reservation.el.reservationStep);
        $(document).on('click', reservation.el.reservationStep.selector, reservation.actions.getValidationStep);
        $(document).on('click', reservation.el.conformation.selector, reservation.actions.getConformationStep);
        $(document).on('click', reservation.el.existingCustomerSubmit.selector, reservation.actions.existingCustomerSubmit);
        $(document).on('click', reservation.el.adminReservationSubmit.selector, reservation.actions.adminReservationSubmit);
        $(document).on('click', reservation.el.modifyBtnStepOne.selector, reservation.actions.modifyReservation);
        $(document).on('click', reservation.el.modifyBtnStepTwo.selector, reservation.actions.modifyReservation);
        $(document).on('click', reservation.el.adminReservatinoEdit.selector, reservation.actions.adminModifyReservation);
        $(document).on('click', reservation.el.resendEmail.selector, reservation.actions.resendEmail);
    },
    actions: {
        resendEmail: function (){
            var reserEmail = $("#resend_verification_email").val();
            var reserReservationId = $("#resend_verification_id").val();
            
            $.ajax({
                    type: "POST",
                    url: "/reservation/resendvarificationlink",
                    data: {'resendEmail': reserEmail,
                    'rservationId': reserReservationId},
                    dataType: "json",
                    success: function (resutl) {
                        if(resutl){
                            $("#email_address_error").html('Email already Existed!');
                            errorFlag = 1;
                        }
                    }
                });
        },
        getValidationStep : function() {
            var customerId = $("#id").val();
            var varificationCode = $("#varification_code").text();
            var customerName = $("#first_name").val() + " "+ $("#last_name").val(); 
            var email = $("#email_address").val();
            var phoneNumber = $("#telephone_no").val();
            var password_check = $("#customer_password").val();
            
            var userDetails = "<p class='price'> \n\
                    <span class='nor'>"+customerName+"</span><br>\n\
                    "+email+"<br>"+phoneNumber+"</p>";
            $("#your_information_confirmation").html(userDetails);
            $("#your_information_varification").html(userDetails);
                            
            $("#email_address_error").html('');
            $("#telephone_error").html('');
            $("#existing_customer_flag").val(0);
            var serviceCharge = Math.ceil(parseFloat($("#totalServiceAmount").val())) || 0;
            
            var roomRent = Math.ceil(parseFloat($('#room span').html()));
            var room_price = Math.ceil(parseFloat($('#room_price').html()));
            
            $("#total_room_reservation_price_12345").html(serviceCharge + room_price +".00");
            $("#modify_btn_step_two").show();
                
            var errorFlag = 0;
            var first_name =  requiredField('first_name','first_name_error','First Name required!');
            var last_name =  requiredField('last_name','last_name_error','Last Name required!');
            
            var email_address = isValidEmail('email_address','email_address_error',"Enter valid email!");
            var telephone = requiredField('telephone_no','telephone_error','Telephone number required!');
            
            //validate if card required
            var cardNumber = $('#card_number').val();
            if ($("#required_card_count").val() == "1") {
                
                var card_number = numaricField('card_number', 'card_number_not_valid_error', 'Enter only number!');
                if (card_number == false) {
                    errorFlag = 1;
                }
                var idCardNumberEmpty = requiredField('card_number', 'card_number_error', 'Enter card number!');
                if (idCardNumberEmpty == false) {
                    errorFlag = 1;
                }
                var holderName = requiredField('card_holder_name', 'card_holder_name_error', 'Enter card holder name!');
                if (holderName == false) {
                    errorFlag = 1;
                }
                var security_code = numaricField('card_security_code', 'card_security_code_error', 'Enter security code!');
                if (security_code == false) {
                    errorFlag = 1;
                }
                var security_code_not_null = requiredField('card_security_code', 'card_security_code_error', "Enter Valid security code");
                if (security_code_not_null == false) {
                    errorFlag = 1;
                }

            }
            if(first_name == false){
                errorFlag = 1;
            }
            if(last_name == false){
                errorFlag = 1;
            }
            if(email_address == false){
                errorFlag = 1;
            }
            if(telephone == false){
                errorFlag = 1;
            }
            if(email_address == true){ 
                if($("#existing_user").val() == 0){ 
                    var confirmEmail = $.trim($("#confirm_email_address").val());
                    var emailAddress = $.trim($("#email_address").val());
                    $("#email_address_error").html('');
                    /*if(emailAddress == confirmEmail) { 
                        var email = $("#email_address").val();
                        $.ajax({
                            type: "POST",
                            url: "/reservation/isemailexisted",
                            data: {'email': email},
                            dataType: "json",
                            success: function (result) {
                                if(result){
                                    $("#email_address_error").html('Email already Existed!');
                                    errorFlag = 1;
                                    console.log(errorFlag+"--inside");
                                }
                            }
                        });
                    }*/
                    if(emailAddress != confirmEmail){ 
                        $("#email_address_error").html('Email does not match!');
                        $("#reservation_step").text('NEXT STEP > >');
                        errorFlag = 1;
                    }
                }
            }
            /*
            console.log(errorFlag);
            if(telephone == true) { 
                var telephoneNo = parseFloat($("#telephone_no").val()); 
                if($("#existing_user").val() == 0){ 
                    $.ajax({
                        type: "POST",
                        url: "/reservation/isphoneexisted",
                        data: {'telephone': telephoneNo},
                        dataType: "json",
                        success: function (result) {
                            if(result){ 
                                $("#telephone_error").html('Telephone no already Existed!');
                                $("#reservation_step").text('NEXT STEP > >');
                                errorFlag = 1;
                                console.log(errorFlag+"--inside");
                            }
                        }
                    });
                }
            } 
            */
            if(errorFlag == 1){
                return false;
            }else {  
                $.ajax({
                    type: "POST",
                    url: "/reservation/create",
                    data: $("#customer-form").serialize(),
                    dataType: 'json',
                    success: function (result) { 
                        $("#existing_customer_flag").val("");
                        //if(result.hId && result.rId && result.roomId && result.rdate && result.cId){
                        if(result.status=="SUCCESS"){
                            var Url = '/reservation/validation?hId='+result.hId+'&rId='+result.rId+'&roomId='+result.roomId+'&date='+result.rdate+'&cId='+result.cId+'&orf='+result.orf;
                            window.location.href = Url;
                        } else {
                            if(result.email_error)
                            {
                                $("#email_address_error").html('Email already Existed!');
                            }
                            if(result.tel_error)
                            {
                                $("#telephone_error").html('Telephone no already Existed!');
                            }
                            /*
                            if(result.email_address){
                                return false;
                            }
                            alert("Something went wrong!!!. Please try again, email issue.");
                            location.reload();
                            */
                            return false;
                        }
                    },
                    error: function (xhr, ajaxOptions, thrownError) { 
                        alert("Something went wrong!!!. Please try again.");
                        return false;
                        //location.reload();
                        console.log(thrownError);
                  }
                });
            }
        },
        existingCustomerSubmit : function () {  
            $("#existing_customer_submit").text('Logging in...');
            $("#existing_customer_flag").val('1');
            var errorFlag = 0;
            var telephone_no =  requiredField('existing_customer_phone_no','existing_customer_phone_no_error','Telephone number required!');
            if(telephone_no == false){
                errorFlag = 1;
            }
            var password =  requiredField('existing_customer_password','existing_customer_password_error','password required!');
            if(password == false){
                errorFlag = 1;
            }
            if(errorFlag == 1){
                return false;
            } else {
                $.ajax({
                    type: "POST",
                    url: "/reservation/create",
                    data: $("#customer-form").serialize(),
                    dataType: "json",
                    success: function (result) {
                        if(result){
                            $("#id").val(result.id);
                            $("#first_name").val(result.first_name);
                            $("#last_name").val(result.last_name);
                            $("#email_address").val(result.email_address);
                            $("#telephone_no").val(result.telephone);
                            $("#already_member").hide();
                            $("#existing_user").val(result.id);
                            $("#access_info").show();
                            $("#access_info").html('Access approved!');
                            $("#confirmation_email").hide();
                            $("#password_ext").hide();
                            $("#confirm_password_ext").hide();
                            $("#subheading_bookfaster").hide();                            
                            $("#existing_customer_flag").val('');
                            
                            var loginLinks = "<li><a href='#'>"+result.first_name+"</a>";
                            
                            var userDetails = "<p class='price'> \n\
                                    <span class='nor'>"+result.first_name+" "+result.last_name+"</span><br>\n\
                                    "+result.email_address+"<br>"+result.telephone+"</p>";
                            $("#your_information_confirmation").html(userDetails);
                            $("#your_information_varification").html(userDetails);
                            
                            $("#mainLoginLink").html(loginLinks+loginLinkDiv);
                            
                            $("#you_are_not_member").hide();
                        } else {
                            $("#existing_customer_submit").text('SIGN IN');
                            $("#access_info").show();
                            $("#access_info").html('Account Does Not exist!');
                        }
                    } 
                    
                });
            }
        },
        getConformationStep: function () { 
            var rId = getUrlVars()['rId'];
            var rdate = getUrlVars()['date'];
            var orf = getUrlVars()['orf'];
            $("#invalid_verification_code").hide();
            $("#validate_button").text('validating...');
            var varificationCode = $("#hidden_varification_code").val();
            var inputVerificationCode = $("#input_verification_code").val();
            if(inputVerificationCode == ""){
                $("#invalid_verification_code").show();
                $("#validate_button").text('validate');
                return false;
            }
            if (varificationCode.trim() == inputVerificationCode.trim()) {
                 var Url = '/reservation/confirmation?rId='+rId+'&date='+rdate+'&orf='+orf;
                    window.location.href = Url;
            } else {
                $("#invalid_verification_code").show();
                $("#validate_button").text('validate');
                return false;
            }
            
             
        },
        adminReservationSubmit : function () { 
            
            
            var errorFlag = 0;
            var first_name =  requiredField('first_name','first_name_error','First name required!');
            if(first_name == false){
                errorFlag = 1;
            }
            var last_name =  requiredField('last_name','last_name_error','Last name required!');
            if(last_name == false){
                errorFlag = 1;
            }
            
            var email_address =  requiredField('email_address','email_address_error','Email required!');
            if(email_address == false){
                errorFlag = 1;
            }
            var telephone =  requiredField('telephone','telephone_error','Phone required!');
            if(telephone == false){
                errorFlag = 1;
            }
            
            if($("#cb").is(':checked')) { 
                var card_number = numaricField('card_number', 'card_number_not_valid_error', 'Enter only number!');
                if (card_number == false) {
                    errorFlag = 1;
                }
                var idCardNumberEmpty = requiredField('card_number', 'card_number_error', 'Enter card number!');
                if (idCardNumberEmpty == false) {
                    errorFlag = 1;
                }
                var holderName = requiredField('card_holder_name', 'card_holder_name_error', 'Enter card holder name!');
                if (holderName == false) {
                    errorFlag = 1;
                }
                var security_code = numaricField('card_security_code', 'card_security_code_error', 'Enter security code!');
                if (security_code == false) {
                    errorFlag = 1;
                }
                var security_code_not_null = requiredField('card_security_code', 'card_security_code_error', "Enter Valid security code");
                if (security_code_not_null == false) {
                    errorFlag = 1;
                }
            }
            if(errorFlag == 1){
                return false;
            } else {
                $( "#form_admin_reservation" ).submit();
            }
        },
        modifyReservation : function(){ 
            $("#reservation").show();
            $("#validation").hide();
            $("#confirmation").hide();
            $('#validation_buttons').hide();
            $("#validate_button").text('validate');
            $("#validation_sign").removeClass('dark');
            $("#confirmation_sign").removeClass('dark');
        },
        
        adminModifyReservation: function(){
           var errorFlag = 0;
            var first_name =  requiredField('customer_first_name','first_name_error','First name required!');
            if(first_name == false){
                errorFlag = 1;
            }
            var last_name =  requiredField('customer_last_name','last_name_error','Last name required!');
            if(last_name == false){
                errorFlag = 1;
            }
            
            var email_address =  validateEmail('customer_email_address','email_address_error','Email required!');
            if(email_address == false){
                errorFlag = 1;
            }
            var telephone =  requiredField('customer_telephone','telephone_error','Phone required!');
            if(telephone == false){
                errorFlag = 1;
            }
           
            if(errorFlag == 1){
                return false;
            } else {
                $( "#admin_reservation_modify").submit();
            }
        }
    }
};


$(document).ready(function () {
    $("#access_info").hide();
    reservation.init();
    //var roomPrice = parseFloat($("#room_price").html().trim());
    //$("#value").html(roomPrice+".00");
});

function getTotalServiceAmount(amount,id,isCCrequired){ 
    var cardRequiredCount = 0;
    var checkboxId = "checkbox_"+id;
    var cardCount = parseFloat($("#required_card_count").val());
    var total = Math.ceil(parseFloat($("#totalServiceAmount").val()));
    var inputAmount = Math.ceil(parseFloat(amount));
    if($("#"+checkboxId).is(':checked')) { 
        var totalAmount = (total+inputAmount);
        var selectedService = $("#service_name_and_price_"+id).html();
        $("#selected_services").append(selectedService);
        $("#selected_services_confirm").append(selectedService);
        
        $("#selected_id_collection").append(id+",");
        var ids = $("#selected_id_collection").html();
        
        $("#selected_service_id").val(ids);
        
        if(isCCrequired == "1"){
            cardRequiredCount = (cardCount+1);
            $("#required_card_count").val(cardRequiredCount);
        }
    } else { 
        if(isCCrequired == "1"){
            cardRequiredCount = (cardCount-1);
            $("#required_card_count").val(cardRequiredCount);
        }
        $("#selected_services #name_and_price_"+id).hide();
        $("#selected_services_confirm #name_and_price_"+id).hide();
        var totalAmount = (total-inputAmount);
    }
    var cardCountVal = parseFloat($("#required_card_count").val());
    if(cardCountVal > 0){
        $("#credit_card_payment_div").show();
    } else {
        $("#credit_card_payment_div").hide();
    }
    var roomPrice = parseFloat($("#room_price").html().trim());
    $('#totalServiceAmount').val(totalAmount);
    $("#value").html(totalAmount+roomPrice+".00");
}

// Read a page's GET URL variables and return them as an associative array.
function getUrlVars()
{
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for(var i = 0; i < hashes.length; i++)
    {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
}

function openCreditCard(){
    if($("#cb").is(':checked')) {
        $("#credit_card_payment_div").show();
    } else {
        $("#credit_card_payment_div").hide();
    }
}