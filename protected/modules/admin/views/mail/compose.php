<?php
$this->breadcrumbs = array(
    'Email' => array('/admin/email'),
    'Compose'
);
$customerObject = array();
?>
<form class="form-horizontal" role="form" id="form_admin_reservation" action="/admin/mail/compose" method="post">
<div class="col-md-12 form-group">
    <label class="col-md-2">To *</label>
    <div class="col-md-6">
        <input type="text" class="form-control dvalid" name="to_email" id="to_email" size="60" maxlength="75" value="<?php echo ($customerObject) ? $customerObject->first_name : ""; ?>" />
        <span class="error" style="color:red"  id="first_name_error"></span>
    </div>
</div>
<div class="col-md-12 form-group">
    <label class="col-md-2">Subject *</label>
    <div class="col-md-6">
        <input type="text" class="form-control dvalid" name="email_subject" id="email_subject" size="60" maxlength="75" class="textBox" value="<?php echo ($customerObject) ? $customerObject->last_name : ""; ?>" />
        <span class="error" style="color:red" id="last_name_error"></span>
    </div>
</div>
<div class="col-md-12 form-group">
    <label class="col-md-2">Body *</label>
    <div class="col-md-6">
        <textarea class="form-control dvalid" name="email_body" id="email_body"><?php echo ($customerObject) ? $customerObject->email_address : ""; ?></textarea>
        <span class="error" style="color:red"  id="email_address_error"></span>
    </div>
</div>
<div class="col-md-12 form-group">
    <label class="col-md-2"></label>
    <div class="col-md-6">
        <input type="submit" class="btn green" name="submit" id="submit" size="60" maxlength="75" class="textBox" value="Submit" />
    </div>
</div> 
</form>