<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/customer.js?ver=<?php echo strtotime("now");?>">"></script>
<section class="connexion">
	<a href="#" class="withoutLogin"><?php echo Yii::t('front_end','RESERVE_WITHOUT_REGISTERING');?> >></a>
    
    
    
    <div class="fromBox">
    	<p class="heading"><?php echo Yii::t('front_end','Log_in');?></p>
    	<?php if(isset($errmsg)){echo "<span style='color: red;'>".$errmsg."</span>";}?>
    	<span style="color: red;" id="errorlogin"></span><br />
        <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'form-id',
        'action' => Yii::app()->createUrl('mobile/customer/login'),  //<- your form action here
		)); ?>
		<?php echo $form->textField($model,'telephone',array('class'=>'textBox','id'=>'telephone','autocomplete'=>'off' ,'size'=>15,'maxlength'=>15,'placeholder'=>'Cell phone number*')); ?><span id="errmsg1" style="color: red;"></span>
        <?php echo $form->passwordField($model,'password',array('class'=>'textBox','id'=>'password_login','autocomplete'=>'off' ,'size'=>60,'maxlength'=>150,'placeholder'=>'Password*')); ?>
            <input id="login" type="submit" value="LOG IN" class="submitBtn">
        <?php $this->endWidget(); ?>
        <div class="clear"></div>
    </div>
    
    
    
    
    
    
    
    
    <div class="fromBox">
    	<p class="heading"><?php echo Yii::t('front_end','Sign_up');?></p>
    	<span style="color: red;" id="errormsg1"></span><br />
    	<span style="color: red;" id="errormsg"></span><br />
        <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'signup-form-id',
        'action' => Yii::app()->createUrl('mobile/customer/signup'),  //<- your form action here
		)); ?>
		<?php echo $form->textField($model,'first_name',array('class'=>'textBox','id'=>'fname','autocomplete'=>'off','size'=>60,'maxlength'=>75,'placeholder'=>"First name*")); ?>
		<?php echo $form->textField($model,'last_name',array('class'=>'textBox','id'=>'laname','autocomplete'=>'off','size'=>60,'maxlength'=>75,'placeholder'=>"Last name*")); ?>
		<?php echo $form->textField($model,'email_address',array('class'=>'textBox','id'=>'email','autocomplete'=>'off','size'=>60,'maxlength'=>150,'placeholder'=>"Email address*")); ?>
        <input type="text" class="textBox" value="" id="confirmemail" placeholder="Confirm email address*">
        <?php echo $form->passwordField($model,'password',array('class'=>'textBox','id'=>'signuppassword','autocomplete'=>'off','size'=>60,'maxlength'=>150,'placeholder'=>"Password*")); ?> 
        <input type="password" class="textBox" id="confirmpassword" placeholder="Confirm password*">
            
        <div class="dInlBlock customselect2Wrap" style="width: 30%;">
           <span class="ui-icon ui-icon-triangle-1-s"></span> 
           <span class="box blBorder"></span>
           <select class="customselect2 selected">
              <option>USA +1</option>
                <option>USA +1</option>
                <option>USA +1</option>
            </select>           
           </div>

            
            <?php echo $form->textField($model,'telephone',array('class'=>'textBox cellPhone','id'=>'signuptelephone','size'=>15,'maxlength'=>15,'placeholder'=>"Cell phone number*")); ?>
            <span id="errmsg" style="color: red;"></span>
            <div class="clear"></div>
       <input id="signup" type="submit" value="<?php echo Yii::t('front_end','SIGN_UP');?>" class="submitBtn">
        <?php $this->endWidget(); ?>
        <div class="clear"></div>
    </div>
</section>
<section class="threeBox">
   <div class="box">
     <div class="pic"><img alt="" src="<?php echo Yii::app()->request->baseUrl; ?>/images/mobile/i1.png"></div>
     <div class="textPart">
       <p class="heading">best rates guaranteed</p>
       <p class="normal">Negociated rates (30 to 70% off)</p>
     </div>
   </div>
   <div class="box">
     <div class="pic"><img alt="" src="<?php echo Yii::app()->request->baseUrl; ?>/images/mobile/i2.png"></div>
     <div class="textPart">
       <p class="heading">no credit card required</p>
       <p class="normal">Privacy guarantee</p>
     </div>
   </div>
   <div class="box last">
     <div class="pic"><img alt="" src="<?php echo Yii::app()->request->baseUrl; ?>/images/mobile/i3.png"></div>
     <div class="textPart">
       <p class="heading">cancellation without charge</p>
       <p class="normal">Easy until the last minute</p>
     </div>
   </div>
 </section>
<script>
	var validationMessage = '<?php echo Yii::t('translation','Please Fill All The Feilds');?>';
	var loginUrl = '<?php echo Yii::app()->createUrl('mobile/customer/mlogin'); ?>';
	var InvalidCreds = '<?php echo Yii::t('translation','Invalid Credentials');?>';
	var DigitsOnly = '<?php echo Yii::t('translation','Digits Only');?>';
	var Emailerror = '<?php echo Yii::t('translation','Invalid Email Address');?>';
	var Emailnotmatch = '<?php echo Yii::t('translation','Email Does not match');?>';
	var Passwordnotmatch = '<?php echo Yii::t('translation','Password Does Not match');?>';
	var Emailpresent = '<?php echo Yii::t('front_end','Already_Present');?>';
	var validateUrl = '<?php echo Yii::app()->createUrl('customer/validateuser'); ?>';
	var mobile = 'mobile';
	$(document).ready(function(){
		$('.searchBox').remove();
	});
</script>