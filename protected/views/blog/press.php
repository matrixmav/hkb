<?php
spl_autoload_unregister(array('YiiBase', 'autoload'));

define('WP_USE_THEMES', false);
require('blog/wp-blog-header.php');
//70 - old
$legalesPost = get_post(53); ?>
<script type="text/javascript" src="/js/validation.js"></script>
<script type="text/javascript" src="/js/contact.js"></script>
<link rel="stylesheet" href="/css/jquery.fancybox.css" type="text/css" media="screen" />
<section class="wrapper contentPart">
<div class="container3">
  	<div class="contentCont">
    	<p class="heading">PRESS</p>
    	<p class="withline"><a class="inlineFancybox" href="#contactPressForm">Contact us</a></p>
		<div class="clear50"></div>
        <p> <?php echo $legalesPost->post_content; ?></p>
    </div>
  </div>
</section>
<?php 
spl_autoload_register(array('YiiBase', 'autoload'));
?>

<div id="contactPressForm" class="contactForm" style="display:none">
    <form name="contactPressFrm" id="contactPressFrm" action="/contact/contact">
    <section class="title">CONTACT US</section>
    <div class="clear25"></div>
    <section>
      <ul class="formContent">
        <li><label class="lableTitle"></label><div class="CustomRadioButton">     
        <span><input type="radio" value="Mr" name="gender" name="mr" class="radioItemCustom" label="Mr" checked="checked"></span>
        <span><input type="radio" value="Mrs" name="gender" name="mrs" class="radioItemCustom" label="Mrs"></span>
        </li>      
        <li>
            <label class="lableTitle">First name</label><span class="fieldWrapper">
                <input id="contact_press_first_name" type="text" name="first_name">
                <span class="error" id="contact_press_first_name_error"></span></span>
        </li>
        <li>
            <label class="lableTitle">Last name</label><span class="fieldWrapper">
                <input id="contact_press_last_name" type="text" name="last_name">
                <span class="error" id="contact_press_last_name_error"></span></span>
        </li>
        <li><label class="lableTitle">Company name</label><span class="fieldWrapper">
                <input id="contact_press_company_name" type="text" name="company_name">
                <span class="error" id="contact_press_company_name_error"></span></span>
        </li>
        <li><label class="lableTitle">Position</label><span class="fieldWrapper">
                <input id="text" type="text" name="position"></span>
        </li>        
        <li><label class="lableTitle">Email address</label><span class="fieldWrapper">
                <input id="contact_press_email" type="text" name="email">
                <span class="error" id="contact_press_email_error"></span></span>
        </li>
        <li><label class="lableTitle">Telephone number</label><span class="fieldWrapper">
                <input id="contact_press_telephone" type="text" name="telephone" maxlength="10">
                <span class="error" id="contact_press_telephone_error"></span></span>
        </li>
        <li><label class="lableTitle">Your message</label><span class="fieldWrapper">
                <textarea name="message" id="contact_press_message"></textarea>
            <span class="error" id="contact_press_message_error"></span></span></span>
        </li>        
      </ul>
    </section>
    <div class="captchaPane"><label>Type de charachters you see </label><span class="fieldWrapper">
            <span class="captcha_text" id="contact_press_recaptcha"><?php echo BaseClass::getReCaptcha(); ?></span>
            <input type="text" id="contact_press_recaptcha_input" name="contact_press_recaptcha_input"></span></div>
            <span class="error" id="contact_press_recaptcha_input_error"></span>
    <div class="clear25"></div>
    <div class="clear15"></div>
    <div class="submitButton"><input type="button" id="contact_press_button" value="Send" /></div>
  </form>
  </div>
            
    <script type="text/javascript" src="/js/jquery.fancybox.js"></script>