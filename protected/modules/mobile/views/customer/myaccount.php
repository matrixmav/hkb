<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/customer.js?ver=<?php echo strtotime("now");?>">"></script>
<?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'form-myaccount-id',
        'action' => Yii::app()->createUrl('mobile/customer/myaccount'),  //<- your form action here
		)); ?>
<section class="monCompte">
<p class="myAcc"><?php echo Yii::t('front_end','MY_Account');?></p>
<div class="fromBox">
<p class="heading"><?php echo Yii::t('front_end','General_information');?></p>
<div id="errormsg1" style="color: red;"></div>
    <div id="errormsg" style="color: red;"></div><br / >
<input type="hidden" name="Customer[id]" value="<?php echo $userdetails->id;?>" />
<?php echo $form->textField($userdetails,'first_name',array('class'=>'textBox mandtory','id'=>'fname','autocomplete'=>'off','size'=>60,'maxlength'=>75)); ?>
<?php echo $form->textField($userdetails,'last_name',array('class'=>'textBox mandtory','id'=>'laname','autocomplete'=>'off','size'=>60,'maxlength'=>75)); ?>
<?php echo $form->textField($userdetails,'email_address',array('class'=>'textBox mandtory','id'=>'email_myacc','autocomplete'=>'off','size'=>60,'maxlength'=>150)); ?>

  <div class="dInlBlock customselect2Wrap" style="width: 30%;">
           <span class="ui-icon ui-icon-triangle-1-s"></span> 
           <span class="box blBorder" style="line-height: 1.1em;"></span>
           <select class="customselect2 selected">
              <option>USA +1</option>
                <option>USA +1</option>
                <option>USA +1</option>
            </select>           
           </div>


<?php echo $form->textField($userdetails,'telephone',array('class'=>'textBox cellPhone mandtory','id'=>'telephone_myacc','size'=>15,'maxlength'=>15)); ?>
<span id="errmsg" style="color: red;"></span>
<div class="clear"></div>
</form>
<div class="clear"></div>
</div>
<div class="fromBox">
<p class="heading"><?php echo Yii::t('front_end','Change_password');?></p>
<div id="pswderrormsg" style="color: red;"></div>
<div id="msg" style="color: red;"><?php if(isset($msg)){echo $msg;}?></div>
<input  type="password" name="currentpassword" class="textBox pswdmandtory" id="currentpswd" autocomplete="off" placeholder="Current password*">
<input 	name="newpassword" type="password" class="textBox pswdmandtory" id="newpswd" placeholder="Confirm new password*">
<input type="password" class="textBox pswdmandtory" id="confirmpswd" placeholder="Confirm password*">
</form>
</div>
<input type="submit" id="save" class="saveChange button" value="<?php echo Yii::t('front_end','save_the_modifications');?>" style="width: 100%;"/>

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
<?php $this->endWidget(); ?>
<script>
	var validationMessage = '<?php echo Yii::t('translation','Please Fill All The Feilds');?>';
	var loginUrl = '<?php echo Yii::app()->createUrl('customer/login'); ?>';
	var InvalidCreds = '<?php echo Yii::t('translation','Invalid Credentials');?>';
	var DigitsOnly = '<?php echo Yii::t('translation','Digits Only');?>';
	var Emailerror = '<?php echo Yii::t('translation','Invalid Email Address');?>';
	var Emailnotmatch = '<?php echo Yii::t('translation','Email Does not match');?>';
	var Passwordnotmatch = '<?php echo Yii::t('translation','Password Does Not match');?>';
	var Emailpresent = '<?php echo Yii::t('translation','Already_Present');?>';
	var validateUrl = '<?php echo Yii::app()->createUrl('customer/validateuser'); ?>';
</script>