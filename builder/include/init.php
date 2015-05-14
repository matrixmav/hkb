<?php
$FRONT_SITE_PAGES_DHTML=false;
$ENABLE_FACEBOOK_LOGIN = false;
$ALLOW_SEND_EMAIL_TO_PEOPLE_POSTED_COMMENTS = true;
$ENTERPRISE_PREFIX = false;
$KEEP_USER_STATISTICS = true;
$METER_USER_BAND = true;
$ANIMATED_CHARACTERS = false;
$USE_REPLACE_WORDS = true;
$DISABLE_BLOGS_WHEN_OVER_BANDWIDTH_QUOTA = false;
$ADMIN_EMAIL_NOTIFICATIONS_OBJECTIONABLE_CONTENT = false;

if(aParameter(401)=="SUBDOMAINS (user.domain.com)")
{
	$BLOG_URL_FORMAT =  1;
}
else
{
	$BLOG_URL_FORMAT =  2;
}

if(aParameter(402)=="YES") 
	$IMAGES_IN_DB = true;
else
	$IMAGES_IN_DB = false;

$MAX_IMAGE_SIZE =aParameter(403);

$MAX_FILE_SIZE = aParameter(404);	

$IMAGE_MAX_SIZE_EXCEEDED = aParameter(405);

$FILE_MAX_SIZE_EXCEEDED = aParameter(406);

if(aParameter(407)=="YES") 
	$USE_ABSOLUTE_URLS = true;
else
	$USE_ABSOLUTE_URLS = false;

if(aParameter(408)=="YES") 
	$WEBSITE_MULTILANGUAGE = true;
else
	$WEBSITE_MULTILANGUAGE = false;

$DEFAULT_TIME_ZONE=aParameter(409);

if(aParameter(410)=="YES") 
	$ENABLE_FRONT_SITE_CACHE = true;
else
	$ENABLE_FRONT_SITE_CACHE = false;

if(aParameter(411)=="YES") 
	$ENABLE_BLOGS_CACHE = true;
else
	$ENABLE_BLOGS_CACHE = false;


$FRONT_SITE_CACHE_EXPIRE_TIME=aParameter(412);
$BLOGS_CACHE_EXPIRE_TIME=aParameter(413);

if(aParameter(414)=="YES") 
	$USE_GD = true;
else
	$USE_GD = false;
	
if(aParameter(415)=="YES") 
	$USE_SECURITY_IMAGES = true;
else
	$USE_SECURITY_IMAGES = false;
$CAPTCHA_SALT="AX42FQ";

$BLOGGER_TEMPLATES=aParameter(416);

$DEFAULT_TEMPLATE = aParameter(417);

if(aParameter(418)=="YES") 
	$VALIDATE_EMAIL_ADDRESSES_ON_SIGNUP = true;
else
	$VALIDATE_EMAIL_ADDRESSES_ON_SIGNUP = false;

if(aParameter(419)=="YES") 
	$SERVICE_IS_FREE = true;
else
	$SERVICE_IS_FREE = false;

$CURRENCY_SYMBOL=aParameter(420);

$PAYPAL_CURRENCY_CODE=aParameter(421);

$PAYPAL_ACCOUNT=aParameter(422);

$CHEQUE_ADDRESS=aParameter(423);

$BANK_WIRE_TRANSFER_INFO=aParameter(424);

$PHP_DATE_FORMAT=aParameter(425);

$PHP_HOUR_FORMAT=aParameter(426);

if(aParameter(427)=="YES") 
	$SHOW_TOP_BAR_ON_THE_BLOGS = true;
else
	$SHOW_TOP_BAR_ON_THE_BLOGS = false;
	
$AUTHORIZED_IPS_ADMIN_PANEL=aParameter(428);
?>