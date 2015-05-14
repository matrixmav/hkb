<?php
if($USE_SECURITY_IMAGES) session_start();

$isDefaultPage = false;
if(!isset($page)||$page=="index")
{
	if($WEBSITE_MULTILANGUAGE&&isset($mod))
	{
		$st = SQLArray("SELECT lang FROM ".$DBprefix."statistics WHERE host='".$_SERVER["REMOTE_ADDR"]."' ORDER BY id DESC LIMIT 0,1");
		
		if(isset($st)&&isset($st["lang"])&&$st["lang"]!="")
		{
			$languageCode = $st["lang"];
		}
		else
		{
			$languageCode = strtolower(getSingleValue("languages","default_language","1","code"));
		}
	}
	else
	if(!isset($lang)||trim($lang)=="")
	{
		$languageCode = strtolower(getSingleValue("languages","default_language","1","code"));
	}
	else
	{
		$languageCode = strtolower($lang);
	}
	
	if(trim($languageCode)=="") $languageCode="en";
	
	if(!isset($page_id))
	{
		$page_id = aParameter(1);
	}
	else
	{
		ms_i($page_id);
	}

	$defaultPage = DataArray("pages","id=$page_id");
	$page = urlencode($languageCode."_".$defaultPage["link_".$languageCode]);
	$LANG = $lang = $languageCode;
	$isDefaultPage = true;
	
}
else
{
	if(!$WEBSITE_MULTILANGUAGE)
	{
		$arrLng=DataArray("languages","default_language=1");
		$lang=strtolower($arrLng["code"]);
		$LANG=strtoupper($arrLng["code"]);
	}
	else
	{
		list($lang,$name)=explode("_",$page,2);
		$LANG=strtoupper($lang);
	}
}

$proceedMainFlag = true;

if(function_exists("date_default_timezone_set")) date_default_timezone_set($DEFAULT_TIME_ZONE);


?>