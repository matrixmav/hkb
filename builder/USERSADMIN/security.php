<?php
$_SESSION['username'] = $_GET['user'];
$AuthUserName = $_SESSION['username'] ;
$AuthGroup = "Basic";
if(!isset($not_include_cofig)) include("../config.php");
/*if((!isset($_COOKIE["Auth"]))||$_COOKIE["Auth"]=="")
{
	die("<script>document.location.href='../index.php?mod=login&error=expired';</script>");
}
else{

	list($cookieUser,$cookiePassword,$cookieExpire)=explode("~",$_COOKIE["Auth"]);
	
	if($cookieExpire<time())
	{
		die("<script>document.location.href='../index.php?mod=login&error=expired';</script>");
		
	}
	else
	{
	
			mysql_connect($DBHost,$DBUser,$DBPass);
			mysql_select_db ($DBName) or die ("DB access denied");
			
			$strSelect="SELECT * FROM ".$DBprefix."admin_users WHERE username='".$cookieUser."' and password='".$cookiePassword."'";
				
			$LoginResult=mysql_query($strSelect);
			$LoginInfo = mysql_fetch_array($LoginResult);
				
			if(mysql_num_rows($LoginResult)==1) 
			{
			  
				$AuthUserName=$LoginInfo["username"];
				$AuthGroup=$LoginInfo["type"];
				
			}
			else 
			{
			   
				die("<script>document.location.href='../index.php?mod=login&error=login';</script>");
				
			}
				
			mysql_close();
	}
}*/
?>