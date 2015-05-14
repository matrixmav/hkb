<?php

if((!isset($_COOKIE["Auth"]))||$_COOKIE["Auth"]=="")
{
	header("Location: login.php?error=expired");
}
else{

	list($cookieUser,$cookiePassword,$cookieExpire)=explode("~",$_COOKIE["Auth"]);
	
	if($cookieExpire<time()){
		
		$return_url = "login.php?error=expired";
		if(isset($category)) $return_url.="&category=".$category;
		if(isset($action)) $return_url.="&action=".$action;
		if(isset($page)) $return_url.="&page=".$page;
		if(isset($folder)) $return_url.="&folder=".$folder;
		header("Location: ".$return_url);
		
	}
	else
	{
	
		mysql_connect($DBHost,$DBUser,$DBPass);
		mysql_select_db ($DBName) or die ("DB access denied");

					
		$strSelect="SELECT * FROM ".$DBprefix."admin_users WHERE username='".$cookieUser."' and password='".$cookiePassword."'";
			
		$LoginResult=mysql_query($strSelect);
		$LoginInfo = mysql_fetch_array($LoginResult);
			
		if(mysql_num_rows($LoginResult)==1&&$LoginInfo["username"]=="administrator") 
		{
			$AuthUserName=$LoginInfo["username"];
			$AuthGroup="Administrators";
		}
		else {
			header("Location: login.php?error=login");
		}
	
	
		mysql_close();
	}
}


?>