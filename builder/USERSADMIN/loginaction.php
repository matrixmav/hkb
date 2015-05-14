<?php 

ob_start();
include("../config.php");
include("../ADMIN/Utils.php");
EnsureParams();
include("../include/init.php");
define("BO_MULTILANGUAGE", "1");
define("BO_DEFAULT_LANGUAGE", "en");
define("LOGIN_PAGE", "../index.php");
define("SUCCESS_PAGE", "index.php");
define("LOGIN_EXPIRE_AFTER", 48 * 3600);
if(function_exists("date_default_timezone_set")) date_default_timezone_set($DEFAULT_TIME_ZONE);
if($_POST["sv"]!=md5($CAPTCHA_SALT.date("j").date("z").$BLOG_DOMAIN)) 
{
	die("<script>document.location.href='".LOGIN_PAGE."?mod=login&error=1';</script>");
}

if(get_param("Email") == '' || get_param("Password") == '') 
{
	die("<script>document.location.href='".LOGIN_PAGE."?mod=login&error=1';</script>");
} 
else{
		
	mysql_connect($DBHost,$DBUser,$DBPass);
	mysql_select_db ($DBName) or die ("DB access denied");

	$strSelect="select * from ".$DBprefix."admin_users where username='".get_param("Email")."' and password='".md5(get_param("Password"))."' AND blog_active=1"; 
		
	$LoginResult=mysql_query($strSelect);
	$LoginInfo = mysql_fetch_array($LoginResult);
		
	if(mysql_num_rows($LoginResult)==1) 
	{
		
		if($VALIDATE_EMAIL_ADDRESSES_ON_SIGNUP && $LoginInfo["blog_active"] == "0")
		{
		  
			mysql_close();
			die("<script>document.location='".LOGIN_PAGE."?mod=login&error=2';</script>");					
			
		}
		else
		{
			$strCookie=$LoginInfo["username"]."~".$LoginInfo["password"]."~".(time()+LOGIN_EXPIRE_AFTER);
			setcookie("Auth",$strCookie);	
			
			mysql_query
			("
				INSERT INTO ".$DBprefix."login_log(username,ip,date,action,cookie) 
				VALUES('".$LoginInfo["username"]."','".$_SERVER["REMOTE_ADDR"]."','".time()."','login','$strCookie')
			") or die(mysql_error());
								
			mysql_close();
			
			die("<script>document.location.href='".SUCCESS_PAGE."';</script>");					
			
		}
	}
	else 
	{
		
		mysql_connect($DBHost,$DBUser,$DBPass);
		mysql_select_db ($DBName) or die ("DB access denied");

		mysql_query
		("
			INSERT INTO ".$DBprefix."login_log(username,ip,date,action,cookie) 
			VALUES('".get_param("Email")."','".$_SERVER["REMOTE_ADDR"]."','".time()."','error','')
		") or die(mysql_error());

		mysql_close();
		die("<script>document.location.href='".LOGIN_PAGE."?mod=login&error=3';</script>");					
		
	}

}
	
	
ob_end_flush();
?>