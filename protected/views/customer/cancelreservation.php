<section class="wrapper accNotFound">
  <div class="container3">
    <div class="grayBox">
    	<div class="whiteCircle"><p class="cancellation"><span>cancellation</span><br>of reservation</p></div>
        <div class="fleft w500">
            <p class="Subheading4">Fill in the reservation number</p>
            <p class="normal3">and the email address :</p>
            <span style="color: red" id="errcls"><?php if (isset($error)){ echo $error;}?></span><br>
           <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'form-id',
       
		)); ?>
                <label>Reservation number</label>
                <input type="text" class="textBox" name="reservationnumber" id="resnum">
                <div class="clear5"></div>
                <label>Email adress</label>
                <input type="text" class="textBox" name="customeremail" id="resemail">
                <input type="submit" class="submit" id="cancelsubmit" value="OK">
                <div class="clear25"></div>
            <?php $this->endWidget(); ?>
            <p class="note">If you can't find your reservation number, please contact us at 855 378 5669</p>
        </div>
        <div class="clear"></div>
    </div>
  </div>
</section>
<script>
$(document).ready(function(){
	$('#cancelsubmit').click(function(){
		var resnumber = $('#resnum').val();
		var resemail = $('#resemail').val();
		if((resnumber == "") || (resemail == ""))
		{
			$('#errcls').text("<?php echo Yii::t('translation','Please Fill All The Feilds');?>");
			return false;
		}else
		{
			if (validateEmail(resemail)) {
				$('#errormsg').text("");
				}
				else {
					$('#errcls').text('<?php echo Yii::t('translation','Invalid Email Address');?>');
					return false;
				}
		}
	});
});
function validateEmail(sEmail) {
    var filter = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
    if (filter.test(sEmail)) {
        return true;
    }
    else {
        return false;
    }
}
</script>