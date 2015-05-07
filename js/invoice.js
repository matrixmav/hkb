
var invoice = {

    el: {
        readEquipment : $('#equipment_name'),
        commPerc : $('#comm_perc'),
        roomPricePerc : $('#comm_perc'),
    },

    init: function () { 
        invoice.bindUIActions();
    },
            
    bindUIActions: function () {
        console.log(invoice.el.readEquipment);
        $(document).on('change', invoice.el.readEquipment.selector, invoice.actions.readEquipmentData);
        $(document).on('keyup', invoice.el.commPerc.selector, invoice.actions.commPercentage);
        $(document).on('keyup', invoice.el.roomPricePerc.selector, invoice.actions.commPercentage);
    },
    actions: {
        readEquipmentData: function (){ 
            var  equipmentId = $("#equipment_name").val();
            $.ajax({
                    type: "POST",
                    url: "/admin/invoice/readequipment",
                    data: {'equipmentId': equipmentId},
                    dataType: "json",
                    success: function (resutl) {
                        if(resutl){
                            $("#opt_price").val(resutl);
                            $("#comm_perc").val("0.00");
                            $("#comm_amt").val("0.00");
                            $("#vat_perc").val("0.00");
                            $("#total_comm_amt").val(resutl);
                        }
                    }
                });
        },
        commPercentage : function() {
            var eq_amount = $("#opt_price").val();
            var com_per = $("#comm_perc").val();
            var total_amount = calculatePercentage(eq_amount, com_per);
             $("#comm_amt").val(total_amount);
            $("#total_comm_amt").val(parseInt(total_amount)+parseInt(eq_amount));
        },
        roomPricePercentage : function(){
            alert("crfeam");
        }
    }
};

$(document).ready(function () { 
    invoice.init();
});

function calculatePercentage(val1, val2)
{
    return ((val1 * val2)/100);
}

function addNewEquipment(id){
        $.ajax({
            type: "POST",
            url: "/admin/invoice/addequipment",
            data: {
                nb_reservation : $("#nb_reservation_"+id).val(),
                equipment_name: $("#add_equipment_name_"+id).val(),
                opt_price: $("#add_opt_price_"+id).val(),
                comm_perc: $("#add_comm_perc_"+id).val(),
                comm_amt: $("#add_comm_amt_"+id).val(),
                vat_perc: $("#add_vat_perc_"+id).val(),
                total_comm_amt: $("#add_total_comm_amt_"+id).val()
            },
            dataType: 'json',
            success: function (result) {
                var Url = '/admin/invoice';
                window.location.href = Url;
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(JSON.stringify(xhr));
                console.log(thrownError);
            }
        });
}

function updateEquipment(id) {  
    $.ajax({
        type: "POST",
        url: "/admin/invoice/updateinvoiceeqipment",
        data: {
            equipment_name: $("#edit_equipment_name_"+id).val(),
            opt_id: $("#equipment_name_"+id).val(),
            invoiceId: $("#invoice_id_"+id).val(),
            opt_price: $("#opt_price_"+id).val(),
            comm_perc: $("#comm_perc_"+id).val(),
            comm_amt: $("#comm_amt_"+id).val(),
            vat_perc: $("#vat_perc_"+id).val(),
            total_comm_amt: $("#total_comm_amt_"+id).val()
        },
        dataType: 'json',
        success: function (result) {
            var Url = '/admin/invoice';
            window.location.href = Url;
        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log(JSON.stringify(xhr));
            console.log(thrownError);
        }
    });
}
function caluculatePer(id) { 
    var eq_amount = $("#add_opt_price_"+id).val();
    var com_per = $("#add_comm_perc_"+id).val();
    $("#add_opt_price_"+id).val(eq_amount.replace("-","").replace("#","").replace("+","").replace("&","").replace("*","").replace("$","").replace("@","").replace("_","").replace("=",""));
    $("#add_comm_perc_"+id).val(com_per.replace("-","").replace("#","").replace("+","").replace("&","").replace("*","").replace("$","").replace("@","").replace("_","").replace("=",""));
    var eq_amount = $("#add_opt_price_"+id).val();
    var com_per = $("#add_comm_perc_"+id).val();
    var total_amount = calculatePercentage(eq_amount, com_per);
    $("#add_comm_amt_"+id).val(total_amount);
    $("#add_total_comm_amt_"+id).val(parseInt(total_amount) + parseInt(eq_amount));
}

function caluculateUpdatePer(id) { 
    var eq_amount = $("#opt_price_"+id).val();
    var com_per = $("#comm_perc_"+id).val();
    $("#opt_price_"+id).val(eq_amount.replace("-","").replace("#","").replace("+","").replace("&","").replace("*","").replace("$","").replace("@","").replace("_","").replace("=",""));
    $("#comm_perc_"+id).val(com_per.replace("-","").replace("#","").replace("+","").replace("&","").replace("*","").replace("$","").replace("@","").replace("_","").replace("=",""));
    var eq_amount = $("#opt_price_"+id).val();
    var com_per = $("#comm_perc_"+id).val();
    var total_amount = calculatePercentage(eq_amount, com_per);
    $("#comm_amt_"+id).val(total_amount);
    //$("#total_comm_amt_"+id).val(parseInt(total_amount) + parseInt(eq_amount));
    $("#total_comm_amt_"+id).val(parseFloat(total_amount) + parseFloat(eq_amount));
}

function  deleteInvoiceReservation(id) {
    var response = confirm("Are you Sure!. Do you want to delete?");  
    if(response == true){
        var Url = '/admin/invoice/deletereservationinvoice?id='+id;
        window.location.href = Url;
    }
}

//required field
function requiredField(id, errorId, message) {
    var fieldValue = $("#"+id).val();
    if (fieldValue == null || fieldValue == "") {
        if (message == null || message == "") {
            document.getElementById(errorId).textContent = "required";
        } else {
            document.getElementById(errorId).textContent = message;
        }
        return false;
    } else {
        document.getElementById(errorId).textContent = "";
        return true;
    }
}

//required field
function numaricField(id, errorId, message) {
    var fieldValue = document.getElementById(id).value;
    if (isNaN(fieldValue)) {
        if (message == null || message == "") {
            document.getElementById(errorId).textContent = "required";
        } else {
            document.getElementById(errorId).textContent = message;
        }
        return false;
    } else {
        document.getElementById(errorId).textContent = "";
        return true;
    }
}

function saveBankDetails(id) { 
    var amount = parseFloat($("#inv_amount_"+id).val());
    var inv_date = $("#inv_date_"+id).val();
    var pending_inv = parseFloat($("#pending_inv_"+id).val());
    errorFlag = 0;
    var amount_not_null = requiredField("inv_amount_"+id, "inv_amount_error_"+id,"Please enter amount field.!");
    if(amount_not_null == false){
        errorFlag = 1;
    } else {
        amountNumaric = numaricField("inv_amount_"+id, "inv_amount_error_"+id,"Amount accept only numaric value.!");
        if(amountNumaric == false){
            errorFlag = 1;
        }
    }
    if(pending_inv < amount){
        document.getElementById("inv_amount_error_"+id).textContent = "Input amount should not be more then pending balance!";
        errorFlag = 1;
    }
    if(errorFlag == 0){ 
        $("#form_InvoicePayment_"+id).submit();
    }
}

function changeStatus(id, value){
    $.ajax({
        type: "POST",
        url: "/admin/invoice/change",
        data: {'id': id,
        'status': value},
        dataType: "json",
        success: function (resutl) {  
            if(resutl == "success"){
                location.reload(true);
            }
        }
    });
}

function isAvailed(id, value){
    var availed = 'yes';
    if(value == 1){
        var availed = 'no';
    }
    $.ajax({
        type: "POST",
        url: "/admin/invoice/change",
        data: {'id': id,
        'availed': availed},
        dataType: "json",
        success: function (resutl) { 
            if(resutl == "success"){
                location.reload(true);
            }
        }
    });
}

function sendBill(hotelId,nbReservationId){
    $.ajax({
        type: "POST",
        url: "/admin/invoice/sendbill",
        data: {'hotelId': hotelId,
        'nbReservationId': nbReservationId},
        dataType: "json",
        success: function (resutl) { alert(resutl);
            if(resutl == "success"){
                location.reload(true);
            }
        }
    });
}

function testing(id){
    alert(JSON.stringify(id));
}

