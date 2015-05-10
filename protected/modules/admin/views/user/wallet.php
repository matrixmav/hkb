<?php
$this->breadcrumbs = array(
    'Wallet' => array('/admin/mail'),
    'Recharge'
);
?>
<?php 
$mailObject = array();
if(!empty($error)){
    echo "<p>".$error."</p>";
}
?>

<form class="form-horizontal" role="form" id="form_admin_reservation" enctype="multipart/form-data" action="/admin/mail/compose" method="post" onsubmit="return validateForm()">
<div class="col-md-12 form-group">
    <label class="col-md-2">Fund *</label>
    <div class="col-md-6">
        <input type="text" class="form-control dvalid" name="to_email" id="to_email" size="60" maxlength="75" value="<?php echo (!empty($walletObject)) ? $walletObject->touser->email : ""; ?>" />
        <span class="error" style="color:red"  id="first_name_error"></span>
    </div>
</div>
<div class="col-md-12 form-group">
    <label class="col-md-2">Subject *</label>
    <div class="col-md-6">
        <input type="text" class="form-control dvalid" name="email_subject" id="email_subject" size="60" maxlength="75" class="textBox" value="<?php echo (!empty($walletObject)) ? $walletObject->subject : ""; ?>" />
        <span class="error" style="color:red" id="last_name_error"></span>
    </div>
</div>
<div class="col-md-12 form-group">
    <label class="col-md-2"></label>
    <div class="col-md-6">
        <input type="submit" class="btn green" name="submit" id="submit" size="60" maxlength="75" class="textBox" value="Submit" />
    </div>
</div> 
</form>
<script language = "Javascript">
    function validateForm(){
        alert("cool");
    }
</script>