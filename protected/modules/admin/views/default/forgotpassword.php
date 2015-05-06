<section class="wrapper forgotPass">
  <div class="container3">
    <div class="grayBorderBox">
    	<div class="leftPart">
        	<p class="heading">How does it work ?</p>
            <p class="normal">1.&nbsp;&nbsp;Enter your email adress and your phone number.</p>
            <p class="normal">2.&nbsp;&nbsp;Enter the code you receive via text message and validate.</p>
            <p class="normal">3.&nbsp;&nbsp;Reset your password by following the instruction on the email you will receive.</p>
        </div>
        <div class="rightPart">
        	<p class="heading">FORGOT YOUR PASSWORD ?</p>
        	<span style="color: red;" id="errorfp"></span><br />
            <form>
            <div class="contentloader" id="loaderfp" style="display:none"></div>
            	<label>Email address :</label>
                <input type="text" class="textBox" id="emailfp">
                <div class="clear5"></div>
                <label>Cell phone number :</label>
                <input type="text" class="textBox tel" id="telephonefp"><div id="errmsgfp" style="color:red;"></div>
                <div class="clear"></div>
                <input id="sendcode" type="button" class="sendCode" value="SEND CODE">
                <br><span id="codeerr" style="color: red;"></span><br>
                <div class="clear"></div>
                <label>Code :</label>
                <input type="text" class="textBox code" id="code">
                <div class="clear"></div>
                <input id="validate" type="submit" class="submit" value="VALIDATE">
            </form>
        </div>
        <div class="clear"></div>
    </div>
  </div>
</section>
<script>
	var validationMessage = '<?php echo Yii::t('translation','Please Fill All The Feilds');?>';
	var fpUrl = '<?php echo Yii::app()->createUrl('admin/default/forgotpassword'); ?>';
	var InvalidCreds = '<?php echo Yii::t('translation','Invalid Credentials');?>';
	var DigitsOnly = '<?php echo Yii::t('translation','Digits Only');?>';
	var Emailerror = '<?php echo Yii::t('translation','Invalid Email Address');?>';
	var Emailnotmatch = '<?php echo Yii::t('translation','Email Does not match');?>';
	var Passwordnotmatch = '<?php echo Yii::t('translation','Password Does Not match');?>';
	var Emailpresent = '<?php echo Yii::t('translation','Already_Present');?>';
	var validateUrl = '<?php echo Yii::app()->createUrl('admin/default/validateuser'); ?>';
	var Entercode = '<?php echo Yii::t('translation','Please Enter the Code');?>';
</script>