<?php
include("../config.php");
include_once("../ADMIN/Utils.php");
EnsureParams();
include("security.php");
if(!isset($AuthUserName))
{
	die("<script>document.location.href='../index.php?error=expired';</script>");
}
$lArray=DataArray("admin_users","username='$AuthUserName'");

if(isset($lng))
{
	$LANGUAGE=strtolower($lng);
	$LANGUAGE2=strtolower($lng);
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

if(!isset($LANGUAGE)||strlen($LANGUAGE)!=2)
{
	$LANGUAGE="en";
	$LANGUAGE2="en";
}


include("../include/texts_".strtolower($LANGUAGE2).".php");
include("../include/init.php");
include("pages_structure.php");

include("include/page_init.php");

if(file_exists("../template_users_admin.htm"))
{
	$TEMPLATE_HTML = file_get_contents("../template_users_admin.htm");
}
else
if(file_exists("../template_admin.html"))
{
	$TEMPLATE_HTML = file_get_contents("../template_admin.html");
}
if($category=="home")										
{
	$TEMPLATE_HTML = str_replace("<wsa languages_menu/>",GenerateLanguagesMenu_BLOGSADMIN($category,$action),$TEMPLATE_HTML);
}

include("../extensions/time.php");
$TEMPLATE_HTML = str_replace("<wsa time/>",$HTML,$TEMPLATE_HTML);
include("menus/top_right.php");
$TEMPLATE_HTML = str_replace("<wsa logins/>",$HTML,$TEMPLATE_HTML);
include("menus/main.php");
$TEMPLATE_HTML = str_replace("<wsa menu/>",$strAZMenu.$strOutput,$TEMPLATE_HTML);
include("menus/admin_bottom.php");
$TEMPLATE_HTML = str_replace("<wsa bottom_menu/>",$HTML,$TEMPLATE_HTML);
$TEMPLATE_HTML = str_replace("images/","../images/",$TEMPLATE_HTML);
$TEMPLATE_HTML = str_replace("<wsa title/>",$ProductName,$TEMPLATE_HTML);
$TEMPLATE_HTML=str_replace
(
"</head>",
"<style>
body,div,td,span{font-family:".aParameter(61).";font-size:".aParameter(62).";color:".aParameter(63)."}
a:link{color:".aParameter(64)."}
a:visited{color:".aParameter(65)."}
a:hover{color:".aParameter(66)."}
h1,h2,h3,h4,h5,h6{color:".aParameter(67)."}
</style><script>var menu_type=\"".(aParameter(2)=="custom"?"custom":"standard")."\";</script><script src=\"include/ContextMenu.js\"></script></head>",
$TEMPLATE_HTML
);
$HTML="";
include("include/help_tips.php");

ob_start();
echo "<br>";	
 include("menus/navigation.php");	
	

ms_w($category);
if(isset($folder))
{
	ms_w($folder);
	ms_w($page);
	if(file_exists($category."/".$folder."_".$page.".php"))
	{
		include($category."/".$folder."_".$page.".php");
	}
	else
	{
		die("");
	}
}
else
{
	ms_w($action); 
	if(file_exists($category."/".$action.".php"))
	{
		include($category."/".$action.".php");
	}
	else
	{
		die("");
	}
}
if($HTML=="")
{
	$HTML = ob_get_contents();
}

ob_end_clean();

$TEMPLATE_HTML = str_replace("<wsa content/>",$HTML,$TEMPLATE_HTML);
//echo $TEMPLATE_HTML;

SQLUpdate_SingleValue("admin_users","username","'".$AuthUserName."'","last_action",time());

?>