<?php $selectBank = "<select class='form-control select2me' name='bank'>";
    foreach ($bankList as $bank) {
    $selectBank .= "<option value='$bank->id'>$bank->name</option>";
    }
    $selectBank .= "</select>";
$selectPaymentMode = "<select class='form-control select2me' name='payment_mode'>
    <option ='cheque'>Cheque</option>
    <option ='cash'>Cash</option>
</select>"; 
//echo "<pre>"; print_r($data);
?>
<div class='modal fade' id='<?php echo $data->id; ?>'>
    <div class='modal-dialog'>
        <div class='modal-content'>     
            <div class='modal-body'>
                <!--  content starts here -->
                <form method='get' action='/admin/invoice/updateinvoicepayment?id=<?php echo $data->id; ?>' id='form_InvoicePayment_<?php echo $data->id; ?>' role='form' class='form-horizontal' novalidate='novalidate'>
                    <input type="hidden" name="hotel_id" id="hotel_id" value="<?php echo $data->hotel->id;?>" />
                    <input type="hidden" name="inv_number" id="inv_number" value="<?php echo $data->inv_no;?>"/>
                    <input type="hidden" name="inv_id" id="inv_id" value="<?php echo $data->id;?>"/>
                    <input type="hidden" name="pending_inv" id="pending_inv_<?php echo $data->id;?>" value="<?php echo $data->pending_inv;?>"/>
                    <div class='form-body'>
                        <div class='form-group'>New Regulation Bills <?php echo $data->inv_no; ?></div>
                        <div class='row form-group'>
                            <label class='control-label col-md-3'>
                                Amount
                            </label>
                            <div class='col-md-9'>
                                <input type='text' id="inv_amount_<?php echo $data->id; ?>" class='form-control' name='amount' value="<?php echo $data->pending_inv; ?>"/>
                                <span class="color-red" id="inv_amount_error_<?php echo $data->id; ?>"></span>
                            </div>
                        </div>

                        <div class='row form-group'>
                            <label class='control-label col-md-3'>
                                Date
                            </label>
                            <div class='col-md-9'>
                                <input id='datepickerInvoice' id="inv_date_<?php echo $data->id; ?>" type='text' class='form-control' name='dateInvoice' value="<?php echo date('m/d/Y'); ?>"/>
                                <span class="color-red" id="inv_date_error_<?php echo $data->id; ?>"></span>
                            </div>
                        </div>

                        <div class='row form-group'>
                            <label class='control-label col-md-3'>
                                Refrence
                            </label>
                            <div class='col-md-9'>
                                <input type='text' class='form-control' name='refrence'/>
                            </div>
                        </div>

                        <div class='row form-group'>
                            <label class='control-label col-md-3'>
                                Account
                            </label>
                            <div class='col-md-9'>
                                <?php echo $selectBank; ?>
                            </div>
                        </div>

                        <div class='row form-group'>
                            <label class='control-label col-md-3'>
                                Payment Mode
                            </label>
                            <div class='col-md-9'>
                                <?php echo $selectPaymentMode; ?>
                            </div>
                        </div>

                        <div class='row form-group'>
                            <label class='control-label col-md-3'></label>
                            <div class='col-md-9'>
                                <button type='button' onclick="saveBankDetails(<?php echo $data->id; ?>);" class='btn pull-right btn-primary green' id="add_back_details">Submit</button>		
                            </div>	
                        </div>								
                    </div></form>	
                <!--  content starts here -->		
            </div>       
        </div>
    </div>
</div>
<!--<a href='javascript:void(0)' class="customPopover" data-html='true' data-placement='left' data-toggle='popover' data-html='true' data-content='<ul class="popoverList"><li><a data-toggle="modal" href="#<?php echo $data->id; ?>">New Regulations</a></li><li><a data-toggle="modal" href="#<?php echo $data->id; ?>">New Regulations</a></li><li><a data-toggle="modal" href="#<?php echo $data->id; ?>">New Regulations</a></li><li><a data-toggle="modal" href="#<?php echo $data->id; ?>">New Regulations</a></li></ul>'><i title='Add / Edit' class='fa fa-external-link-square'></i></a> &nbsp;&nbsp;-->
<a href='javascript:void(0)' class="customPopover" data-html='true' data-placement='left' data-toggle='popover' data-html='true' data-content='<ul class="popoverList"><li><a href="<?php echo "/admin/invoice/downloadinvoice?invId=". $data->id; ?>">Export Invoice</a></li></ul>'><i title='Add / Edit' class='fa fa-external-link-square'></i></a> &nbsp;&nbsp;