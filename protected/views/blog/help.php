<?php
spl_autoload_unregister(array('YiiBase', 'autoload'));

define('WP_USE_THEMES', false);
require('blog/wp-blog-header.php');
$clientPost = get_post(77); 
$hotelPost = get_post(79);
$pressPost = get_post(81);
$partnersPost = get_post(83);

spl_autoload_register(array('YiiBase', 'autoload'));
?>
<script type="text/javascript" src="/js/validation.js"></script>
<script type="text/javascript" src="/js/contact.js"></script>
<link rel="stylesheet" href="/css/jquery.fancybox.css" type="text/css" media="screen" />
<section class="wrapper contentPart">
  <div class="container3">
    <div class="contentCont">
      <p class="heading">help</p>
      <div id="ourSelection" class="ui-tabs ui-widget ui-widget-content ui-corner-all">
        <ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all" role="tablist">
          <li class="ui-state-default ui-corner-top ui-tabs-active ui-state-active" role="tab" tabindex="0" aria-controls="tabs-1" aria-labelledby="ui-id-1" aria-selected="true" aria-expanded="true"><a href="#tabs-1" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-1">CLIENTS</a></li>
          <li class="ui-state-default ui-corner-top" role="tab" tabindex="-1" aria-controls="tabs-2" aria-labelledby="ui-id-2" aria-selected="false" aria-expanded="false"><a href="#tabs-2" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-2">Hotels</a></li>
          <li class="ui-state-default ui-corner-top" role="tab" tabindex="-1" aria-controls="tabs-3" aria-labelledby="ui-id-3" aria-selected="false" aria-expanded="false"><a href="#tabs-3" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-3">press</a></li>
          <li class="ui-state-default ui-corner-top" role="tab" tabindex="-1" aria-controls="tabs-4" aria-labelledby="ui-id-4" aria-selected="false" aria-expanded="false"><a href="#tabs-4" class="ui-tabs-anchor" role="presentation" tabindex="-1" id="ui-id-4">partners</a></li>
        </ul>
        <div class="help ui-tabs-panel ui-widget-content ui-corner-bottom" id="tabs-1" aria-labelledby="ui-id-1" role="tabpanel" aria-hidden="false">
          	<?php echo $clientPost->post_content; ?>
        	<div class="clear20"></div>
			<p class="withline"><a class="inlineFancybox" href="#contactForm">Contact us</a></p>
        </div>
        <div class="help ui-tabs-panel ui-widget-content ui-corner-bottom" id="tabs-2" aria-labelledby="ui-id-2" role="tabpanel" style="display: none;" aria-hidden="true">
          	<?php echo $hotelPost->post_content; ?>
            <div class="clear20"></div>
            <p class="withline"><a class="inlineFancybox" href="#contactHotelForm">Contact us</a></p>
        </div>
        <div class="help ui-tabs-panel ui-widget-content ui-corner-bottom" id="tabs-3" aria-labelledby="ui-id-3" role="tabpanel" style="display: none;" aria-hidden="true">
          	<?php echo $pressPost->post_content; ?>
            <div class="clear20"></div>
            <p class="withline"><a class="inlineFancybox" href="#contactPressForm">Contact us</a></p>
        </div>
        <div class="help ui-tabs-panel ui-widget-content ui-corner-bottom" id="tabs-4" aria-labelledby="ui-id-4" role="tabpanel" style="display: none;" aria-hidden="true">
          <?php echo $partnersPost->post_content; ?>
          <div class="clear20"></div>
          <p class="withline"><a class="inlineFancybox" href="#contactForm">Contact us</a></p>
        </div>
      </div>
    </div>
  </div>
</section>
<div id="mail_response_message"></div>

<div class="fancybox-inner" style="overflow: auto; width: 461px; display:none" id="contactForm">
    <form name="contactFrm" id="contactFrm" method="post" action="/contact/contact">
    <div style="" class="contactForm" >
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
            <input type="text" id="contact_first_name" name="first_name">
            <span class="error" id="contact_first_name_error"></span>
            </span>
            
        </li>
        <li>
            <label class="lableTitle">Last name</label><span class="fieldWrapper">
            <input type="text" id="contact_last_name" name="last_name">
            <span class="error" id="contact_last_name_error"></span>
            </span>
            
        </li>
        <li>
            <label class="lableTitle">Cell phone number</label><span class="fieldWrapper">
            <input type="text" id="contact_telephone" name="telephone" maxlength="10">
            <span class="error" id="contact_telephone_error"></span>
            </span>            
        </li>
        <li>
            <label class="lableTitle">Email address</label><span class="fieldWrapper">
            <input type="text" id="contact_email" name="email" />
            <span class="error" id="contact_email_error"></span>
            </span>            
        </li>
        <li>
            <label class="lableTitle">Your message</label><span class="fieldWrapper">
                <textarea name="message" id="contact_message"></textarea>
            <span class="error" id="contact_message_error"></span>
            </span>
            
        </li>        
      </ul>
    </section>
    <div class="captchaPane"><label>Type de charachters you see </label><span>
            <span class="captcha_text" id="contact_frm_recaptcha"><?php echo BaseClass::getReCaptcha(); ?></span>
            <input type="text" id="contact_frm_recaptcha_input" name="contact_frm_recaptcha_input"></span></div>
            <span class="error" id="contact_frm_recaptcha_input_error"></span>
    <div class="clear25"></div>
    <div class="clear15"></div>
    <div class="submitButton"><input type="button" id="contact_button" value="Send"></div>
  </div>
    </form>
</div>
    
    
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
<?php 


?>