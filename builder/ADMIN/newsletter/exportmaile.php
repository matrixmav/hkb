<?php
ob_start();
include_once("../../config.php");
include("../security.php");
header("Content-type: application/mail");
header("Content-Disposition: attachment; filename=users.txt");



	mysql_connect("$DBHost", "$DBUser", "$DBPass");
	mysql_select_db($DBName);
		
	$oDataTable=mysql_query("select distinct email from $DBprefix"."admin_users WHERE username<>'administrator' ".((isset($n)&&$n=="1")?"AND newsletter=1":"")."");
			
	while ($myArray = mysql_fetch_array($oDataTable)) 
	{	
		print $myArray['email']."\n";	
		
	}
	mysql_free_result($oDataTable);
	mysql_close();
ob_end_flush();
?>
