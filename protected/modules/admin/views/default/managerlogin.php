<script type="text/javascript" src="/js/validation.js"></script>
<script type="text/javascript" src="/js/contact.js"></script>
<link rel="stylesheet" href="/css/jquery.fancybox.css" type="text/css" media="screen" />
<section class="wrapper loginBox">
  <div class="container3">
    <div class="grayBorderBox">
    	<div class="leftPart">
        	<p class="heading">hotel managers</p>
            <p class="Subheading">Wish to sign up your hotel ?</p>
            <p class="normal">Please call us at <?php echo Yii::app()->params['dayuseContactNumber'];?> or click <a class="inlineFancybox" href="#contactHotelForm">here</a></p>
            <!-- href="//echo Yii::app()->createUrl('hotel/contract');"-->
        </div>
        <div class="rightPart">
        	<p class="heading">Log in</p>
            <form class="login-form" name="manager_login" id="manager_login" action="" method="">
                <input type="text" class="textBox form-group" name="username" id="username" placeholder="Email address :">
                <span class="help-block"></span>
                <div class="clear5"></div>
                <input type="password" class="textBox form-group" name="password" id="password" placeholder="Password">
                <span class="help-block"></span>                
                <div class="clear"></div>
                <a href="/admin/default/forgotpassword" class="forgotPass">Forgot your password ?</a>
                <div class="clear"></div>
                <input type="submit" class="submit" value="OK">
            </form>
        </div>
        <div class="clear"></div>
    </div>
  </div>
</section>
  <div id="contactHotelForm" class="contactForm" style="display:none">
    <form name="contactHotelFrm" id="contactHotelFrm" action="/contact/contact">
    <section class="title">CONTACT US</section>
    <div class="clear25"></div>
    <section>
      <ul class="formContent">
        <li><label class="lableTitle"></label><div class="CustomRadioButton">     
          <span><input type="radio" value="Mr" name="gender" class="radioItemCustom" label="Mr" checked="checked"></span>
          <span><input type="radio" value="Mrs" name="gender" class="radioItemCustom" label="Mrs"></span>
        </li>      
        <li>
            <label class="lableTitle">First name</label><span class="fieldWrapper">
            <input id="contact_hotel_first_name" type="text" name="first_name">
            <span class="error" id="contact_hotel_first_name_error"></span></span>
        </li>
        <li>
            <label class="lableTitle">Last name</label><span class="fieldWrapper">
            <input id="contact_hotel_last_name" type="text" name="last_name">
            <span class="error" id="contact_hotel_last_name_error"></span></span>
        </li>
        <li>
            <label class="lableTitle">Name of hotel</label><span class="fieldWrapper">
            <input id="contact_hotel_name" type="text" name="hotel_name">
            <span class="error" id="contact_hotel_name_error"></span></span>
        </li>
        <li>
            <label class="lableTitle">Position</label><span class="fieldWrapper">
            <input id="text" type="text" name="position"></span>
        </li>
        <li>
            <label class="lableTitle">Web site</label><span class="fieldWrapper">
            <input id="text" type="text" name="web_url"></span>
        </li>
        <li>
            <label class="lableTitle">Email address</label><span class="fieldWrapper">
            <input id="contact_hotel_email" type="text" name="email">
            <span class="error" id="contact_hotel_email_error"></span></span>
        </li>
        <li>
            <label class="lableTitle">Telephone number</label><span class="fieldWrapper">
            <input id="contact_hotel_telephone" type="text" name="telephone" maxlength="10">
            <span class="error" id="contact_hotel_telephone_error"></span></span>
        </li>
        <li>
            <label class="lableTitle">Your message</label><span class="fieldWrapper">
            <textarea name="message" id="contact_hotel_message"></textarea>
            <span class="error" id="contact_hotel_message_error"></span></span>
        </li>        
      </ul>
    </section> 
    <div class="captchaPane"><label>Type de charachters you see </label><span class="fieldWrapper">
            <span class="captcha_text" id="hotel_frm_recaptcha"><?php echo BaseClass::getReCaptcha(); ?></span>
            <input type="text" id="hotel_frm_recaptcha_input" name="hotel_frm_recaptcha_input"></span></div>
            <span class="error" id="hotel_frm_recaptcha_input_error"></span></span>
    <div class="clear25"></div>
    <div class="clear15"></div>
    <div class="submitButton"><input type="button" id="contact_hotel_button" value="Send" /></div>
  </form>
  </div>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="/metronic/custom/login-manager-admin.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
  
<script type="text/javascript">
  window.onload = function() {
	Login.init();	
  }
  </script>
  <script type="text/javascript" src="/js/jquery.fancybox.js"></script>