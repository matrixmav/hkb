
<?php if(empty(Yii::app()->session['userid'])){?>

<div class="popUpconnexion" id="loginForm" style="display: none;">

	<a href="#" class="book"><?php echo Yii::t('front_end','RESERVE_WITHOUT_REGISTERING');?></a>
    <div class="clear25"></div>
    <div class="border"></div>
    <?php if(isset($error)){echo $error;}?>
    <div class="contentloader" id="loaderlog" style="display:none"></div>
    <div class="login">
    	<p class="heading"><?php echo Yii::t('front_end','Log_in');?></p>
    	<span style="color: red;" id="errorlogin"></span><br />
        <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'form-id',
        'action' => Yii::app()->createUrl('customer/login'),  //<- your form action here
		)); ?>
    	   <div class="phoneNo">
            <label><?php echo Yii::t('front_end','Cell_phone_number');?></label>
            <select class="customeSelect" name="country_code" id="country_code-menu" style='width:85px;'>
                <?php 
                $countryObject = BaseClass::getCountryCode();
                foreach(BaseClass::getCountryDropdown() as $ky=>$cn):
                                    $selected = ($cn['id'] == YII::app()->params['default']['countryId'])? "selected='selected'" : "";
                                    echo "<option ".$selected." value='".$cn['country_code']."'>".strtoupper($cn['iso_code'])."(+".$cn['country_code'].")</option>";
                                endforeach;?>
            </select>
            <?php echo $form->textField($model,'telephone',array('class'=>'textBox','id'=>'telephone','autocomplete'=>'off' ,'size'=>15,'maxlength'=>15)); ?>&nbsp;<span id="errmsg1" style="color: red;"></span>
            </div>        	
			
			<?php echo $form->error($model,'telephone'); ?>
            <div class="clear5"></div>
            <label><?php echo Yii::t('front_end','Password');?></label>
			<?php echo $form->passwordField($model,'password',array('class'=>'textBox','id'=>'password_login','autocomplete'=>'off' ,'size'=>60,'maxlength'=>150)); ?>
			<?php echo $form->error($model,'password'); ?>
            <a href="<?php echo Yii::app()->createUrl('customer/forgotpassword');?>" class="forgotPass"><?php echo Yii::t('front_end','Forgot_your_password?');?></a>
            <div class="clear"></div>
            <label><input type="checkbox"><?php echo Yii::t('front_end','Remember_me');?></label>
            <div class="clear15"></div>
            <input id="login" type="submit" value="LOG IN" class="submit">
      <?php $this->endWidget(); ?>
    </div>
    <div class="singin">
    	<p class="heading"><?php echo Yii::t('front_end','Sign_up');?></p>
    	<span style="color: red;" id="errormsg1"></span><br />
    	<span style="color: red;" id="errormsg"></span><br />
       <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'signup-form-id',
        'action' => Yii::app()->createUrl('customer/signup'),  //<- your form action here
		)); ?>
        	<div class="box fleft">
        	<label><?php echo Yii::t('front_end','first_name');?> *</label>
			<?php echo $form->textField($model,'first_name',array('class'=>'textBox','id'=>'fname','autocomplete'=>'off','size'=>60,'maxlength'=>75)); ?>
			<?php echo $form->error($model,'first_name'); ?>
            </div>
            <div class="fright box">
            <label><?php echo Yii::t('front_end','last_name');?> *</label>
				<?php echo $form->textField($model,'last_name',array('class'=>'textBox','id'=>'laname','autocomplete'=>'off','size'=>60,'maxlength'=>75)); ?>
				<?php echo $form->error($model,'last_name'); ?>
            </div>
            <div class="clear5"></div>
            <div class="box fleft">
            <label><?php echo Yii::t('front_end','email_address');?> *</label>
				<?php echo $form->textField($model,'email_address',array('class'=>'textBox','id'=>'email','autocomplete'=>'off','size'=>60,'maxlength'=>150)); ?>
				<?php echo $form->error($model,'email_address'); ?>
            </div>
            <div class="box fright">
                <label><?php echo Yii::t('front_end','Confirm_email');?> *</label>
                <input type="text" class="textBox" value="" id="confirmemail">
            </div>
            <div class="clear5"></div>
            <div class="fleft box">
            <label><?php echo Yii::t('front_end','Password');?> *</label>
			<?php echo $form->passwordField($model,'password',array('class'=>'textBox','id'=>'signuppassword','autocomplete'=>'off','size'=>60,'maxlength'=>150)); ?>
			<?php echo $form->error($model,'password'); ?>
            </div>
            <div class="fright box">
                <label><?php echo Yii::t('front_end','Confirm_password');?> *</label>
                <input type="password" class="textBox" id="confirmpassword">
            </div>
            <div class="clear5"></div>
            <label><?php echo Yii::t('front_end','Mobile_phone_number');?> *</label>
            <div class="clear"></div>
            <div class="phoneNo">
            <select class="customeSelect" name="Customer[country_id]" id="country_code_signup" >
			<?php 
                $countryObject = BaseClass::getCountryCode();
                
                foreach(BaseClass::getCountryDropdown() as $ky=>$cn):
                                    $selected = ($cn['id'] == YII::app()->params['default']['countryId'])? "selected='selected'" : "";
                                    echo "<option ".$selected." value='".$cn['id']."'>".strtoupper($cn['iso_code'])."(+".$cn['country_code'].")</option>";
                                endforeach;?>
            </select>
            </div>
			<?php echo $form->textField($model,'telephone',array('class'=>'textBox','id'=>'signuptelephone','size'=>15,'maxlength'=>15)); ?>
			<?php echo $form->error($model,'telephone'); ?>&nbsp;<span id="errmsg" style="color: red;"></span>
            <div class="clear10"></div>
            <input id="signup" type="submit" value="<?php echo Yii::t('front_end','SIGN_UP');?>" class="submit">
        <?php $this->endWidget(); ?>
    </div>
    <div class="clear"></div>
</div>
<script>
        	var validationMessage = '<?php echo Yii::t('translation','Please Fill All The Feilds');?>';
       		var loginUrl = '<?php echo Yii::app()->createUrl('customer/login'); ?>';
       		var InvalidCreds = '<?php echo Yii::t('translation','Invalid Credentials');?>';
       		var DigitsOnly = '<?php echo Yii::t('translation','Digits Only');?>';
       		var Emailerror = '<?php echo Yii::t('translation','Invalid Email Address');?>';
       		var Emailnotmatch = '<?php echo Yii::t('translation','Email Does not match');?>';
       		var Passwordnotmatch = '<?php echo Yii::t('translation','Password Does Not match');?>';
       		var Emailpresent = '<?php echo Yii::t('front_end','Already_Present');?>';
       		var validateUrl = '<?php echo Yii::app()->createUrl('customer/validateuser'); ?>';
       		var mobile = '';

            /*$(window).load(function(){
                $('#country_code-menu-menu').parent().css({"z-index":"9999"});
                //$('#country_code_signup-menu').parent().css({"z-index":"9999"});
            });*/   
            /* $( document ).ready(function() {
                $('#country_code-menu-menu').parent().css({"z-index":"9999"});
            });*/ 
</script>
<?php } ?>
