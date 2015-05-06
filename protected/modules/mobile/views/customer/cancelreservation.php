<section class="intern formGroupWrap">
	<div class="circleWrap">
        <div class="circlecontent">
            <p class="heading">CANCELLATION</p>
            <p class="normal">OF RESERVATION</p>
        </div>
        <div class="circlebox"></div>        
    </div>    
    <div class="messagetext noborder">            
        <p class="heading">Fill in the reservation number</p>
        <p class="normal">and the email adress :</p>
    </div>
    <div class="clear"></div>
    
    <div class="fromBox formGroup">
    <span style="color: red" id="errcls"><?php if (isset($error)){ echo $error;}?></span><br>
     <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'form-id',
       
		)); ?>
         <input type="text" class="textBox" name="reservationnumber" placeholder="Reservation number" id="resnum" s>
         <input type="text" class="textBox" name="customeremail" id="resemail" placeholder="Email address*">
         <div class="clear"></div>
         <input type="submit" class="submitBtn ok" id="cancelsubmit" value="OK"> 
         <p class="small tcenter">If you can’t find your reservation number, <br/>
                please contact us at 855 378 5669</p>
	 <?php $this->endWidget(); ?>
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