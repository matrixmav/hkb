<section class="wrapper contentPart">
  <div class="container3">
    <div class="contentCont">
    
      <p class="heading"><?php echo Yii::t('front_end','MY_Account');?></p>
      <div class="borderDiv"></div>
       <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'form-myaccount-id',
        'action' => Yii::app()->createUrl('customer/myaccount'),  //<- your form action here
		)); ?>
      <div class="myAccount">
      	<p class="Subheading"><?php echo Yii::t('front_end','General_information');?> :</p><br/>
      	<div id="errormsg1" style="color: red;"></div>
    <div id="errormsg" style="color: red;"></div><br / >
      	<input type="hidden" name="Customer[id]" value="<?php echo $userdetails->id;?>" />
        <div class="box fleft">
           <label> <?php echo Yii::t('front_end','first_name');?> *</label>
			<?php echo $form->textField($userdetails,'first_name',array('class'=>'textBox mandtory','id'=>'fname','autocomplete'=>'off','size'=>60,'maxlength'=>75)); ?>
			<?php echo $form->error($userdetails,'first_name'); ?>
        </div>
        <div class="fright box">
             <label> <?php echo Yii::t('front_end','last_name');?> *</label>
				<?php echo $form->textField($userdetails,'last_name',array('class'=>'textBox mandtory','id'=>'laname','autocomplete'=>'off','size'=>60,'maxlength'=>75)); ?>
				<?php echo $form->error($userdetails,'last_name'); ?>
        </div>
        <div class="clear"></div>
        <div class="box fleft">
            <label> <?php echo Yii::t('front_end','email_address');?> *</label>
				<?php echo $form->textField($userdetails,'email_address',array('class'=>'textBox mandtory','id'=>'email_myacc','autocomplete'=>'off','size'=>60,'maxlength'=>150)); ?>
				<?php echo $form->error($userdetails,'email_address'); ?>
        </div>
        <div class="box fright">
       
            <label> <?php echo Yii::t('front_end','Cell_phone_number');?> *</label>
            <div class="clear"></div>
            <?php echo $form->textField($userdetails,'telephone',array('class'=>'textBox cellPhone mandtory','id'=>'telephone_myacc','size'=>15,'maxlength'=>15)); ?>
			<?php echo $form->error($userdetails,'telephone'); ?><span id="errmsg" style="color: red;"></span>
            <select name="Customer[country_id]" class="customeSelect phoneNoPrefix">
                <?php 
                $countryObject = BaseClass::getCountryCode();
                foreach($countryObject as $codeObject) {?>
                <option <?php echo $userdetails->country_id == $codeObject->id ? "selected='selected'" : ""; ?> value="<?php echo $codeObject->id;?>"><?php echo strtoupper($codeObject->iso_code);?> (+<?php echo $codeObject->country_code;?>)</option>
                <?php } ?>
            </select>
        </div>
        <div class="clear35"></div>
        <p class="Subheading"><?php echo Yii::t('front_end','Change_password');?> :</p><br>
        <div id="pswderrormsg" style="color: red;"></div>
        <div id="msg" style="color: red;"><?php if(isset($msg)){echo $msg;}?></div>
        <div class="fleft box">
            <label><?php echo Yii::t('front_end','Current_Password');?></label>
            <input  type="password" name="currentpassword" class="textBox pswdmandtory" id="currentpswd" autocomplete="off">
        </div>
        <div class="clear"></div>
        <div class="fleft box">
            <label><?php echo Yii::t('front_end','New_Password');?></label>
            <input name="newpassword" type="password" class="textBox pswdmandtory" id="newpswd" >
        </div>
        <div class="fright box">
            <label><?php echo Yii::t('front_end','Confirm_new_password');?></label>
            <input type="password" class="textBox pswdmandtory" id="confirmpswd">
        </div>
        <div class="clear25"></div>
        <input type="submit" id="save" class="button" value="<?php echo Yii::t('front_end','save_the_modifications');?>" style="width: 100%;"/>
        <div class="clear10"></div>
      </div>
      <?php $this->endWidget(); ?>
      </div>
    </div>
  </div>
  
</section>
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