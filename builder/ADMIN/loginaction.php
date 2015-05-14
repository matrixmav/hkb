<?php
ob_start();
 define("LOGIN_PAGE", "login.php");
 define("SUCCESS_PAGE", "index.php");
 define("LOGIN_EXPIRE_AFTER", 20000);
include("../config.php");
include("Utils.php");
include("../include/init.php");

if(get_param("Email") != 'administrator' || get_param("Email") == '' || get_param("Password") == '') 
{
		header("Location: ".LOGIN_PAGE."?error=no");
}
else
{
	mysql_connect($DBHost,$DBUser,$DBPass);
	mysql_select_db ($DBName) or die ("DB access denied");

	 $strSelect="select * from ".$DBprefix."admin_users where username='".trim(get_param("Email"))."' and password='".md5(trim(get_param("Password")))."'";
	
	$LoginResult=mysql_query($strSelect);
	$LoginInfo = mysql_fetch_array($LoginResult);


	if(mysql_num_rows($LoginResult)==1&&$LoginInfo["username"]=="administrator"&&$LoginInfo["password"]==md5(trim(get_param("Password"))))
	{
		$strCookie=$LoginInfo["username"]."~".$LoginInfo["password"]."~".(time()+LOGIN_EXPIRE_AFTER);

		setcookie("Auth",$strCookie);

		mysql_query
		("
			INSERT INTO ".$DBprefix."login_log(username,ip,date,action,cookie)
			VALUES('".$LoginInfo["username"]."','".$_SERVER["REMOTE_ADDR"]."','".time()."','login','$strCookie')
		");

		mysql_close();

		if(isset($return_url))
		{
			echo "<script>document.location.href='index.php?m=1".$return_url."';</script>";
		}
		else
		{
			echo "<script>document.location.href='".SUCCESS_PAGE."';</script>";
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
		");

		mysql_close();
		
		die("<script>document.location.href='".LOGIN_PAGE."?error=login".(isset($return_url)?$return_url:"")."'</script>");

	}
}

ob_end_flush();
?>