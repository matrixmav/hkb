<?php
function get_string_between($string, $start, $end)
{
	$string = " ".$string;
	$ini = strpos($string,$start);
	if ($ini == 0) return "";
	$ini += strlen($start);
	$len = strpos($string,$end,$ini) - $ini;
	return substr($string,$ini,$len);
}

function ms_w($input)
{
	if(!preg_match("/^[a-zA-Z0-9_]+$/i", $input)) die("");
}


function ReturnErrorURL($strPage, $strError)
{
	$strLast3 = substr($strPage, strlen($strPage)-3, 3);
		
	if($strLast3 == "php")
	{
		return $strPage."?e=".$strError;
	}
	else
	{
		if(get_param("login_error") != "")
		{
			return $strPage;
		}
		else
		{
			return $strPage."&e=".$strError;
		}
	}
	
}


function current_page_name() 
{
 return substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
}

function current_url() 
{
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}


function ms_ew($input)
{
	if(!preg_match("/^[a-zA-Z0-9_\-. @]+$/i", $input)) die("");
}
function ms_i($input)
{
	if(!is_numeric($input)) die("");
}

function ms_ia($input)
{
	foreach($input as $inp) if(!is_numeric($inp)) die("");
}

function SQLMaxPlus(
				
				$strTable,
				$strField,
				$strAuth
			){

	$strResult="";
	
	global $DBHost,$DBUser,$DBPass,$DBName,$DBprefix,$AuthUserName;

	mysql_connect($DBHost,$DBUser,$DBPass);
	mysql_select_db($DBName);

	if($strAuth != "")
	{
		$strQuery="SELECT max($strField) abc FROM ".$DBprefix."$strTable WHERE $strAuth ";
	}
	else
	{
		$strQuery="SELECT max($strField) abc FROM ".$DBprefix."$strTable";
	}
	
	$oResult=mysql_query($strQuery) or RegisterError("SQL_ERROR",$strQuery."<br>".mysql_error());

	$arrResult=mysql_fetch_array($oResult);
	
	$strResult=$arrResult["abc"];
	
	mysql_close();

	return round($strResult,2);
}
function text_words($string, $wordsreturned)
{
      $retval = $string;    
	$array = explode(" ", $string);
  
       if (count($array)<=$wordsreturned)
	{
		$retval = $string;
	}
	else
	{
		array_splice($array, $wordsreturned);
		$retval = implode(" ", $array)." ...";
	}
		return $retval;
 }


	  
class Node{var $name = "";var $nodes = array();}

function FormatSpace($iSpace){if($iSpace < 1024){return $iSpace."KB";}else{return round($iSpace/1024,2)."MB";}}

function CreateLink3($user, $strLink){global $BLOG_DOMAIN,$BLOG_URL_FORMAT;if($BLOG_URL_FORMAT == 1){return "http://".$user.".".$BLOG_DOMAIN."/".$strLink;}else{if($strLink == "contact"){return "http://www.".$BLOG_DOMAIN."/site.php?user=".$user."&contact=1";}else{$arrLinkItems = explode("/",$strLink);if(sizeof($arrLinkItems) == 2){return "http://www.".$BLOG_DOMAIN."/site.php?user=".$user."&".$arrLinkItems[0]."=".$arrLinkItems[1];}else if(sizeof($arrLinkItems) == 4){return "http://www.".$BLOG_DOMAIN."/site.php?user=".$user."&".$arrLinkItems[0]."=".$arrLinkItems[1]."&".$arrLinkItems[2]."=".$arrLinkItems[3];}}}}

function getSePage($strTitle)
{$strSEPage = "";
$strTitle=strtolower(trim($strTitle));
$arrSigns = array("~", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "+", "-", ",",".","/", "?", ":","<",">","[","]","{","}","|");
$strTitle = str_replace($arrSigns, "", $strTitle);
$arrWords = explode(" ",$strTitle);
$iWCounter = 1;
foreach($arrWords as $strWord)
{if($strWord == ""){continue;}
if($iWCounter == 7){break;}
if($iWCounter != 1){$strSEPage .= "-";}$strSEPage .= $strWord;$iWCounter++;
}if($strSEPage != ""){$strSEPage .= ".html";}return $strSEPage;
}

function CreateLink4($user, $strLink, $strTitle){global $BLOG_DOMAIN,$BLOG_URL_FORMAT;
if($BLOG_URL_FORMAT == 1)
{$strSEPage=getSePage($strTitle);
return "http://".$user.".".$BLOG_DOMAIN."/".$strLink."/".$strSEPage;
}else
{if($strLink == "contact")
{return "http://www.".$BLOG_DOMAIN."/site.php?user=".$user."&contact=1";}
else{$arrLinkItems = explode("/",$strLink);
if(sizeof($arrLinkItems) == 2)
{if($arrLinkItems[0]=="note")
{$strSEPage=getSePage($strTitle);
return "http://www.".$BLOG_DOMAIN."/".$user."/".$strLink."/".$strSEPage;
}else
{return "http://www.".$BLOG_DOMAIN."/site.php?user=".$user."&".$arrLinkItems[0]."=".$arrLinkItems[1];
}}else if(sizeof($arrLinkItems) == 4){return "http://www.".$BLOG_DOMAIN."/site.php?user=".$user."&".$arrLinkItems[0]."=".$arrLinkItems[1]."&".$arrLinkItems[2]."=".$arrLinkItems[3];}}}}

function BlogUrl($user){global $USE_ABSOLUTE_URLS,$BLOG_URL_FORMAT,$BLOG_DOMAIN;if(!$USE_ABSOLUTE_URLS){return "site.php?user=".strtolower($user);}else if($BLOG_URL_FORMAT == 1){return "http://".strtolower($user).".".$BLOG_DOMAIN;}else if($BLOG_URL_FORMAT == 2){return "http://"."www.".$BLOG_DOMAIN."/".strtolower($user);}else{return "[blog format not defined]";}}

function dcr2utf8($src){ $dest = ''; if($src < 0){ return false; }else if($src <= 0x007f){ $dest .= chr($src); }else if($src <= 0x07ff){ $dest .= chr(0xc0 | ($src >> 6)); $dest .= chr(0x80 | ($src & 0x003f)); }else if($src == 0xFEFF){ }else if ($src >= 0xD800 && $src <= 0xDFFF){ return false; }else if($src <= 0xffff){ $dest .= chr(0xe0 | ($src >> 12)); $dest .= chr(0x80 | (($src >> 6) & 0x003f)); $dest .= chr(0x80 | ($src & 0x003f)); }else if($src <= 0x10ffff){ $dest .= chr(0xf0 | ($src >> 18)); $dest .= chr(0x80 | (($src >> 12) & 0x3f)); $dest .= chr(0x80 | (($src >> 6) & 0x3f)); $dest .= chr(0x80 | ($src & 0x3f)); }else{ return false; } return $dest;}

function string2utf8($string){ $string = preg_replace_callback('/&#([0-9]+);/',create_function('$s','return dcr2utf8($s[1]);'),$string); return preg_replace_callback('/&#x([a-f0-9]+);/i',create_function('$s','return dcr2utf8(hexdec($s[1]));'),$string);}while (list($key, $val) = @each($_GET)) $GLOBALS[$key] = $val;while (list($key, $val) = @each($_POST)) $GLOBALS[$key] = $val;while (list($key, $val) = @each($_FILES)) $GLOBALS[$key] = $val;


function v($param_name){ global $_POST; global $_GET; $param_value = "NULL"; if(isset($_POST[$param_name])) { $param_value = $_POST[$param_name]; } else if(isset($_GET[$param_name])) { $param_value = $_GET[$param_name]; } return $param_value;}

function str_escape($value)
{
    $search = array("\x00", "\\", "'", "\"", "\x1a");
    $replace = array("\\x00", "\\\\" ,"\'", "\\\"", "\\\x1a");

    return str_replace($search, $replace, $value);
}


function get_param($param_name){ global $_POST; global $_GET; $param_value = ""; if(isset($_POST[$param_name])) $param_value = $_POST[$param_name]; else if(isset($_GET[$param_name])) $param_value = $_GET[$param_name]; return str_escape(stripslashes($param_value));}

function strip($value){ if(get_magic_quotes_gpc() == 0) return $value; else return stripslashes($value);}

function get_session($param_name){ global $_POST; global $_GET; global ${$param_name}; $param_value = ""; if(!isset($_POST[$param_name]) && !isset($_GET[$param_name]) && session_is_registered($param_name)) $param_value = ${$param_name}; return $param_value;}

function set_session($param_name, $param_value){ global ${$param_name}; if(session_is_registered($param_name)) session_unregister($param_name); ${$param_name} = $param_value; session_register($param_name);}

function GenerateLink($urlFormat,$urlLanguage,$lang,$page)
{
	global $BLOG_DOMAIN,$USE_ABSOLUTE_URLS,$WEBSITE_MULTILANGUAGE;
	
	$result = "";
	
	if($USE_ABSOLUTE_URLS) 
		$result .= "http://www.".$BLOG_DOMAIN."/";
	else
		$result .= "index.php?page=";
	
	$result .= urlencode( ($WEBSITE_MULTILANGUAGE?$lang."_":"") .stripslashes($page));
	
	if($USE_ABSOLUTE_URLS) 
		$result .= ".html";
	
	return $result;
	
	/*
	global $FRONT_SITE_PAGES_DHTML,$BLOG_DOMAIN,$USE_ABSOLUTE_URLS; 



	if($urlFormat == "1")
	{

	if($urlLanguage == "YES")
	{
		return (($USE_ABSOLUTE_URLS?"http://www.".$BLOG_DOMAIN."/":"").($FRONT_SITE_PAGES_DHTML?"page":"index").".php?page=".urlencode($lang."_".stripslashes($page)));
	}

	else{return ("http://www.".$BLOG_DOMAIN."/index.php?page=".urlencode(stripslashes($page)));}}else

	 if($urlFormat == "2"){return "error";if($urlLanguage == "YES"){}else{}}else if($urlFormat == "3"){if($urlLanguage == "YES"){return ("http://www.".$BLOG_DOMAIN."/".urlencode($lang."_".stripslashes($page))).".html";}else{return ("http://www.".$BLOG_DOMAIN."/".urlencode(stripslashes($page))).".html";}}else if($urlFormat == "4"){if($urlLanguage == "YES"){return ("http://www.".$BLOG_DOMAIN."/".urlencode($lang."_".stripslashes($page)))."";}else{return ("http://www.".$BLOG_DOMAIN."/".urlencode(stripslashes($page)))."";}}
	*/ 
 }
 
function GenerateLink3($urlFormat,$urlLanguage,$lang,$page){if($urlFormat == "1"){if($urlLanguage == "YES"){return ("../index.php?page=".urlencode($lang."_".stripslashes($page)));}else{return ("../index.php?page=".urlencode(stripslashes($page)));}}else if($urlFormat == "2"){return "error";if($urlLanguage == "YES"){}else{}}else if($urlFormat == "3"){if($urlLanguage == "YES"){return ("../".urlencode($lang."_".stripslashes($page))).".html";}else{return ("../".urlencode(stripslashes($page))).".html";}}else if($urlFormat == "4"){if($urlLanguage == "YES"){return ("../".urlencode($lang."_".stripslashes($page)))."";}else{return ("../".urlencode(stripslashes($page)))."";}}}
 
function GetDefaultPage(){$arrPage=DataArray("pages","id=".Parameter(1));$arrLanguage=DataArray("languages","default_language=1");$lang = strtolower($arrLanguage["code"]);return urlencode($lang."_".$arrPage["link_".$lang]);}

function GenerateUILanguagesMenu($page_id){global $lang;$strResult="";$tableLanguages=DataTable("languages","WHERE active=1");$bFirst=true;

while($arrLanguages=mysql_fetch_array($tableLanguages))
{if(aParameter(3)=="standart")
{$strResult.="\n<a href=\"index.php?lang=".$arrLanguages["code"].($page_id!=""?"&page_id=".$page_id:"")."\"><img  width=\"22\" height=\"14\" class=\"language-flag\" src=\"include/flags/".$arrLanguages["code"].".gif\"/></a>";}
else{$strResult.="\n<a href=\"index.php?ProceedChangeLanguage=".$arrLanguages["code"].($page_id!=""?"&page_id=".$page_id:"")."\">";$arrCustomLink=explode("_",$arrLanguages["html"],2);if(aParameter(5)=="FALSE"&&strtolower(trim($arrLanguages["code"]))==$lang){}else{if($arrCustomLink[0]=="image"){if(!$bFirst){if(aParameter(6)=="TRUE"){$strResult.="<img src=\"language_buttons/separator.gif\" border=0>";}}$strResult.=" <img border=0 src=\"language_buttons/".$arrCustomLink[1]."\">";}else{$strResult.="".$arrCustomLink[1]."";}$bFirst=false;}$strResult.="</a>";}}return $strResult;}

function GenerateCustomMenu()
{
	global $lang,$FRONT_SITE_PAGES_DHTML,$page;$strResult="";
	$arrFirstLine=DataTable("pages","WHERE id>0 AND parent_id=0 AND active_".$lang."=1 order by id");
	if(aParameter(334) == "TRUE"){

	$strLinkTemplate = stripslashes(aParameter(333));

	if($FRONT_SITE_PAGES_DHTML)
	{
		$strLinkTemplate = str_replace("<a ","<a onmousedown=\"ShowLoading()\" target=\"load_iframe\"",$strLinkTemplate);
	}

	while($oArray=mysql_fetch_array($arrFirstLine))
	{
		$strLinkTemplate2=$strLinkTemplate;
		$strLinkTemplate2=str_replace("rplc","onmouseover=\"javascript:zon(this,0,'hon','hoff','z".$oArray["id"]."',z_BOTTOM);\"",$strLinkTemplate2);
		$strResult .= str_replace("[LINK_TEXT]",stripslashes($oArray['link_'.$lang]),str_replace("[LINK_HREF]",GenerateLink(aParameter(1111),aParameter(1112),$lang,stripslashes($oArray['link_'.$lang])),$strLinkTemplate2));
	}
	return $strResult;
	}
}

function checkForSpecialSymbols($strInput){$arrSpecialChars=array("`","~","!","@","#","$","%","^","&","*","(",")",";","+",":","<",">","?","|");foreach($arrSpecialChars as $strChar){if(strpos($strInput,$strChar)){return false;}}return true;}

function Combobox_String($strNames,$strComboName,$cSeparator){global $SelectedValue;echo "<select name=\"".$strComboName."\" >";$arrNames=explode($cSeparator,$strNames);for($i=0;$i<sizeof($arrNames);$i++){echo "<option ".((isset($SelectedValue)&&$SelectedValue==$arrNames[$i])?"selected":"").">".$arrNames[$i]."</option>";}echo "</select>";}function generateJSValidationFunction($strFunctionName,$arrValidation){echo "<script>function $strFunctionName(formObject){";foreach($arrValidation as $oArr){if($oArr[1]=="empty"){echo "if(formObject.".$oArr[0].".value==\"\"){";echo 'HT("2","'.$oArr[2].'<br>",800,200,0.5,20);';echo "formObject.".$oArr[0].".focus();return false;}\n";}}echo "return true;}</script>";}

function SelectAllButton(){echo '<table summary="" border="0" width=950><tr><td class=basictext align=right><input type=button id=SelectAllButton onclick="javascript:SelectAllCheckBoxes()" value=" Select All " class=adminButton></td></tr></table>';}

function HtmlComboBox_Query($strQuery,$strValueField,$strNameField){$cValue=get_param($strValueField);$oTable=DataTable_Query($strQuery);$iResult=mysql_num_rows($oTable);echo "<select name=\"$strValueField\">";while($oRow=mysql_fetch_array($oTable)){echo "<option value=\"".$oRow[$strValueField]."\" ".($oRow[$strValueField]==$cValue?"selected":"").">".$oRow[$strNameField]."</option>";}echo "</select>";return $iResult;}

function HtmlComboBox($strTable,$strValueField,$strNameField){global $ComboName;$cValue=get_param($strValueField);$oTable=DataTable($strTable,"");echo "<select name=\"".(isset($ComboName)?$ComboName:$strValueField)."\">";while($oRow=mysql_fetch_array($oTable)){echo "<option value=\"".$oRow[$strValueField]."\" ".($oRow[$strValueField]==$cValue?"selected":"").">".$oRow[$strNameField]."</option>";}echo "</select>";}


function getValuesFromSerializedArray($strSerializedArray){$arrResult=Array();foreach(unserialize($strSerializedArray) as $oItem){if($oItem[1]==1){array_push($arrResult,$oItem[0]);}}return $arrResult;}


function SetParameter($ParameterId,$ParameterValue){SQLUpdate_SingleValue("settings","id",$ParameterId,"value",$ParameterValue);}

function getSingleValue($strTable,$PrimaryKey,$PrimaryKeyValue,$FieldName){$strResult="";global $DBHost,$DBUser,$DBPass,$DBName,$DBprefix;mysql_connect($DBHost,$DBUser,$DBPass);mysql_select_db($DBName);$strQuery="SELECT $FieldName FROM $DBprefix".$strTable." WHERE $PrimaryKey=$PrimaryKeyValue";$oResult=mysql_query($strQuery) or RegisterError("SQL_ERROR",$strQuery."<br>".mysql_error());$aResult=mysql_fetch_array($oResult);$strResult=$aResult[$FieldName];mysql_close();return $strResult;}

function SQLUpdate_SingleValue($strTable,$PrimaryKey,$PrimaryKeyValue,$FieldName,$FieldValue){global $DBHost,$DBUser,$DBPass,$DBName,$DBprefix;mysql_connect($DBHost,$DBUser,$DBPass);mysql_select_db($DBName);$strQuery="UPDATE $DBprefix".$strTable." SET $FieldName='".addslashes($FieldValue)."' WHERE $PrimaryKey=$PrimaryKeyValue";$iResult=mysql_query($strQuery) or RegisterError("SQL_ERROR",$strQuery."<br>".mysql_error());mysql_close();return $iResult;}

function DataTable_Query($strQuery){global $DBHost,$DBUser,$DBPass,$DBName,$DBprefix;mysql_connect("$DBHost", "$DBUser", "$DBPass");mysql_select_db($DBName);$oDataTable=mysql_query($strQuery) or RegisterError("SQL_ERROR",$strQuery."<br>".mysql_error());mysql_close();return $oDataTable;}

function DataTable_Query_OC($strQuery){global $DBprefix;$oDataTable=mysql_query($strQuery) or RegisterError("SQL_ERROR",$strQuery."<br>".mysql_error());return $oDataTable;}

function SQLMax($strTable,$strField){$strResult="";global $DBHost,$DBUser,$DBPass,$DBName,$DBprefix;mysql_connect($DBHost,$DBUser,$DBPass);mysql_select_db($DBName);$strQuery="SELECT max($strField) abc FROM ".$DBprefix."$strTable";$oResult=mysql_query($strQuery) or RegisterError("SQL_ERROR",$strQuery."<br>".mysql_error());$arrResult=mysql_fetch_array($oResult);$strResult=$arrResult["abc"];mysql_close();return round($strResult,2);}

function SQLMin($strTable,$strField){$strResult="";global $DBHost,$DBUser,$DBPass,$DBName,$DBprefix;mysql_connect($DBHost,$DBUser,$DBPass);mysql_select_db($DBName);$strQuery="SELECT min($strField) abc FROM ".$DBprefix."$strTable";$oResult=mysql_query($strQuery) or RegisterError("SQL_ERROR",$strQuery."<br>".mysql_error());$arrResult=mysql_fetch_array($oResult);$strResult=$arrResult["abc"];mysql_close();return round($strResult,2);}

function SQLSum($strTable,$strField){$strResult="";global $DBHost,$DBUser,$DBPass,$DBName,$DBprefix;mysql_connect($DBHost,$DBUser,$DBPass);mysql_select_db($DBName);$strQuery="SELECT sum($strField) abc FROM ".$DBprefix."$strTable";$oResult=mysql_query($strQuery) or RegisterError("SQL_ERROR",$strQuery."<br>".mysql_error());$arrResult=mysql_fetch_array($oResult);$strResult=$arrResult["abc"];mysql_close();return round($strResult,2);}


function SQLCount_Query($strQuery){$iResult=0;global $DBHost,$DBUser,$DBPass,$DBName,$DBprefix;mysql_connect($DBHost,$DBUser,$DBPass);mysql_select_db($DBName);$oResult=mysql_query($strQuery) or RegisterError("SQL_ERROR",$strQuery."<br>".mysql_error());$iResult=mysql_num_rows($oResult);mysql_close();return $iResult;}

function aMessage($x){global $arrSiteMessages;return $arrSiteMessages[$x];}

function aParameter($x){global $arrParams;return stripslashes($arrParams[$x]);}


function EnsureParams(){global $arrParams;$arrParams=LoadParams();}

function LoadParams(){global $DBHost,$DBUser,$DBPass,$DBName,$DBprefix;$arrResult=array();mysql_connect($DBHost,$DBUser,$DBPass);if (mysql_errno() == 1203 || mysql_errno() == 2002) { header("Location: include/busy.html"); exit;}mysql_select_db($DBName);$strQuery="select id,value from ".$DBprefix."settings";$oDataTable=mysql_query($strQuery) or RegisterError("SQL_ERROR",$strQuery."<br>".mysql_error());while($oRow=mysql_fetch_array($oDataTable)){$arrResult[$oRow["id"]]=$oRow["value"];}mysql_close();return $arrResult;}

function sqlValueMD5($strMD5,$strTable,$strField1,$strField2,$strSql){$oTable=DataTable($strTable,$strSql);while($oRow=mysql_fetch_array($oTable)){if(md5($oRow[$strField1]."~".$oRow[$strField2])==$strMD5){return $oRow[$strField1]."~".$oRow[$strField2];}}return "no";}

function SQLUpdateField_MultipleArray($strTable,$strName,$strValue,$strIdName,$arrIds){if(sizeof($arrIds)==0){return;}$strIds="";for($i=0;$i<sizeof($arrIds);$i++){if($i==(sizeof($arrIds)-1)){$strIds.="".$arrIds[$i];}else{$strIds.="".$arrIds[$i].",";}}global $DBHost,$DBUser,$DBPass,$DBName,$DBprefix;mysql_connect("$DBHost", "$DBUser", "$DBPass");mysql_select_db($DBName);$strQuery="UPDATE $DBprefix".$strTable." SET $strName='".addslashes($strValue)."' WHERE $strIdName IN ($strIds)";mysql_query($strQuery) or RegisterError("SQL_ERROR",$strQuery."<br>".mysql_error());mysql_close();}

function renderCompositeTable($strQuery,$barFields,$barNames,$barCheckBoxes,$PrimaryField,$arrTypes,$arrTitles,$arraysFields,$arraysNames){global $DBHost,$DBUser,$DBPass,$DBName,$DBprefix;global $action,$category,$ProceedCompositeTable,$Approve,$Reject,$Delivered;echo "<script>function GeneratePDF(x){var oHTML=eval('document.all.OutputHTML'+x);document.all.html.value=oHTML.value;document.all.PDF_FORM.submit();}</script>";if(isset($ProceedCompositeTable)){if(sizeof($Delivered)>0){SQLUpdateField_MultipleArray("orders","status","delivered","OrderNumber",$Delivered);}if(sizeof($Approve)>0){SQLUpdateField_MultipleArray("orders","validator",$AuthUserName,"OrderNumber",$Approve);SQLUpdateField_MultipleArray("orders","status","approved","OrderNumber",$Approve);}if(sizeof($Reject)>0){SQLUpdateField_MultipleArray("orders","validator",$AuthUserName,"OrderNumber",$Approve);SQLUpdateField_MultipleArray("orders","status","rejected","OrderNumber",$Reject);}echo "<table width=950><tr><td class=basictext align=center>";echo "<b>The changes are saved successfully!</b>";echo "</td></tr></table>";}mysql_connect($DBHost,$DBUser,$DBPass);mysql_select_db($DBName);$oDataTable=mysql_query($strQuery) or RegisterError("SQL_ERROR",$strQuery."<br>".mysql_error());echo "<form action=index.php method=post>";echo "<input type=hidden name=action value=$action>";echo "<input type=hidden name=category value=$category>";echo "<input type=hidden name=ProceedCompositeTable value=\"\">";echo "<table celpading=2 cellspacing=0 width=950 style='border-color:#cecfce;border-width:1px 1px 1px 1px;border-style:solid'>";$iRowsCounter=0;while($oRow=mysql_fetch_array($oDataTable)){$strOutputHTML="";$iRowsCounter++;echo "<tr bgcolor=#cecfce height=20 nowrap>";echo "<td class=oHeader >&nbsp;<b>";for($q=0;$q<sizeof($barFields);$q++){echo $barNames[$q].": ".$oRow[$barFields[$q]];echo "&nbsp;&nbsp;";$strOutputHTML.="<b>".$barNames[$q].": ".$oRow[$barFields[$q]]."</b><br><br>";}echo "</b></td>";echo "<td class=oHeader align=right>&nbsp;<b>";for($q=0;$q<sizeof($barCheckBoxes);$q++){echo "<input type=checkbox name=\"".$barCheckBoxes[$q]."[]\" value=\"".$oRow[$PrimaryField]."\">".$barCheckBoxes[$q]."";echo "&nbsp;&nbsp;";}echo '<a href="javascript:GeneratePDF('.$iRowsCounter.')"><img src="images/pdf.gif" border="0" width="16" height="16" alt=""></a>';echo "</b></td>";echo "</tr>";echo "<tr>";echo "<td colspan=2 align=center class=basictext bgcolor=".($iRowsCounter%2==0?"#e7dfef":"#ffffff").">";for($i=0;$i<sizeof($arrTitles);$i++){if($arrTypes[$i]=="fieldset"||$arrTypes[$i]=="sql"){echo "<table width=700><tr><td class=basictext>";echo "<fieldset><legend><b><span class=basictext onclick=\"div".$iRowsCounter."".$i.".style.display='block'\">".$arrTitles[$i]."</span></b></legend> <div id=\"div".$iRowsCounter."".$i."\" onclick=\"this.style.display='none'\">";if($arrTypes[$i]=="fieldset"){$arrFields=$arraysFields[$i];$arrNames=$arraysNames[$i];echo "<table width=100%>";echo "<tr>";for($j=0;$j<sizeof($arrFields);$j++){if($arrFields[$j]!=""){echo "<td valign=top width=".(680/sizeof($arrFields))." align=left class=basictext >";echo $arrNames[$j].": ".$oRow[$arrFields[$j]]."";echo "</td>";$strOutputHTML.=$arrNames[$j].": ".$oRow[$arrFields[$j]]."<br>";}}echo "</tr>";echo "</table>";}else if($arrTypes[$i]=="sql"){$strSubQuery=$arraysFields[$i];ereg( "@@@([A-Za-z]+)@@@", $strSubQuery, $regs );$strSubQuery=str_replace("@@@".$regs[1]."@@@",$oRow[$regs[1]],$strSubQuery);$arrSubRow=mysql_query($strSubQuery);echo "<table width=100% cellspacing=0>";$iSubRowsCounter=0;$strBGColor="";while($oSubRow=mysql_fetch_array($arrSubRow)){$iSubRowsCounter++;if($iRowsCounter%2==1){if($iSubRowsCounter%2==0){$strBGColor="#ffffff";}else{$strBGColor="#fff7ef";}}else{if($iSubRowsCounter%2==0){$strBGColor="#e7dfef";}else{$strBGColor="#ecdfef";}}echo "<tr bgcolor=$strBGColor height=20>";foreach($arraysNames[$i] as $strSubName){echo "<td class=basictext>";echo $oSubRow[$strSubName];echo "</td>";$strOutputHTML.=$oSubRow[$strSubName]."<br>";}echo "</tr>";}echo "</table>";}echo "</div></fieldset>";echo "</td></tr></table>";}}echo "</td>";echo "</tr>";echo "<input type=hidden id=OutputHTML".$iRowsCounter." name=OutputHTML".$iRowsCounter." value=\"$strOutputHTML\">";}echo "</table>";if(sizeof($barCheckBoxes)>0){echo "<br><table width=950><tr><td align=right>";echo "<input type=submit value=\" Submit \" class=adminButton>";echo "</td></tr></table>";}echo "</form>";echo "<form id=PDF_FORM target=_blank action=pdf/generate.php method=post><input type=hidden id=html name=html value=''></form>";mysql_close();}

function SQLImportFile($strInputFile,$strTable,$strFields,$strColumnsDelimiter){global $DBHost,$DBUser,$DBPass,$DBName,$DBprefix;$UserFile = addslashes (fread (fopen ($_FILES[$strInputFile]["tmp_name"], "r"), filesize ($_FILES[$strInputFile]["tmp_name"])));$file_name = $_FILES[$strInputFile]["name"];$file_size = $_FILES[$strInputFile]["size"];$file_type = $_FILES[$strInputFile]["type"];$iResult=0;if($file_size>0){$arrLines=explode("\n",$UserFile);mysql_connect($DBHost,$DBUser,$DBPass);mysql_select_db($DBName);foreach($arrLines as $strLine){$strLine=str_replace("'","\'",$strLine);$strLine=str_replace($strColumnsDelimiter,"','",$strLine);$sql="INSERT INTO ".$DBprefix."".$strTable."($strFields) VALUES('$strLine')";mysql_query($sql) or RegisterError("SQL_ERROR",$sql."<br>".mysql_error());}mysql_close();}echo "<b>The file was imported successfully!</b>";}

function ExportForm($strTable,$strSql,$arrFileTypes,$strDisplayMessage){global $category,$action,$doExport;global $FileType;if(true){echo "<table width=950>";echo "<tr>";echo "<td class=basicText>";echo "<form action=\"index.php\" method=post>";echo "<b>$strDisplayMessage</b><br><br>";echo "Please select the file type to export: ";$firstKeyFlag=true;foreach($arrFileTypes as $strFileType){echo "<input type=radio ".($firstKeyFlag?"checked":"")." name=FileType value=\"$strFileType\">$strFileType &nbsp;";$firstKeyFlag=false;}echo "<br><br>Please select the file name to export: ";echo "<input type=text name=FileName value=\"\" size=30>";echo "<input type=hidden name=category value=\"$category\">";echo "<input type=hidden name=action value=\"$action\">";echo "<input type=hidden name=strTable value=\"$strTable\">";echo "<input type=hidden name=strSql value=\"$strSql\">";echo "<input type=hidden name=doExport value=''>";echo "<br><br><input type=submit value=\"Export\" class=adminButton>";echo "</form>";echo "</td>";echo "</tr>";echo "</table>";}}

function ExportTable($strTable,$sqlClause,$strFileType,$strFileName){global $DBHost,$DBUser,$DBPass,$DBName,$DBprefix;if($strFileName==""){$strFileName="data";}header("Content-type: application/octet-stream");header("Content-Disposition: attachment; filename=".$strFileName.".".strtolower($strFileType));global $DBHost,$DBUser,$DBPass,$DBName,$DBprefix;mysql_connect($DBHost,$DBUser,$DBPass);mysql_select_db($DBName);if($strTable!=""){$strQuery="select * from $DBprefix".$strTable." $sqlClause";}else{$strQuery=$sqlClause;}$oDataTable=mysql_query($strQuery) or RegisterError("SQL_ERROR",$strQuery."<br>".mysql_error());$strGlue="";if(strtolower($strFileType)=="txt"){$strGlue="|";}else if(strtolower($strFileType)=="tdf"){$strGlue="\t";}else if(strtolower($strFileType)=="csv"){$strGlue="\",\"";}else if(strtolower($strFileType)=="xls"){$strGlue="\",\"";}while($oRow=mysql_fetch_array($oDataTable)){$arrRow=array(sizeof($oRow)/2);for($i=0;$i<sizeof($oRow)/2;$i++){$arrRow[$i]=$oRow[$i];}$strToWrite=implode($strGlue, $arrRow);if(strtolower($strFileType)=="csv"||strtolower($strFileType)=="xls"){$strToWrite="\"".$strToWrite."\"";}print $strToWrite."\n";}mysql_close();return $oDataTable;}

function ArrayTableFields($strTableName,$strType){ global $DBHost,$DBUser,$DBPass,$DBName,$DBprefix; $arrResult=array(); mysql_connect($DBHost,$DBUser,$DBPass); mysql_select_db($DBName); $result = mysql_query("SELECT * FROM ".$DBprefix."".$strTableName." LIMIT 0,1") or RegisterError("SQL",mysql_error()); $fields = mysql_num_fields($result); $rows = mysql_num_rows($result); $i = 0; $table = mysql_field_table($result, $i); while ($i < $fields) { $type = mysql_field_type($result, $i); $name = mysql_field_name($result, $i); $len = mysql_field_len($result, $i); $flags = mysql_field_flags($result, $i);if($strType=="PrimaryKey"){if(strstr($flags,"primary_key")){array_push($arrResult,$name);}}else if($strType=="NamesNoKey"){if(!strstr($flags,"primary_key")){array_push($arrResult,$name);}}else if($strType=="TypesNoKey"){if(!strstr($flags,"primary_key")){array_push($arrResult,$type);}}else if($strType=="Type"){array_push($arrResult,$type);}else if($strType=="Name"){array_push($arrResult,$name);}else if($strType=="Length"){array_push($arrResult,$len);}else if($strType=="Flags"){array_push($arrResult,$flags);} $i++; } mysql_close(); return $arrResult;}
function GetFieldsInTable($strTable){

	
	global $DBHost,$DBUser,$DBPass,$DBName,$DBprefix;

	mysql_connect($DBHost,$DBUser,$DBPass);
	mysql_select_db($DBName);

	$mysql_fields = array();
	$pieces = explode(",", $strTable);
	$oResult=mysql_query("SHOW COLUMNS FROM ".$DBprefix.$pieces[0]); 
	
	while ($row = mysql_fetch_assoc($oResult)) 
	{
	   array_push($mysql_fields,$row["Field"]);
	}
	
	mysql_close();
	
	return $mysql_fields;
}

function EditParams($strListOfParamIds,$arrTypes,$strSubmitText,$strSuccessMessage){global $EditColumns,$FirstTDAlign,$SelectWidth,$TextboxWidth,$TableWidth;global $DBHost,$DBUser,$DBPass,$DBName,$DBprefix;global $SpecialProcessEditParams,$AuthUserName;global $category,$action,$folder,$page,$firstTDLength;if(!isset($FirstTDAlign)){$FirstTDAlign = "right";}if(isset($SpecialProcessEditParams)){mysql_connect($DBHost,$DBUser,$DBPass);mysql_select_db($DBName);foreach(explode(",",$strListOfParamIds) as $i){$newValue = get_param("val".$i);$sql="UPDATE ".$DBprefix.""."settings SET value='".addslashes($newValue)."' WHERE id=".$i;mysql_query($sql) or RegisterError("SQL_ERROR",$sql."<br>".mysql_error());}mysql_close();echo "<table border=0 width=".(isset($TableWidth)?$TableWidth:"950")."><tr><td class=basicText>$strSuccessMessage</td></tr></table><br>";}if(true){echo "<form action=index.php method=POST>";global $strHiddenFields;if(isset($strHiddenFields)){echo $strHiddenFields;}echo "<input type=hidden name=category value=\"".$category."\" >";echo "<input type=hidden name=SpecialProcessEditParams value=\"\" >";if(isset($action)){echo "<input type=hidden name=action value=\"".$action."\" >";}else{echo "<input type=hidden name=folder value=\"".$folder."\" >";echo "<input type=hidden name=page value=\"".$page."\" >";}echo "<table border=0 width=".(isset($TableWidth)?$TableWidth:"950").">";$oTable=DataTable("settings"," where id in (".$strListOfParamIds.") ORDER BY id");$i=0;while($row=mysql_fetch_array($oTable)){if(isset($EditColumns)){if(($i % $EditColumns) == 0){echo "<tr height=25>";}}else{echo "<tr height=25>";}echo "<td class=basictext width=".(isset($firstTDLength)?$firstTDLength:"150")." align=".$FirstTDAlign." >".(strpos(strtolower($row['description']),"color")?"<a href=\"javascript:ShowColorMenu('val".$row['id']."')\">":"")."".$row['description'].":".(strpos(strtolower($row['description']),"color")?"</a>":"")." </td>";echo "<td class=basictext>";if(strstr($arrTypes[$i],"file")){echo "<input type=file value=\"".$row['value']."\" name=\"val".$row['id']."\" size=30>";}else if(strstr($arrTypes[$i],"textbox")){list($strType,$strSize)=explode("_",$arrTypes[$i]);echo "<input type=text value=\"".$row['value']."\" name=\"val".$row['id']."\" id=\"val".$row['id']."\" size=$strSize ".(isset($TextboxWidth)?"style='width:".$TextboxWidth."'":"").">";}else if(strstr($arrTypes[$i],"textarea")){list($strType,$strCols,$strRows)=explode("_",$arrTypes[$i]);echo "<textarea name=\"val".$row['id']."\" id=\"val".$row['id']."\" cols=$strCols rows=$strRows>".$row['value']."</textarea>";}else if(strstr($arrTypes[$i],"javascript~combobox")){echo "<select name=\"val".$row['id']."\" onChange=javascript:SelectChanged(this)>";foreach(explode("_",$arrTypes[$i]) as $strOption){if($strOption=="javascript~combobox"){continue;}echo "<option>".str_replace("~"," ",$strOption)."</option>";}}else if(strstr($arrTypes[$i],"combobox")){echo "<select name=\"val".$row['id']."\" ".(isset($SelectWidth)?"style='width:".$SelectWidth."'":"").">";foreach(explode("_",$arrTypes[$i]) as $strOption){if($strOption=="combobox"){continue;}echo "<option";if($strOption==$row['value']){echo " selected";}echo">".$strOption."</option>";}echo "</select>";}else{echo "This type is not supported.";}$i++;echo "</td><td width=30>&nbsp;</td>";if(isset($EditColumns)){if(($i % $EditColumns) == 0){echo "</tr>";}}else{echo "</tr>";}}echo "</table><br><table border=0 width=".(isset($TableWidth)?$TableWidth:"950")."><tr><td><input type=submit class=adminButton value=\"".$strSubmitText."\"></td></tr></table></form>";}}

function RegisterError($strErrorType,$strErrorDescription){
//global $SYSTEM_DEBUG_MODE;if($SYSTEM_DEBUG_MODE){echo "<font color=red><b><i>";echo $strErrorType."<br><br>".$strErrorDescription;echo "</i></b></font>";}else{die("<script>document.location.href='index.php?r=1';</script>");}
}

function AddEditForm($arrTexts,$arrEditFields,$arrMissedFields,$arrTypes,$strTableName,$strUniqueKey,$strCurrentUniqueKeyValue,$strSuccessMessage){global $DBHost,$DBUser,$DBPass,$DBName,$DBprefix;global $category,$folder,$page,$action;global $SpecialProcessEditForm,$MessageTDLength,$SubmitButtonText;global $HideSubmit;if(sizeof($arrEditFields)!=sizeof($arrTypes)){echo "Length of Edit Fields array != length of Types array";return -1;}

$strCurrentUniqueKeyValue = str_replace("\'","",$strCurrentUniqueKeyValue);$oArray=DataArray($strTableName,"$strUniqueKey=$strCurrentUniqueKeyValue");if(isset($SpecialProcessEditForm)){$arrValues=array();$arrEditNames=array();for($i=0;$i<sizeof($arrEditFields);$i++){$strName=$arrEditFields[$i];if(in_array($strName,$arrMissedFields)){continue;}if($arrTypes[$i]=="file"){$tempValue = get_param($strName);if($strName == "image_id"){$iFileId=SQLInsertImage($strName);if($iFileId != -2){SQLDelete("image","image_id",array($oArray["image_id"]));


array_push($arrEditNames,$strName);array_push($arrValues,$iFileId);}}else if(trim($tempValue)!=""){array_push($arrEditNames,$strName);SQLDelete("files","file_id",array($oArray["file_id"]));$iFileId=SQLInsertFile($strName);array_push($arrValues,$iFileId);}}else{array_push($arrEditNames,$strName);$tempValue = get_param($strName);$tempValue = str_replace("^","",$tempValue);array_push($arrValues,$tempValue);}}SQLUpdate($strTableName,$arrEditNames,$arrValues,"$strUniqueKey=$strCurrentUniqueKeyValue");echo "<table width=950>";echo "<tr><td class=basictext>";

echo "<b>$strSuccessMessage</b>";echo "</td></tr>";echo "</table>";$oArray=DataArray($strTableName,"$strUniqueKey=$strCurrentUniqueKeyValue");}if(true){echo "<table width=950>";echo "<form action=index.php method=post ENCTYPE=\"multipart/form-data\">";

echo "<input type=hidden name=category value=\"".$category."\">";if(isset($folder)&&isset($page)){echo "<input type=hidden name=folder value=\"".$folder."\">";echo "<input type=hidden name=page value=\"".$page."\">";}else{echo "<input type=hidden name=action value=\"".$action."\">";}echo "<input type=hidden name=$strUniqueKey value=\"".$strCurrentUniqueKeyValue."\">";echo "<input type=hidden name=SpecialProcessEditForm>";global $strSpecialHiddenFieldsToAdd;if(isset($strSpecialHiddenFieldsToAdd)){echo $strSpecialHiddenFieldsToAdd;}for($i=0;$i<sizeof($arrTexts);$i++){echo "<tr height=24>";echo "<td class=basictext valign=middle width=".(isset($MessageTDLength)?$MessageTDLength:"80").">".$arrTexts[$i]."</td>";echo "<td class=basictext valign=middle>";if(in_array($arrEditFields[$i],$arrMissedFields)){echo "".$oArray[$arrEditFields[$i]]."";}else if(strstr($arrTypes[$i],"combobox_table")){list($strType,$strTableName,$strFieldValue,$strFieldName)=explode("~",$arrTypes[$i]);$oTable=DataTable($strTableName,"");echo "<select name=\"".$arrEditFields[$i]."\">";while($oRow=mysql_fetch_array($oTable)){echo "<option ".($oRow[$strFieldValue]==$oArray["type"]?"selected":"")." value=\"".$oRow[$strFieldValue]."\">".$oRow[$strFieldName]."</option>";}echo "</select>";}else if(strstr($arrTypes[$i],"thumbnails")){$strVal="";if(isset($oArray[$arrEditFields[$i]])){$strVal=$oArray[$arrEditFields[$i]];}echo '<br><br><table summary="" border="0" > <tr> <td width=150 valign=top><input type=radio name='.$arrEditFields[$i].' value=1 '.($strVal==1?"checked":"").'>Little (50px)<br><br><img src="images/format/50.jpg" width="50" height="38" alt="" border="0"></td> <td width=150 valign=top><input type=radio name='.$arrEditFields[$i].' value=2 '.($strVal==2?"checked":"").'>Medium (75px)<br><br><img src="images/format/75.jpg" width="75" height="56" alt="" border="0"></td> <td width=150 valign=top><input type=radio name='.$arrEditFields[$i].' value=3 '.($strVal==3?"checked":"").'>Big (115px)<br><br><img src="images/format/115.jpg" width="115" height="86" alt="" border="0"></td> </tr> </table>';}else if(strstr($arrTypes[$i],"file")){

if(isset($oArray["ProductType"]) && $oArray["ProductType"]=="Image"){echo "<a href=show.php?id=".$oArray["file_id"]." target=_blank><img border=0 src=show.php?id=".$oArray["file_id"]." width=100 height=100></a><br>";}else{}if($arrEditFields[$i] == "image_id"){echo "<a href=../image.php?id=".$oArray[$arrEditFields[$i]]." target=_blank><img border=0 src=../image.php?id=".$oArray[$arrEditFields[$i]]." width=100 height=100></a><br>";}$strSize=30;echo "<input type=file name=\"".$arrEditFields[$i]."\" size=$strSize>";}else if(strstr($arrTypes[$i],"textbox")){list($strType,$strSize)=explode("_",$arrTypes[$i]);$strVal="";if(isset($oArray[$arrEditFields[$i]])){$strVal=$oArray[$arrEditFields[$i]];}

echo "<input type=text value=\"".stripslashes($strVal)."\" name=\"".$arrEditFields[$i]."\" id=\"".$arrEditFields[$i]."\" size=$strSize>";}else if(strstr($arrTypes[$i],"textarea")){list($strType,$strCols,$strRows)=explode("_",$arrTypes[$i]);

$strVal="";if(isset($oArray[$arrEditFields[$i]])){$strVal=$oArray[$arrEditFields[$i]];}echo "<textarea name=\"".$arrEditFields[$i]."\" id=\"".$arrEditFields[$i]."\" cols=$strCols rows=$strRows>".stripslashes($strVal)."</textarea>";}else 

if(strstr($arrTypes[$i],"javascript~combobox")){echo "<select name=\"".$arrNames[$i]."\" onChange=javascript:SelectChanged(this)>";foreach(explode("_",$arrTypes[$i]) as $strOption){if($strOption=="javascript~combobox"){continue;}echo "<option>".str_replace("~"," ",$strOption)."</option>";}}else if(strstr($arrTypes[$i],"combobox_special")){


if($arrEditFields[$i]=="pg"){$strVal="";if(isset($oArray[$arrEditFields[$i]])){$strVal = $oArray[$arrEditFields[$i]];} echo "<select name=\"pg\">";echo "<option>NONE OF THE PAGES</option>";global $arrFrmPages;foreach($arrFrmPages as $pg){list($lng,$page)=explode("_",$pg);

echo "<option value=\"".$pg."\" ".($strVal==$pg?"selected":"").">".urldecode($page)." [".strtoupper($lng)."] </option>";}echo "</select>";echo "</td>";}else

 if($arrEditFields[$i]=="blog_category")
 
 {
 $strVal="";
 if(isset($oArray[$arrEditFields[$i]])){
 $strVal = $oArray[$arrEditFields[$i]];}


	$categories_content = file_get_contents('../include/categories_en.php');

	$arrCategories = explode("\n", trim($categories_content));

	$bF = true;$bC=0;$iCatC=0;

	echo "<select name=\"blog_category\" >";

	foreach($arrCategories as $strCategory)
	{
		$category_ = explode(". ",$strCategory);
		$prefix = "";
		
		if(substr_count($strCategory, '.')>1) $prefix = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style=\"font-size:9px\">";
		
		echo "<option value=\"".$category_[0]."\" ".($category_[0]==$strVal?"selected":"").">".$prefix.$category_[1]."</option>";
	}	

echo "</select>";

 


}}

else if(strstr($arrTypes[$i],"combobox")){echo "<select name=\"".$arrEditFields[$i]."\">";foreach(explode("_",$arrTypes[$i]) as $strOption){if($strOption=="combobox"){continue;}$arrOptions = explode("^", $strOption);if(sizeof($arrOptions)>1){echo "<option value=\"".$arrOptions[1]."\"";if($arrOptions[1]==$oArray[$arrEditFields[$i]]){echo " selected";}echo">".$arrOptions[0]."</option>";}else{echo "<option ";if($strOption==$oArray[$arrEditFields[$i]]){echo " selected";}echo">".$strOption."</option>";}}echo "</select>";}echo "</td>";echo "</tr>";}echo "</table>";echo "<br><table width=950>";if(!isset($HideSubmit)){echo "<tr><td><input class=adminButton type=submit value=\"".(isset($SubmitButtonText)?$SubmitButtonText:"Save changes")."\"></td></tr>";}echo "</form>";echo "</table>";}}

function SQLInsertFile2($strInputFile){global $DBHost,$DBUser,$DBPass,$DBName,$DBprefix;$UserFile = addslashes(fread (fopen ($_FILES[$strInputFile]["tmp_name"], "r"), filesize ($_FILES[$strInputFile]["tmp_name"])));$file_name = $_FILES[$strInputFile]["name"];$file_size = $_FILES[$strInputFile]["size"];$file_type = $_FILES[$strInputFile]["type"];$iResult=0;if($file_size>0){$sql = "INSERT INTO ".$DBprefix."intranet_files (content,file_type, file_size, file_name, file_date) ";$sql.= "VALUES (";$sql.= "'".$UserFile."','{$file_type}', '{$file_size}', '$file_name', NOW())";mysql_connect($DBHost,$DBUser,$DBPass);mysql_select_db($DBName);mysql_query($sql) or RegisterError("SQL_ERROR",$sql."<br>".mysql_error());$iResult=mysql_insert_id();mysql_close();}return $iResult;}

function SQLInsertFile22($strInputFile){global $DBHost,$DBUser,$DBPass,$DBName,$DBprefix;$UserFile = addslashes(fread (fopen ($_FILES[$strInputFile]["tmp_name"], "r"), filesize ($_FILES[$strInputFile]["tmp_name"])));$file_name = $_FILES[$strInputFile]["name"];$file_size = $_FILES[$strInputFile]["size"];$file_type = $_FILES[$strInputFile]["type"];$iResult=0;if($file_size>0){$sql = "INSERT INTO ".$DBprefix."dm_files (content,file_type, file_size, file_name, file_date) ";$sql.= "VALUES (";$sql.= "'".$UserFile."','{$file_type}', '{$file_size}', '$file_name', NOW())";mysql_connect($DBHost,$DBUser,$DBPass);mysql_select_db($DBName);mysql_query($sql) or RegisterError("SQL_ERROR",$sql."<br>".mysql_error());$iResult=mysql_insert_id();mysql_close();}return $iResult;}

function SQLInsertFile($strInputFile){global $DBHost,$DBUser,$DBPass,$DBName,$DBprefix;$UserFile = stripslashes(fread (fopen ($_FILES[$strInputFile]["tmp_name"], "r"), filesize ($_FILES[$strInputFile]["tmp_name"])));$file_name = $_FILES[$strInputFile]["name"];$file_size = $_FILES[$strInputFile]["size"];$file_type = $_FILES[$strInputFile]["type"];$iResult=0;if($file_size>0){$sql = "INSERT INTO ".$DBprefix."image (file_type, content, file_size, file_name, file_date) ";$sql.= "VALUES (";$sql.= "'{$file_type}', '{$UserFile}', '{$file_size}', '$file_name', NOW())";mysql_connect($DBHost,$DBUser,$DBPass);mysql_select_db($DBName);mysql_query($sql) or RegisterError("SQL_ERROR",$sql."<br>".mysql_error());$iResult=mysql_insert_id();mysql_close();}return $iResult;}

function SQLInsertImage($strInputFile){global $DBHost,$DBUser,$DBPass,$DBName,$DBprefix,$AuthUserName;if(trim($_FILES[$strInputFile]["tmp_name"]) == ""){return -2;}$ir=rand(200,100000000);$image_types = Array ("image/bmp","image/jpeg","image/pjpeg","image/gif","image/x-png");$userfile = addslashes (fread (fopen ($_FILES[$strInputFile]["tmp_name"], "r"), filesize ($_FILES[$strInputFile]["tmp_name"])));$file_name = $_FILES[$strInputFile]["name"];$file_size = $_FILES[$strInputFile]["size"];$file_type = $_FILES[$strInputFile]["type"];$iResult=0;if($file_size>0){if (in_array (strtolower ($file_type), $image_types)) {$sql = "INSERT INTO ".$DBprefix."image (image_id,image_type, image, image_size, image_name, image_date) ";$sql.= "VALUES (";$sql.= "$ir,'{$file_type}', '{$userfile}', '{$file_size}', '$file_name', NOW())";}else{echo "<font face=verdana color=red size=2><b>The file you attempt to upload is not an image! (only the following file formats are accepted: image/jpeg, image/pjpeg, image/gif, image/x-png)</font>";exit();}mysql_connect($DBHost,$DBUser,$DBPass);mysql_select_db($DBName);mysql_query($sql) or RegisterError("SQL_ERROR",$sql."<br>".mysql_error());$iResult=mysql_insert_id();mysql_close();}return $iResult;}

function SQLInsertImage2($strInputFile){global $DBHost,$DBUser,$DBPass,$DBName,$DBprefix;$UserFile = stripslashes(fread (fopen ($_FILES[$strInputFile]["tmp_name"], "r"), filesize ($_FILES[$strInputFile]["tmp_name"])));$file_name = $_FILES[$strInputFile]["name"];$file_size = $_FILES[$strInputFile]["size"];$file_type = $_FILES[$strInputFile]["type"];$iResult=0;if($file_size>0){$sql = "INSERT INTO ".$DBprefix."image (image_type, image, image_size, image_name, image_date) ";$sql.= "VALUES (";$sql.= "'{$file_type}', '{$UserFile}', '{$file_size}', '$file_name', NOW())";mysql_connect($DBHost,$DBUser,$DBPass);mysql_select_db($DBName);mysql_query($sql) or RegisterError(">> SQL_ERROR",$sql."<br>".mysql_error());$iResult=mysql_insert_id();mysql_close();}return $iResult;}

function AddNewForm($arrTexts,$arrNames,$arrTypes,$strSubmitText,$strTable,$strSuccessMessage){global $DBHost,$DBUser,$DBPass,$DBName,$DBprefix;global $category,$action,$MessageTDLength;global $SpecialProcessAddForm,$strSpecialHiddenFieldsToAdd,$jsValidation;global $arrExamples,$arrOtherValues,$arrNames2,$arrValues2,$DoNotInsert,$dm;if(sizeof($arrTexts)!=sizeof($arrNames)){echo "Length of Texts array != length of Names array";return -1;}if(sizeof($arrTexts)!=sizeof($arrTypes)){echo "Length of Texts array != length of Types array";return -1;}if(isset($SpecialProcessAddForm)){$arrValues=array();for($i=0;$i<sizeof($arrNames);$i++){$strName=$arrNames[$i];if($arrTypes[$i]=="file"){if($strName == "file_id"){

if(isset($dm)){$iFileId=SQLInsertFile22($strName);}else{$iFileId=SQLInsertFile2($strName);}array_push($arrValues,$iFileId);}else{$iFileId=SQLInsertImage($strName);array_push($arrValues,$iFileId);}}else{$tempValue = get_param($strName);$tempValue = str_replace("^","",$tempValue);if($strName == "password"){$tempValue = md5($tempValue);}array_push($arrValues,$tempValue);}}if(isset($arrOtherValues)){foreach($arrOtherValues as $arrOtherValue){array_push($arrNames, $arrOtherValue[0]);array_push($arrValues, $arrOtherValue[1]);}}if(isset($arrNames2)){for($i=0;$i<sizeof($arrNames2);$i++){array_push($arrNames,$arrNames2[$i]);array_push($arrValues,$arrValues2[$i]);}}if(!isset($DoNotInsert)){$iLId=SQLInsert($strTable,$arrNames,$arrValues);}echo "<table width=950>";echo "<tr><td class=basictext>";if(!isset($DoNotInsert) && $iLId==0){echo "<font color=red><b>Error while inserting new data.</b></font>";}else{echo "<b>$strSuccessMessage</b>";}echo "</td></tr>";echo "</table>";}if(true){echo "<table width=950>";echo "<form ".(isset($jsValidation)?"onsubmit='return $jsValidation(this)'":"")." action=index.php method=post ENCTYPE=\"multipart/form-data\">";global $folder,$page;if(isset($folder)){echo "<input type=hidden name=category value=\"".$category."\">";echo "<input type=hidden name=page value=\"".$page."\">";echo "<input type=hidden name=folder value=\"".$folder."\">";}else{echo "<input type=hidden name=category value=\"".$category."\">";echo "<input type=hidden name=action value=\"".$action."\">";}echo "<input type=hidden name=SpecialProcessAddForm>";if(isset($strSpecialHiddenFieldsToAdd)){echo $strSpecialHiddenFieldsToAdd;}for($i=0;$i<sizeof($arrTexts);$i++){echo "<tr height=24>";echo "<td class=basictext valign=middle width=".(isset($MessageTDLength)?$MessageTDLength:"80").">".$arrTexts[$i]."</td>";echo "<td class=basictext valign=top>";if(strstr($arrTypes[$i],"combobox_table")){list($strType,$strTableName,$strFieldValue,$strFieldName)=explode("~",$arrTypes[$i]);$oTable=DataTable($strTableName,"");echo "<select name=\"".$arrNames[$i]."\">";while($oRow=mysql_fetch_array($oTable)){echo "<option value=\"".$oRow[$strFieldValue]."\">".$oRow[$strFieldName]."</option>";}echo "</select>";}else if(strstr($arrTypes[$i],"file")){$strSize=30;echo "<input type=file name=\"".$arrNames[$i]."\" size=$strSize>";}else if(strstr($arrTypes[$i],"textbox")){list($strType,$strSize)=explode("_",$arrTypes[$i]);echo "<input type=text name=\"".$arrNames[$i]."\" size=$strSize>";if(isset($arrExamples[$i])) echo $arrExamples[$i];}else if(strstr($arrTypes[$i],"password")){list($strType,$strSize)=explode("_",$arrTypes[$i]);echo "<input type=password name=\"".$arrNames[$i]."\" size=$strSize>";}else if(strstr($arrTypes[$i],"textarea")){list($strType,$strCols,$strRows)=explode("_",$arrTypes[$i]);echo "<textarea name=\"".$arrNames[$i]."\" id=\"".$arrNames[$i]."\" cols=$strCols rows=$strRows></textarea>";}else if(strstr($arrTypes[$i],"javascript~combobox")){echo "<select name=\"".$arrNames[$i]."\" onChange=javascript:SelectChanged(this)>";foreach(explode("_",$arrTypes[$i]) as $strOption){if($strOption=="javascript~combobox"){continue;}echo "<option>".str_replace("~"," ",$strOption)."</option>";}}else if(strstr($arrTypes[$i],"combobox_special")){}else if(strstr($arrTypes[$i],"combobox")){echo "<select name=\"".$arrNames[$i]."\">";foreach(explode("_",$arrTypes[$i]) as $strOption){if($strOption=="combobox"){continue;}$arrOptions = explode("^", $strOption);if(sizeof($arrOptions) > 1){echo "<option value=\"".$arrOptions[1]."\">".str_replace("~"," ",$arrOptions[0])."</option>";}else{echo "<option >".str_replace("~"," ",$strOption)."</option>";}}echo "</select>";}echo "</td>";echo "</tr>";}echo "</table>";echo "<br><table width=950>";echo "<tr><td><input class=adminButton type=submit value=\"".$strSubmitText."\"></td></tr>";echo "</form>";echo "</table>";}}

function Parameter($paramId){global $DBHost,$DBUser,$DBPass,$DBName,$DBprefix,$AuthUserName;mysql_connect($DBHost,$DBUser,$DBPass);mysql_select_db($DBName);$strQuery="select * from ".$DBprefix."settings WHERE id=".$paramId;$oDataTable=mysql_query($strQuery) or RegisterError("SQL_ERROR",$strQuery."<br>".mysql_error());$oRow=mysql_fetch_array($oDataTable);mysql_close();return stripslashes($oRow['value']);}

function SQLInsert($strTable,$arrNames,$arrValues){global $DBHost,$DBUser,$DBPass,$DBName,$DBprefix;$strNames="";$strList="";$num = count($arrNames);for ($i = 0; $i < $num; $i++) {$strNames.=$arrNames[$i].","; }$num = count ($arrValues);for ($i = 0; $i < $num; $i++) {$strList.="'".addslashes($arrValues[$i])."',"; }$strList=substr($strList,0,(strlen($strList)-1));$strNames=substr($strNames,0,(strlen($strNames)-1));mysql_connect("$DBHost", "$DBUser", "$DBPass");mysql_select_db($DBName);$strQuery="INSERT INTO $DBprefix".$strTable." ($strNames) VALUES ($strList)";mysql_query($strQuery) or RegisterError("SQL_ERROR",$strQuery."<br>".mysql_error());$iResult=mysql_insert_id();mysql_close();return $iResult;}

function SQLUpdateField_Multiple($strTable,$strName,$strValue,$strIdName,$strIds){global $DBHost,$DBUser,$DBPass,$DBName,$DBprefix;mysql_connect("$DBHost", "$DBUser", "$DBPass");mysql_select_db($DBName);$strQuery="UPDATE $DBprefix".$strTable." SET $strName='".addslashes($strValue)."'WHERE $strIdName IN ($strIds)";mysql_query($strQuery) or RegisterError("SQL_ERROR",$strQuery."<br>".mysql_error());mysql_close();}

function SQLUpdate($strTable,$arrNames,$arrValues,$whereClause){global $DBHost,$DBUser,$DBPass,$DBName,$DBprefix;if(count($arrNames)!=count($arrValues)){echo "<font color=red>SQLUpdate error: the number of names mismathes the number of values</font>";}$strUpdateList="";$num = count ($arrNames);for ($i = 0; $i < $num; $i++) {$strUpdateList.="$arrNames[$i]='".addslashes($arrValues[$i])."',"; }$strUpdateList=substr($strUpdateList,0,(strlen($strUpdateList)-1));mysql_connect("$DBHost", "$DBUser", "$DBPass");mysql_select_db($DBName);$strQuery="UPDATE $DBprefix".$strTable." SET $strUpdateList WHERE $whereClause";$iResult=mysql_query($strQuery) or RegisterError("SQL_ERROR",$strQuery."<br>".mysql_error());mysql_close();return $iResult;}

function SQLDelete($strTable,$Key,$arrIDs){global $DBHost,$DBUser,$DBPass,$DBName,$DBprefix;$strList="";$num = count ($arrIDs);for ($i = 0; $i < $num; $i++) {$strList.=$arrIDs[$i].","; }$strList=substr($strList,0,(strlen($strList)-1));mysql_connect($DBHost,$DBUser,$DBPass);mysql_select_db($DBName);$strQuery="delete from $DBprefix".$strTable." where $Key in ($strList)";mysql_query($strQuery) or RegisterError("SQL_ERROR",$strQuery."<br>".mysql_error());mysql_close();}

function SQLQuery($queryText){global $DBHost,$DBUser,$DBPass,$DBName,$DBprefix;mysql_connect($DBHost,$DBUser,$DBPass);mysql_select_db($DBName);mysql_query($queryText) or RegisterError("SQL_ERROR",$queryText."<br>".mysql_error());mysql_close();}

function SQLQuery_OC($queryText){mysql_query($queryText) or RegisterError("SQL_ERROR",$queryText."<br>".mysql_error());}

function SQLQuery2($queryText){global $DBHost,$DBUser,$DBPass,$DBName,$DBprefix;mysql_connect($DBHost,$DBUser,$DBPass);mysql_select_db($DBName);mysql_query($queryText) or RegisterError("SQL_ERROR",$queryText."<br>".mysql_error());mysql_close();}

function SQLCount($strTable,$sqlClause){global $DBHost,$DBUser,$DBPass,$DBName,$DBprefix;mysql_connect($DBHost,$DBUser,$DBPass);mysql_select_db($DBName);$strQuery="select count(*) from $DBprefix".$strTable." $sqlClause";$oDataTable=mysql_query($strQuery) or RegisterError("SQL_ERROR",$strQuery."<br>".mysql_error());mysql_close();$oResult=mysql_fetch_row($oDataTable);return $oResult[0];}

function SQLCount_OC($strTable,$sqlClause){global $DBprefix;$strQuery="select count(*) from $DBprefix".$strTable." $sqlClause";$oDataTable=mysql_query($strQuery) or RegisterError("SQL_ERROR",$strQuery."<br>".mysql_error());$oResult=mysql_fetch_row($oDataTable);return $oResult[0];}

function SQLLast($strTable,$columnName){global $DBHost,$DBUser,$DBPass,$DBName,$DBprefix;mysql_connect("$DBHost", "$DBUser", "$DBPass");mysql_select_db($DBName);$strQuery="select max(".$columnName.") from $DBprefix".$strTable." ";$oDataTable=mysql_query($strQuery) or RegisterError("SQL_ERROR",$strQuery."<br>".mysql_error());mysql_close();$oResult=mysql_fetch_row($oDataTable);return $oResult[0];}

function DataTable($strTable,$sqlClause){global $DBHost,$DBUser,$DBPass,$DBName,$DBprefix;mysql_connect("$DBHost", "$DBUser", "$DBPass");mysql_select_db($DBName);$strQuery="select * from $DBprefix".$strTable." $sqlClause";$oDataTable=mysql_query($strQuery) or RegisterError("SQL_ERROR",$strQuery."<br>".mysql_error());mysql_close();return $oDataTable;}

function DataTable_OC($strTable,$sqlClause){global $DBprefix;$strQuery="select * from $DBprefix".$strTable." $sqlClause";$oDataTable=mysql_query($strQuery) or RegisterError("SQL_ERROR",$strQuery."<br>".mysql_error());return $oDataTable;}

function DataArray($strTable,$sqlClause){global $DBHost,$DBUser,$DBPass,$DBName,$DBprefix;mysql_connect("$DBHost", "$DBUser", "$DBPass");mysql_select_db($DBName);$sqlQuery="select * from $DBprefix".$strTable." WHERE $sqlClause";$oDataTable=mysql_query($sqlQuery);
mysql_close();
if(!$oDataTable || mysql_num_rows($oDataTable) == 0){$result = null;}
else{$result= mysql_fetch_array($oDataTable);}
return $result;}

function MySQL_OC(){global $DBHost,$DBUser,$DBPass,$DBName,$DBprefix;mysql_connect("$DBHost", "$DBUser", "$DBPass");mysql_select_db($DBName);}
function MySQL_CC(){mysql_close();}

function DataArray_OC($strTable,$sqlClause)
{
	global $DBprefix;
	$sqlQuery="select * from ".$DBprefix.$strTable." WHERE ".$sqlClause;
	$oDataTable=mysql_query($sqlQuery);
	
	
	if(!$oDataTable || mysql_num_rows($oDataTable) == 0)
	{$result = null;}
	else{$result= mysql_fetch_array($oDataTable);}
	mysql_free_result($oDataTable);
	return $result;
}

function SQLArray($sqlQuery){global $DBHost,$DBUser,$DBPass,$DBName,$DBprefix;mysql_connect("$DBHost", "$DBUser", "$DBPass");mysql_select_db($DBName);$oDataTable=mysql_query($sqlQuery) or RegisterError("SQL_ERROR",$sqlQuery."<br>".mysql_error());mysql_close();return mysql_fetch_array($oDataTable);}

function renderVerticalSQLTable($strTable,$oCol,$oNames,$iWidth,$sqlClause){global $DBHost,$DBUser,$DBPass,$DBName,$DBprefix;$result="";mysql_connect("$DBHost", "$DBUser", "$DBPass");mysql_select_db($DBName);$strQuery="select * from $DBprefix".$strTable." $sqlClause";$oDataTable=mysql_query($strQuery) or RegisterError("SQL_ERROR",$strQuery."<br>".mysql_error());$result.="<table celpading=2 cellspacing=0 width=$iWidth style='border-color:#cecfce;border-width:1px 1px 1px 1px;border-style:solid'>";$result.="<tr bgcolor=#cecfce height=20 nowrap>";$result.="<td class=oHeader width=150 nowrap >Field</td>";$result.="<td class=oHeader nowrap >Value</td>";$result.="</tr>";$boolColor=true;while ($myArray = mysql_fetch_array($oDataTable)){$iRowsCount=count($oCol );for($i=0;$i<$iRowsCount;$i++){$result.="<tr height=20>";$columnName=$oCol[$i];$columnText=$oNames[$i];$result.="<td class=oMain >$columnText</td>";$strParticularCases=particularCases($columnName,$myArray);if($strParticularCases!=""){$result.=$strParticularCases;}else{$val=$myArray["$columnName"]; $result.="<td class=oMain >$val</td>";}$result.="</tr>";$boolColor=$boolColor?false:true;}}$result.="</table>";mysql_close();return $result;}

function RenderTable_BA($strTable,$oCol,$oNames,$iWidth,$sqlClause,$strCheckColumnName,$strCheckValue,$strFormAction)
{global $arrHighlightIds;global $strHighlightIdName;global$IS_RADIO;global $RADIO_VALUE;global $DBHost,$DBUser,$DBPass,$DBName,$DBprefix,$action,$category;global $strSpecialHiddenFieldsToAdd,$strExplanationTitle,$PageSize,$PageNumber,$arrTDSizes,$iRTables;global $SEARCH_IN,$SEARCH,$TOTAL_NUMBER_OF_RESULTS,$QUERY_EXECUTED_FOR,$PAGE_SIZE,$customFormEnd,$order,$order_type,$ORDER_QUERY,$QUERY_TO_EXECUTE,$comboSearch,$textSearch;global $arrReplaceColumns,$arrReplaceValues,$DisableSearch;
if(!isset($PageSize)){$PageSize=20;}if(!isset($PageNumber)){$PageNumber=1;}echo "<script>function nvoid(){}function ChangePageSize(x){var category='$category';var action='$action';var newSize=10;if(x==0){newSize=5;}else if(x==1){newSize=10;}else if(x==2){newSize=20;}else if(x==3){newSize=50;}else if(x==4){newSize=100;}document.location.href='".$strFormAction."&PageSize='+newSize+'';}</script>";if(isset($order)){$arrSQLClause = explode("ORDER BY",$sqlClause);$strQuery="SELECT * FROM $DBprefix".$strTable." ".$arrSQLClause[0]." ORDER BY $order $order_type";}else if(isset($textSearch)){$arrSQLClause = explode("ORDER BY",$sqlClause);if(trim($sqlClause)!=""){global $fieldsList; $strQuery="SELECT ".(isset($fieldsList)?$fieldsList:"*")." FROM $DBprefix".$strTable." ".$arrSQLClause[0]." AND ".$comboSearch." LIKE '%".$textSearch."%' ".(isset($ORDER_QUERY)?$ORDER_QUERY:"");}else{global $fieldsList; $strQuery="SELECT ".(isset($fieldsList)?$fieldsList:"*")." FROM $DBprefix".$strTable." WHERE ".$comboSearch." LIKE '%".$textSearch."%' ".(isset($ORDER_QUERY)?$ORDER_QUERY:"");}}else{global $fieldsList; $strQuery="SELECT ".(isset($fieldsList)?$fieldsList:"*")." FROM $DBprefix".$strTable." ".$sqlClause." ".(isset($ORDER_QUERY)?$ORDER_QUERY:"");}if($QUERY_TO_EXECUTE){$strQuery=$QUERY_TO_EXECUTE;}$iTotalResults=SQLCount_Query($strQuery);mysql_connect($DBHost,$DBUser,$DBPass);mysql_select_db($DBName);list($msec1,$sec1)=explode(" ",microtime());$oDataTable=mysql_query($strQuery." LIMIT ".(($PageNumber-1)*$PageSize).",".($PageSize)."") or RegisterError("SQL_ERROR",$strQuery."<br>".mysql_error());list($msec2,$sec2)=explode(" ",microtime());$strExecutionTime=(intval($sec2)-intval($sec1))+(floatval($msec2)-floatval($msec1))." sec";mysql_close();
echo "<table width=100%><tr><td class=basictext align=right><table><tr><td class=basicText><b>$PAGE_SIZE:</b></td><td class=basicText valign=top><select onchange='javascript:ChangePageSize(this.selectedIndex)'><option ".($PageSize==5?"selected":"").">5</option><option ".($PageSize==10?"selected":"").">10</option><option ".($PageSize==20?"selected":"").">20</option><option ".($PageSize==50?"selected":"").">50</option><option ".($PageSize==100?"selected":"").">100</option></select> </td> <td class=basictext> &nbsp;&nbsp;<b>";for($f=1;$f<=ceil($iTotalResults/$PageSize);$f++){echo "&nbsp;&nbsp;";echo "<a href='".$strFormAction."&PageSize=$PageSize&PageNumber=$f".(isset($order)?"&order=$order":"")."".(isset($order_type)?"&order_type=$order_type":"")."".(isset($comboSearch)?"&comboSearch=$comboSearch":"")."".(isset($textSearch)?"&textSearch=$textSearch":"")."'>$f</a>";if($f==20){break;}if($f%25==0){echo "<br>";}}echo " </b> </td> </tr> </table> </td><td class=basictext align=right><b>";if(isset($strExplanationTitle)){$strExplanationTitle=str_replace("[COUNT]","(total: ".$iTotalResults.")",$strExplanationTitle);echo $strExplanationTitle;}echo "</b></td></tr></table><br>";$iRTables++;if(isset($DisableSearch)){}else{echo "<table cellspacing=0 cellpadding=0 width=$iWidth><form action='$strFormAction' method=POST><tr><td class=basictext width=60 ><a href=\"javascript:nvoid()\" onclick=\"document.all.spanSearch".$iRTables.".style.display='none';document.all.spanInfo".$iRTables.".style.display='block';\"><img src='images/qhelp.gif' width=12 height=13 border=0></a>&nbsp;<a href=\"javascript:nvoid()\" onclick=\"document.all.spanSearch".$iRTables.".style.display='block';document.all.spanInfo".$iRTables.".style.display='none';\"><img src='images/qsearch.gif' width=13 height=14 border=0></a></td><td  class=basictext align=left valign=top><span id=spanInfo".$iRTables." style='display:none'>$TOTAL_NUMBER_OF_RESULTS: <font color=red>".$iTotalResults."</font>&nbsp;&nbsp;$QUERY_EXECUTED_FOR: <font color=red>".$strExecutionTime."</font></span><span id=spanSearch".$iRTables." style='display:none'>$SEARCH_IN <select name=comboSearch style='font-size:11;font-family:verdana'>";for($k=0;$k<sizeof($oNames);$k++){if(strtolower(substr($oCol[$k],0,4))!="type" &&strtolower(substr($oCol[$k],0,7))!="preview" &&strtolower(substr($oCol[$k],0,4))!="show" &&strtolower(substr($oCol[$k],0,6))!="friend" && strtolower(substr($oCol[$k],0,4))!="edit"&& strtolower(substr($oCol[$k],0,4))!="date"&& strtolower(substr($oCol[$k],0,12))!="notecategory"&& strtolower(substr($oCol[$k],0,7))!="file_id"&& strtolower(substr($oCol[$k],0,8))!="image_id"){echo "<option value=\"".$oCol[$k]."\" ".(isset($comboSearch)&&$comboSearch==$oCol[$k]?"selected":"").">".$oNames[$k]."</option>";}}echo "</select> &nbsp; <input style='font-size:11;font-family:verdana' ".(isset($textSearch)?$textSearch:"")." type=text name=textSearch> <input type=submit class=adminButton value=' $SEARCH '></span></td></form></tr></table>";}echo "<table cellpadding=3 cellspacing=0 width=$iWidth style='border-color:#cecfce;border-width:1px 1px 1px 1px;border-style:solid'>";echo "<form action='$strFormAction' method=POST> ";echo "<tr class=table_header height=20 nowrap>";if(isset($strSpecialHiddenFieldsToAdd)){echo $strSpecialHiddenFieldsToAdd;}$iTDWidth=0;$iDefaultTDWidth=0;$iTDTotalNumber=sizeof($oCol);if(!isset($arrTDSizes)){$iTDWidth=round(($iWidth-30)/$iTDTotalNumber);$arrTDSizes=array_fill(0, sizeof($oCol), $iTDWidth);}else{$iOccupied=0;$iTDHaveValues=0;foreach($arrTDSizes as $strTDSize){if($strTDSize!="*"){$iOccupied+=intval($strTDSize);$iTDHaveValues++;}}if(($iTDTotalNumber-$iTDHaveValues)==0){$iDefaultTDWidth=round((($iWidth-30)-$iOccupied)/($iTDHaveValues));}else{$iDefaultTDWidth=round((($iWidth-30)-$iOccupied)/($iTDTotalNumber-$iTDHaveValues));}for($k=0;$k<sizeof($arrTDSizes);$k++){if($arrTDSizes[$k]!="*"){$arrTDSizes[$k]=intval($arrTDSizes[$k]);}else{$arrTDSizes[$k]=$iDefaultTDWidth;}}}
if(trim($strCheckColumnName)!=""){echo "<td class=oHeader width=30 nowrap >$strCheckColumnName</td>";}$iTDHeaderCounter=0;if(!isset($order_type)){$order_type="desc";$strImgName="";}else if($order_type=="asc"){$order_type="desc";$strImgName="up.gif";}else{$order_type="asc";$strImgName="down.gif";}$arrFields=GetFieldsInTable($strTable);foreach ($oNames as $columnName) {echo "<td class=oHeader width=".($iWidth=="100%"?round(100/sizeof($oNames))."%":$arrTDSizes[$iTDHeaderCounter])." nowrap ><table cellspacing=0 cellpadding=0><tr><td class=oHeader>".(in_array($oCol[$iTDHeaderCounter],$arrFields)&&!isset($DisableSearch)?("<a href='".$strFormAction."&order=".$oCol[$iTDHeaderCounter]."&order_type=".$order_type."' >"):"")."$columnName</a></td><td class=oHeader>".((isset($order)&&$order==$oCol[$iTDHeaderCounter]&&$strImgName!="")?"<img src=images/".$strImgName." width=10 height=10 style='position:relative;top:0;left:3'>":"")."</td></tr></table></td>";$iTDHeaderCounter++; }echo "</tr>";$boolColor=true;while ($myArray = mysql_fetch_array($oDataTable)){if(isset($arrHighlightIds) && isset($strHighlightIdName) && in_array($myArray[$strHighlightIdName],$arrHighlightIds,false))

{echo "<tr bgcolor=\"#fffeca\" height=32>";}


else{

echo "<tr bgcolor=".($boolColor?"#ffffff":"#f7f7f7")." height=32>";

}if(trim($strCheckColumnName)!=""){$cVal=$myArray["$strCheckValue"];echo "<td class=oMain nowrap >";if(isset($IS_RADIO)){echo "<input type=radio name=CheckList value=\"$cVal\" ".($cVal==$RADIO_VALUE?"checked":"").">";}else{echo "<input type=checkbox name=CheckList[] value='$cVal'>";}echo "</td>";}foreach ($oCol as $columnName) {$strParticularCases=particularCases_BA($columnName,$myArray);if($strParticularCases!=""){echo $strParticularCases;}else if($columnName == "date"){if(isset($myArray[$columnName]) && $myArray[$columnName] != ""){global $PHP_DATE_FORMAT;echo "<td class=oMain>".date($PHP_DATE_FORMAT,$myArray[$columnName])."</td>";}else{echo "<td class=oMain>&nbsp;</td>";}}else{$val="";if(isset($myArray[$columnName])){$val=stripslashes($myArray[$columnName]);}if(isset($arrReplaceColumns) && in_array($columnName, $arrReplaceColumns)){echo "<td class=oMain>".$arrReplaceValues[0][$val]."</td>";}else if(isset($textSearch)&&trim($textSearch)!=""&&$comboSearch==$columnName){
$val=eregi_replace($textSearch,"<span style='background:yellow'>".$textSearch."</span>",$val);echo "<td class=oMain>".$val."</td>";}else{if(substr($val,0,4) == "http"){echo "<td class=oMain><a href=\"$val\">$val</a></td>";}else{ echo "<td class=oMain>$val</td>";}}} }echo "</tr>";$boolColor=$boolColor?false:true;}echo "</table>";if(trim($strCheckColumnName)!=""){echo "<br><input type=\"hidden\" name=\"Delete\" value=\"\"><table width=".($iWidth=="100%"?$iWidth:$iWidth+15)." cellpadding=0 cellspacing=0><tr><td align=right><input type=submit value=' $strCheckColumnName ' class=adminButton></td></tr></table>";}if(isset($customFormEnd)&&$customFormEnd){}else{echo "</form>";}}

function RenderTable(
						$strTable,
						$oCol,
						$oNames,
						$iWidth,
						$sqlClause,
						$strCheckColumnName,
						$strCheckValue,
						$strFormAction
						){

	global $arrHighlightIds;
	global $strHighlightIdName;
	global	$IS_RADIO;
	global $RADIO_VALUE;
	global $DBHost,$DBUser,$DBPass,$DBName,$DBprefix,$action,$category;
	global $URLToAdd,$iWidth;
	global $strExplanationTitle,$PageSize,$PageNumber,$arrTDSizes,$iRTables;
	global $mod;
	
	global $SEARCH_IN,$SEARCH,$TOTAL_NUMBER_OF_RESULTS,$QUERY_EXECUTED_FOR,$PAGE_SIZE,$customFormEnd,$order,$order_type,$ORDER_QUERY,$QUERY_TO_EXECUTE,$comboSearch,$textSearch;
	
	if(!isset($PageSize))
	{
		$PageSize=20;
	}
	else
	{
		ms_i($PageSize);
	}
	
	if(!isset($PageNumber))
	{
		$PageNumber=1;
	}
	else
	{
		ms_i($PageNumber);
	}
	
	

	echo "
	<script>
	function ChangePageSize(x){
				
					var newSize=10;
					
					if(x==0){
						newSize=5;
					}
					else
					if(x==1){
						newSize=10;
					}
					else
					if(x==2){
						newSize=20;
					}
					else
					if(x==3){
						newSize=50;
					}
					else
					if(x==4){
						newSize=100;
					}";
					
					if(isset($mod))
					{
						echo "
						document.location.href='index.php?mod=$mod&PageSize='+newSize+'".(isset($URLToAdd)?$URLToAdd:"")."".(get_param("p")!=""?"&p=".get_param("p"):"")."';
						";
					}
					else
					{
						echo "var category='$category';
						var action='$action';
						document.location.href='".$strFormAction."&PageSize='+newSize+'".(isset($URLToAdd)?$URLToAdd:"")."';";
					}
					
		echo "		}
				
		</script>
	
	";
	
	
	
	if(get_param("order")!="")
	{
		$arrSQLClause = explode("ORDER BY",$sqlClause);
		$strQuery="SELECT * FROM $DBprefix".$strTable." ".$arrSQLClause[0]." ORDER BY ".get_param("order")." ".get_param("order_type");
	}
	else
	if(get_param("textSearch")!="")
	{
			if(trim($sqlClause)!="")
			{
				$strQuery="SELECT * FROM $DBprefix".$strTable." WHERE ".get_param("comboSearch")." LIKE '%".get_param("textSearch")."%' ".( stripos($sqlClause, "WHERE")===false?"":"AND")."  ".str_ireplace("WHERE","",$sqlClause)."   ".(isset($ORDER_QUERY)?$ORDER_QUERY:"");
			}
			else
			{
				$strQuery="SELECT * FROM $DBprefix".$strTable." WHERE ".get_param("comboSearch")." LIKE '%".get_param("textSearch")."%'  ".(isset($ORDER_QUERY)?$ORDER_QUERY:"");
			}
	}
	else
	{
		$strQuery="SELECT * FROM $DBprefix".$strTable." ".$sqlClause." ".(isset($ORDER_QUERY)?$ORDER_QUERY:"");
	}
	

	if($QUERY_TO_EXECUTE)
	{
		$strQuery=$QUERY_TO_EXECUTE;
	}

	$iTotalResults=SQLCount_Query($strQuery);

	mysql_connect($DBHost,$DBUser,$DBPass);
	mysql_select_db($DBName);
	
	$mysql_fields = array();
 
	$oResult=mysql_query("SHOW COLUMNS FROM ".$DBprefix.$strTable); 
	
	while ($row = mysql_fetch_assoc($oResult)) 
	{
	   array_push($mysql_fields,$row["Field"]);
	}
	
	$oDataTable=mysql_query($strQuery." LIMIT ".(($PageNumber-1)*$PageSize).",".($PageSize)."") or RegisterError("SQL_ERROR",$strQuery."<br>".mysql_error());
	
	
	mysql_close();

	
			
			
	$iRTables++;
	$hide_search_field=true;
	echo "
	<br><br><br>
	<div style=\"background-repeat:repeat-x;background-image:url('images2/results-top-back.gif');height:35px;width:".(isset($iWidth)?$iWidth:"100%")."\">
	<form  action='$strFormAction".(isset($URLToAdd)?$URLToAdd:"")."' method=POST>
	
	<div style=\"float:left;margin-top:8px\">
	&nbsp; ".$TOTAL_NUMBER_OF_RESULTS.": <font color=\"#587ca0\">".$iTotalResults."</font>
	&nbsp;&nbsp;
	
	</div>
	<div id=\"search_field\" style=\"float:right;margin-top:6px;\">
	".$SEARCH_IN.": <select name=comboSearch style='height:21px'>";
	
	for($k=0;$k<sizeof($oNames);$k++)
	{
		if(in_array($oCol[$k], $mysql_fields)) 
		{
			$hide_search_field=false;
			echo "<option value=\"".$oCol[$k]."\" ".(get_param("comboSearch")==$oCol[$k]?"selected":"").">".$oNames[$k]."</option>";
		}
	}
	
	echo "</select>
	<input style=\"border-style:solid;border-color:#b8b8b8;height:21px;border-width:1px 1px 1px 1px\" value=\"".(get_param("textSearch")!=""?get_param("textSearch"):"")."\" type=text name=textSearch> 
	<input type=submit class=adminButton value=' $SEARCH '>
	&nbsp;
	</div>
	
	
	</form>
	</div>
	<div style=\"clear:both\"></div>
	
	";
	if($hide_search_field)
	{
		echo "<script>document.getElementById('search_field').style.display=\"none\";</script>";
	}
	
	
	echo "<table cellpadding=3 cellspacing=0  width=\"".(isset($iWidth)?$iWidth:"100%")."\" style='border-color:#cecfce;border-width:1px 1px 1px 1px;border-style:solid'>";
	echo "<form action='$strFormAction".(isset($URLToAdd)?$URLToAdd:"")."' method=POST> ";
	echo "<tr class=\"table_header\" nowrap>";
	
	
	$iTDWidth=0;
	$iDefaultTDWidth=0;
	
	$iTDTotalNumber=sizeof($oCol);
	
	
	if(!isset($arrTDSizes)){
		
		$iTDWidth=round(($iWidth-30)/$iTDTotalNumber);
		$arrTDSizes=array_fill(0, sizeof($oCol), $iTDWidth);
		
	}
	else{
		$iOccupied=0;
	
		$iTDHaveValues=0;	
				
		foreach($arrTDSizes as $strTDSize){
		
			if($strTDSize!="*"){
				$iOccupied+=intval($strTDSize);		
				$iTDHaveValues++;
			}
			
		}	
		
		if(($iTDTotalNumber-$iTDHaveValues)==0){
		
			$iDefaultTDWidth=round((($iWidth-30)-$iOccupied)/($iTDHaveValues));	
		
		}
		else{
			$iDefaultTDWidth=round((($iWidth-30)-$iOccupied)/($iTDTotalNumber-$iTDHaveValues));	
		}
		
		for($k=0;$k<sizeof($arrTDSizes);$k++){
		
				if($arrTDSizes[$k]!="*"){
					$arrTDSizes[$k]=intval($arrTDSizes[$k]);									
				}
				else{
					$arrTDSizes[$k]=$iDefaultTDWidth;
				}	
							
		}
			
	}

	
	if(trim($strCheckColumnName)!=""){
		echo "<td class=oHeader  width=30 nowrap >$strCheckColumnName</td>";
	}

	$iTDHeaderCounter=0;
	
	
	
	
	if(!isset($order_type)){
		$order_type="desc";
		$strImgName="";
	}
	else
	if($order_type=="asc"){
		$order_type="desc";
		$strImgName="up2.gif";
	}
	else{
		$order_type="asc";
		$strImgName="down2.gif";
	}
	
	$arrFields=$mysql_fields;
	

	
	foreach ($oNames as $columnName) {
			echo "<td class=oHeader width=".$arrTDSizes[$iTDHeaderCounter]."  nowrap >
			<table cellspacing=0 cellpadding=0><tr><td  class=oHeader>
			".(in_array($oCol[$iTDHeaderCounter],$arrFields)?("<a style=\"text-decoration:underline\" href='".$strFormAction."&order=".$oCol[$iTDHeaderCounter]."&order_type=".$order_type."".(isset($URLToAdd)?$URLToAdd:"")."' >"):"")."
			$columnName
			</a>
			</td><td  class=oHeader align=top>
			".((isset($order)&&$order==$oCol[$iTDHeaderCounter]&&$strImgName!="")?"<img src=images/".$strImgName." width=\"8\" height=\"5\" style='position:relative;top:0px;left:6px'>":"")."
			</td></tr></table>
			</td>";
			$iTDHeaderCounter++;
  	}

	echo "</tr>";

	$boolColor=true;


	
	while ($myArray = mysql_fetch_array($oDataTable))
	{
	
		
			if(isset($arrHighlightIds) && isset($strHighlightIdName) && in_array($myArray[$strHighlightIdName],$arrHighlightIds,false)){
				echo "<tr bgcolor=\"#ffcf00\"  height=30>";
			}
			else{
				echo "<tr bgcolor=".($boolColor?"#ffffff":"#e3ecf1")."  height=30>";
			}

			if(trim($strCheckColumnName)!=""){
			
				$cVal=$myArray["$strCheckValue"];
				echo "<td class=oMain  nowrap >";
				
				if(isset($IS_RADIO)){
					echo "<input type=radio name=CheckList value=\"$cVal\" ".($cVal==$RADIO_VALUE?"checked":"").">";
				}
				else{
					echo "<input type=checkbox name=CheckList[] value='$cVal'>";
				}
			
				echo "</td>";
				}


			foreach ($oCol as $columnName) {



				$strParticularCases=particularCases($columnName,$myArray);

				if($strParticularCases!="")
				{
						echo $strParticularCases;
				}
				else
				if($columnName == "date"||$columnName == "Date")
				{
					if(isset($myArray[$columnName]) && $myArray[$columnName] != "")
					{
						global $PHP_DATE_FORMAT;
						echo "<td class=oMain>".date($PHP_DATE_FORMAT,$myArray[$columnName])."</td>";
					}
					else
					{
						echo "<td class=oMain>&nbsp;</td>";
					}
				}
				else{
						$val="";

						if(isset($myArray[$columnName]))
						{

									$val=$myArray[$columnName];
						}
						
						if(get_param("textSearch")!=""&&$comboSearch==$columnName)
						{
							$val=eregi_replace(get_param("textSearch"),"<span style='background:yellow'>".get_param("textSearch")."</span>",$val);
							echo "<td class=oMain>".stripslashes($val)."</td>";
						}
						else{
							if(substr($val,0,4) == "http")
							{
								echo "<td class=oMain><a href=\"$val\">$val</a></td>";
							}
							else{
   								echo "<td class=oMain>".stripslashes($val)."</td>";
							}
						}
				}
  			}

			echo "</tr>";

			$boolColor=$boolColor?false:true;

	}

	echo "</table>";

	
	if(trim($strCheckColumnName)!=""){
		echo "
			<br>
			<input type=hidden name='Delete' value=''>
			
			<input style=\"float:right\" type=submit value=' $strCheckColumnName ' class=adminButton>
			
		";	
	}
	
	echo "<table style=\"float:left\" cellpadding=\"0\" cellspacing=\"0\">
				<tr>
					<td class=basictext>
							<table>
							<tr>
							<td class=basicText>
							<b>
							$PAGE_SIZE:
							
							</b>
							</td>
							<td class=basicText valign=top>
								<select onchange='javascript:ChangePageSize(this.selectedIndex)'>
									<option ".($PageSize==5?"selected":"").">5</option>
									<option ".($PageSize==10?"selected":"").">10</option>
									<option ".($PageSize==20?"selected":"").">20</option>
									<option ".($PageSize==50?"selected":"").">50</option>
									<option ".($PageSize==100?"selected":"").">100</option>
								</select>
								
							 </td>
							 <td class=basictext>
							 	&nbsp;&nbsp;&nbsp;
								
								<b>";
																	
								for($f=1;$f<=ceil($iTotalResults/$PageSize);$f++)
								{
									
									if(isset($mod))
									{
										echo "<a href='index.php?mod=$mod".(isset($URLToAdd)?$URLToAdd:"")."&PageSize=$PageSize&PageNumber=$f".(isset($order)?"&order=$order":"")."".(isset($order_type)?"&order_type=$order_type":"")."".(isset($comboSearch)?"&comboSearch=$comboSearch":"")."".(get_param("textSearch")!=""?"&textSearch=".get_param("textSearch"):"").(get_param("p")!=""?"&p=".get_param("p"):"")."'>$f</a>";
									}
									else
									{
										echo "<a href='".$strFormAction."".(isset($URLToAdd)?$URLToAdd:"")."&PageSize=$PageSize&PageNumber=$f".(isset($order)?"&order=$order":"")."".(isset($order_type)?"&order_type=$order_type":"")."".(isset($comboSearch)?"&comboSearch=$comboSearch":"")."".(get_param("textSearch")!=""?"&textSearch=".get_param("textSearch"):"")."'>$f</a>";
									}
									echo "&nbsp;&nbsp;";
									
									if($f==20){
										break;
									}
									
									if($f%25==0){
										echo "<br>";
									}
								}
								
									
					echo "	 </b>
								
															
							 </td>
							 </tr>
							 </table>
							 
							 
					</td>
					<td class=basictext align=right>
						<b>
						";
								
				if(isset($strExplanationTitle)){
				
						$strExplanationTitle=str_replace("[COUNT]","(total: ".$iTotalResults.")",$strExplanationTitle);		
						
						echo $strExplanationTitle;			
				}
														
								
					echo "	
						</b>
					</td>
				</tr>
			</table><br><br><br>";
	
	if(isset($customFormEnd)&&$customFormEnd){
	
	
	}
	else{
		echo "</form>";
	}

}




function ValidateEmail($strInput){return ereg(".+@.+\..+",$strInput);}

function ValidateZip($strInput){return ereg("^[0-9]{5}$",$strInput);}

function isNumber($strInput){if(ereg("^[0-9\-]{1,}$",$strInput)){return true;}else{return false;}}

function ValidatePhoneNumber($strInput){if($strInput==""){return true;}return ereg("^[\+0-9 ]+$",$strInput);}

function ValidateExpiredDate($iYear,$iMonth){if(!ereg("^[0-9]{2}$",$iYear)){return "invalid year! (the year has to be in YY format, example: 05)";}if(!ereg("^[0-9]{2}$",$iMonth)){return "invalid month! (the month has to be in MM format, example: 02)";}$currentMonth=date("m");$currentYear=date("Y");if($iMonth=="00"){return "invalid month!";}$iMonth=trim($iMonth,"0");if($iMonth>12){return "invalid month!";}if($currentYear==$iYear&&$currentMonth>$iMonth){return "expired date";}return "ok";}

function particularCases($columnName,$myArray){global $category,$folder,$action,$ID,$EDIT_PICTURE,$iN,$AuthGroup,$lang,$arrFrmPages;if($columnName=="sub_categories"){return "<td class=oMain ><a href='index.php?category=$category&folder=$action&page=sub&id=".$myArray['id']."' ><img src='images/link_arrow.gif' width=16 height=16 border=0></a></td>";}else if($columnName=="ListPreview"){return "<td class=oMain ><a href='../site.php?user=".$myArray['user']."&list=".$myArray['id']."&type=".$myArray['type']."' target='_blank'><img src='images/link_arrow.gif' width=16 height=16 border=0></a></td>";}else if($columnName=="blogger_blog"){return "<td class=oMain ><a href='index.php?category=$category&folder=$action&page=blog&user=".$myArray['username']."' ><img src='images/link_arrow.gif' width=16 height=16 border=0></a></td>";}else if($columnName=="blogger_note"){return "<td class=oMain ><a href='index.php?category=$category&folder=$action&page=note&user=".$myArray['username']."' ><img src='images/link_arrow.gif' width=16 height=16 border=0></a></td>";}else if($columnName=="blogger_template"){return "<td class=oMain ><a href='index.php?category=$category&folder=$action&page=template&user=".$myArray['username']."' ><img src='images/link_arrow.gif' width=16 height=16 border=0></a></td>";}else if($columnName=="blog_created" || $columnName=="last_update"){return "<td class=oMain >".date("m/d/Y",$myArray[$columnName])."</td>";}else if($columnName=="ModifyPackage"){global $mod;return "<td class=oMain ><a href='index.php?category=$category&folder=$action&page=edit&id=".$myArray['id']."' ><img src='images/link_arrow.gif' width=16 height=16 border=0></a></td>";}else if($columnName=="dm_category"){global $arrDocCategories ;return "<td class=oMain valign=middle>".$arrDocCategories[$myArray['cat']]."</td>";}else if($columnName=="previous_date"){return "<td class=oMain valign=middle>".$myArray['date']."</td>";}else if($columnName=="ViewAffReport"){return "<td class=oMain valign=middle><a href='index.php?category=$category&folder=$action&page=report&username=".$myArray['username']."' ><img src='images/link_arrow.gif' width=16 height=16 border=0></a></td>";}else if($columnName=="ViewCars"){return "<td class=oMain valign=middle><a href='index.php?category=$category&folder=$action&page=view&username=".$myArray['username']."' ><img src='images/link_arrow.gif' width=16 height=16 border=0></a></td>";}else if($columnName=="EditProduct"){global $cat_id;return "<td class=oMain valign=middle><a href='index.php?category=$category&folder=$action&page=edit&cat_id=".$cat_id."&id=".$myArray['id']."' ><img src='images/link_arrow.gif' width=16 height=16 border=0></a></td>";}else if($columnName=="EditCar"){if(isset($folder)){return "<td class=oMain valign=middle><a href='index.php?category=$category&folder=$folder&page=edit&id=".$myArray['id']."' ><img src='images/link_arrow.gif' width=16 height=16 border=0></a></td>";}else{return "<td class=oMain valign=middle><a href='index.php?category=$category&folder=$action&page=edit&id=".$myArray['id']."' ><img src='images/link_arrow.gif' width=16 height=16 border=0></a></td>";}}else if($columnName=="html_limit"){$strToDisplay = "";if(strlen($myArray["html"])<=100){$strToDisplay = $myArray["html"];}else{$strToDisplay = substr($myArray["html"],0,100)." <a href='index.php?category=$category&folder=$action&page=view&id=".$myArray['id']."'>...</a>";}return "<td class=oMain >".$strToDisplay."</td>";}else if($columnName=="EditDomain"){return "<td class=oMain valign=middle><a href='index.php?category=$category&folder=$action&page=edit&id=".$myArray['id']."' ><img src='images/edit.gif' width=23 height=22 border=0></a></td>";}else 

if($columnName=="file_id"){
global $mod;return "<td class=oMain ><a href='../show_file.php?id=".$myArray['file_id']."' target=_blank>[OPEN FILE]</a></td>";}else 
if($columnName=="image_id"){global $mod;
return "<td class=oMain >
<a href='".ImageURL($myArray['image_id'],$myArray['image_type'], "../",$myArray['user'])."' target=\"_blank\">
".ShowImage($myArray['image_id'],$myArray['user'] , $myArray['image_type'],80,60,"../")."
</a></td>";}else if($columnName=="dm_file_id"){global $mod,$OPEN_FILE;return "<td class=oMain ><a href='../file.php?type=dm&id=".$myArray['file_id']."' target=_blank>[$OPEN_FILE]</a></td>";}else if($columnName=="file_id"){global $mod,$OPEN_FILE;return "<td class=oMain ><a href='../file.php?id=".$myArray['file_id']."' target=_blank>[$OPEN_FILE]</a></td>";}else if($columnName=="DomainPrice"){global $mod;return "<td class=oMain >".($myArray['price']=="0"?"[n/a]":"$".$myArray['price'])."</td>";}else if($columnName=="ShowDomainDetails"){global $mod;return "<td class=oMain ><a href='index.php?mod=$mod&did=".$myArray['id']."' >[SHOW DETAILS]</a></td>";}else if($columnName=="WYSIWYG"){return "<td class=oMain ><a href='javascript:WYSIWYG(".$myArray['id'].")' ><img src='images/mode.gif' width=23 height=22 border=0></a></td>";}else if($columnName=="AlbumEdit"){return "<td class=oMain ><a href='index.php?category=".$category."&folder=create&page=edit&id=".$myArray['id']."' ><img src='images/edit.gif' width=23 height=22 border=0></a></td>";}else if($columnName=="ShowComments"){return "<td class=oMain valign=middle><a href='index.php?category=$category&folder=$action&page=comments&id=".$myArray['id']."' ><img src='images/preview.gif' width=23 height=22 border=0></a></td>";}else if($columnName=="EditNote"){return "<td class=oMain ><a href='index.php?category=$category&folder=$action&page=edit&id=".$myArray['id']."' ><img src='images/edit.gif' width=22 height=21 border=0></a></td>";}else if($columnName=="ShowExportReport"){return "<td class=oMain valign=middle><a href='index.php?category=$category&folder=history&page=report&id=".$myArray['id']."' ><img src='images/preview.gif' width=23 height=22 border=0></a></td>";}else if($columnName=="ShowFormData"){return "<td class=oMain valign=middle><a href='index.php?category=$category&folder=manage&page=data&id=".$myArray['id']."' ><img src='images/preview.gif' width=23 height=22 border=0></a></td>";}else if($columnName=="ShowFlag"){return "<td class=oMain valign=middle><img src=\"../include/flags/".$myArray["code"].".gif\" width=21 height=14></td>";}else if($columnName=="ShowSpecialLanguage"){return "<td class=oMain ><input type=radio name=\"default_language[]\" onclick=\"javascript:RadioClick(".$myArray["id"].")\" value=\"".$myArray["id"]."\" ".($myArray["default_language"]==1?"checked":"")."></td>";}else if($columnName=="active"){return "<td class=oMain >".($myArray["active"]==1?"YES":"NO")."</td>";}else if($columnName=="ChangeLanguage"){return "<td class=oMain ><a href='index.php?category=$category&folder=$action&page=edit&id=".$myArray['id']."' ><img src='images/editer.gif' width=20 height=20 border=0></a></td>";}else if($columnName=="ShowPageLink"){return "<td class=oMain ><a href='../index.php?page=".$myArray['id']."' target=_blank><img src='images/preview.gif' width=23 height=22 border=0></a></td>";}else if($columnName=="ShowPageEditLink"){return "<td class=oMain ><a href='javascript:StartWizard(".$myArray['id'].")' ><img src='images/edit.gif' width=23 height=22 border=0></a></td>";}else if($columnName=="ShowDeleteLink"){return "<td class=oMain ><a href='javascript:DeletePage(".$myArray['id'].")'' ><img src='images/cut.gif' width=23 height=22 border=0></a></td>";}else if($columnName=="NNN"){$iN++;return "<td class=oMain width=12 align=center>".$iN."</td>";}else if($columnName=="ShowModifierUtilisateur"){if($myArray['username']=="administrator"){return "<td class=oMain>[n/a]</td>";}else{return "<td class=oMain ><a href='index.php?category=$category&folder=$action&page=edit&id=".$myArray['id']."' ><img src='images/link_arrow.gif' width=16 height=16 border=0></a></td>";}}else if($columnName=="EditCommonAccount"){return "<td class=oMain ><a href='index.php?category=$category&folder=accounts&page=editcommon&UserName=".$myArray['UserName']."' ><img src='../images/edit.gif' width=23 height=22 border=0></a></td>";}else if($columnName=="ResetPWD"){return "<td class=oMain ><a href='index.php?category=$category&action=$action&reset=".$myArray['id']."' ><img src='images/link_arrow.gif' width=16 height=16 border=0></a></td>";}else if($columnName=="ShowEditLink"){return "<td class=oMain align=center><a href='administration.php?folder=products&page=edit&ItemID=".$myArray['ItemID']."' ><img src='../images/edit.gif' width=23 height=22 border=0></a></td>";}else if($columnName=="ShowFormDelete"){return "<td class=oMain ><a href='index.php?category=".$category."&action=$action&ProceedDelete=yes&id=".$myArray['id']."' ><img src='images/cut.gif' width=23 height=22 border=0></a></td>";}else if($columnName=="GoogleQuery"){$strQuery="";$arrInfo2=explode("?",$myArray["referer"],2);if(sizeof($arrInfo2)>1){$arrInfo = explode("&",$arrInfo2[1]);foreach($arrInfo as $strInfo){if(substr($strInfo,0,2) == "q="){$strQuery = str_replace("q=","",$strInfo);break;}}}return "<td class=oMain ><a href=\"".$myArray["referer"]."\" target=_blank>".(strtoupper(urldecode($strQuery)))."</a></td>";}else if($columnName=="EditAdminUser"){return "<td class=oMain ><a href='index.php?category=".$category."&folder=admin&page=editadmin&id=".$myArray['id']."' ><img src='../images/edit.gif' width=23 height=22 border=0></a></td>";}else if($columnName=="EditCommonUser"){return "<td class=oMain ><a href='index.php?category=".$category."&folder=accounts&page=editcommon&id=".$myArray['id']."' ><img src='../images/edit.gif' width=23 height=22 border=0></a></td>";}else if($columnName=="ShowUIParams_BO"){return "<td class=oMain ><a href='index.php?category=".$category."&folder=view&page=params&id=".$myArray['id']."' ><img src='images/justify.gif' width=23 height=22 border=0></a></td>";}else if($columnName=="ShowUIParams"){return "<td class=oMain ><a href='index.php?category=".$category."&folder=uilog&page=params&id=".$myArray['id']."' ><img src='images/mode.gif' width=23 height=22 border=0></a></td>";}else if($columnName=="DeleteLanguage"){return "<td class=oMain ><a href='javascript:DeleteLanguage(".$myArray['id'].",\"".$myArray['code']."\")' ><img src='images/cancel.gif' width=21 height=20 border=0></a></td>";}else if($columnName=="DeleteTemplate"){return "<td class=oMain ><a href='javascript:DeleteTemplate(".$myArray['id'].")' ><img src='images/cancel.gif' width=21 height=20 border=0></a></td>";}else if($columnName=="ModifyTemplate"){return "<td class=oMain ><a href='index.php?category=".$category."&folder=modify&page=edit&id=".$myArray['id']."' ><img src='images/edit.gif' width=23 height=22 border=0></a></td>";}else if($columnName=="EditPosting"){return "<td class=oMain ><a href='index.php?category=".$category."&folder=my&page=edit&id=".$myArray['id']."' ><img src='images/edit.gif' width=23 height=22 border=0></a></td>";}else if($columnName=="ViewApply"){return "<td class=oMain ><a href='index.php?category=".$category."&folder=my&page=apply&id=".$myArray['id']."' ><img src='images/mode.gif' width=23 height=22 border=0></a></td>";}else if($columnName=="ShowCV"){return "<td class=oMain ><a href='index.php?category=".$category."&folder=list&page=cv&id=".$myArray['id']."' ><img src='images/mode.gif' width=23 height=22 border=0></a></td>";}else if($columnName=="ShowDeleteLink"){return "<td class=oMain ><a href='javascript:DeletePage(".$myArray['id'].")'' ><img src='../images/cut.gif' width=23 height=22 border=0></a></td>";}else if($columnName=="ShowMusicEditLink"){return "<td class=oMain ><a href='index.php?category=".$category."&folder=pages&page=music&lang=$lang&page_id=".$myArray['id']."' ><img src='images/mode.gif' width=25 height=22 border=0></a></td>";}else if($columnName=="BackupForm"){return "<td class=oMain ><a href='index.php?category=".$category."&action=$action&SpecialProcessAddForm=".$myArray['id']."' ><img src='images/button_copy.gif' width=23 height=22 border=0></a></td>";}else if($columnName=="ShowFormEdit"){return "<td class=oMain ><a href='index.php?category=".$category."&folder=manage&page=edit&id=".$myArray['id']."' ><img src='images/edit.gif' width=23 height=22 border=0></a></td>";}else if($columnName=="ShowFormPreview"){return "<td class=oMain ><a href='index.php?category=".$category."&folder=manage&page=preview&id=".$myArray['id']."' ><img src='images/preview.gif' width=23 height=22 border=0></a></td>";}else if($columnName=="ShowAssignForm"){$oResult= "<td class=oMain >";$oResult.="<select name=\"pg_".$myArray['id']."\">";$oResult.="<option>NONE OF THE PAGES</option>";foreach($arrFrmPages as $pg){list($lng,$page)=explode("_",$pg);$oResult.="<option value=\"".$pg."\" ".($myArray['page']==urldecode($pg)?"selected":"").">".urldecode($page)." [".strtoupper($lng)."] </option>";}$oResult.="</select>";$oResult.= "</td>";return $oResult;}/* END create products links */return "";}

function generateBackLink($pageAction){global $category,$evLinkActions,$evLinkTexts,$GO_BACK_TO;echo "<br>";echo "<table width=950><tr><td class=basictext width=23>";echo "<a href='index.php?category=".$category."&action=".$pageAction."'><img src='images/cancel.gif' border=0 width=21 height=20 alt='go back to page'></a>";echo "</td><td class=basictext><a href='index.php?category=".$category."&action=".$pageAction."' >$GO_BACK_TO \"".$evLinkTexts[array_search($pageAction,$evLinkActions,false)]."\"</a></td></tr></table>";}

function FormatDate($x){global $PHP_DATE_FORMAT;return date($PHP_DATE_FORMAT, $x);}


function FormatDate_Short($x){global $PHP_DATE_FORMAT;return date($PHP_DATE_FORMAT, $x);}


function CreateLink_Note( $strLink, $strTitle){
global $user;
global $USE_ABSOLUTE_URLS,$BLOG_DOMAIN,$BLOG_URL_FORMAT;
if($BLOG_URL_FORMAT == 1)
{$strSEPage=getSePage($strTitle);
return "http://".$user.".".$BLOG_DOMAIN."/".$strLink."/".$strSEPage;
}
else
{
	if($strLink == "contact")
	{
		return "http://www.".$BLOG_DOMAIN."/site.php?user=".$user."&contact=1";
	}
	else
	{
		$arrLinkItems = explode("/",$strLink);
		if(sizeof($arrLinkItems) == 2)
		{
			if($arrLinkItems[0]=="photo_id"||$arrLinkItems[0]=="category"||$arrLinkItems[0]=="note")
			{
				$strSEPage=getSePage($strTitle);
				return "http://www.".$BLOG_DOMAIN."/".$user."/".$strLink."/".$strSEPage;
			}
			else
			{
				return ($USE_ABSOLUTE_URLS?"http://www.".$BLOG_DOMAIN."/":"")."site.php?user=".$user."&".$arrLinkItems[0]."=".$arrLinkItems[1];
			}
		}
elseif(sizeof($arrLinkItems) == 4){return ($USE_ABSOLUTE_URLS?"http://www.".$BLOG_DOMAIN."/":"")."site.php?user=".$user."&".$arrLinkItems[0]."=".$arrLinkItems[1]."&".$arrLinkItems[2]."=".$arrLinkItems[3];}}

}

}

function limit_text($strText, $strLink)
{if(strlen($strText) < 500)
{return $strText;}
else{$strResult = substr($strText, 0, 500);
$strRest=substr($strText, 500, strlen($strText)-500);
if(strstr($strRest,'>')) {$stopSym='>';}else {$stopSym='.';}
for($i=500;$i<strlen($strText);$i++)
{if($strText[$i] != $stopSym){
$strResult = $strResult.$strText[$i];
}else{break;}}$strResult .= "<a href=\"".$strLink."\" style=\"text-decoration:none\">...</a>";
return $strResult;}}

function GetExtensionFromType($type)
{
	$result = "jpg";
	
	global $image_types;
	
	foreach($image_types as $image_type)
	{
		if($image_type[0]==$type||$image_type[1]==$type)
		{
			$result = $image_type[1];
			break;
		}
	}
	return $result;
}

function ShowImage($strImage,$user="" , $type = "", $width="", $height="", $path = "")
{
	global $image_types,$USE_GD,$USE_ABSOLUTE_URLS,$BLOG_DOMAIN,$IMAGES_IN_DB,$AuthUserName;
	$user=strtolower($user);
	$result = "";
	
	if(!$IMAGES_IN_DB)
	{
					
		if($USE_GD&&$width!="")
		{
			if(file_exists("uploaded_images/". $user. "/thumb_" . $strImage .".jpg"))
			{
				$str_image_url = "uploaded_images/". $user. "/thumb_" . $strImage .".jpg";
			}
			else
			{
				$str_image_url = "thumbnail.php?id=" . $strImage .($width!=""?"&w=".$width:"").($height!=""?"&h=".$height:"").($user!=""?"&user=".$user:"");
			}
		}
		else
		{
			$str_image_url = "";
			
			if($type == "")
			{
				foreach($image_types as $image_type)
				{
					if(file_exists("uploaded_images/". $user. "/" . $strImage .".". $image_type[1]))
					{
						$str_image_url = "uploaded_images/". $user. "/" . $strImage .".". $image_type[1];
						
						break;
					}
					
				}
				
				if($str_image_url == "" )
				{
					$str_image_url = "image.php?id=" . $strImage.($user!=""?"&user=".$user:"");
				}
			}
			else
			{
				$ext = GetExtensionFromType($type);
				if(file_exists("uploaded_images/". $user. "/" . $strImage .".". $ext))
				{
					$str_image_url = "uploaded_images/". $user. "/" . $strImage .".". $ext;
					
				}
			
			}
			
		
		}
		
		
		$result = "<img src=\"".($USE_ABSOLUTE_URLS?"http://www.".$BLOG_DOMAIN."/":$path).$str_image_url."\" ".($width!=""?"width=\"".$width."\"":"")." ".($height!=""?"height=\"".$height."\"":"")." border=\"0\">";	
	
	}
	else
	{
		if($USE_GD&&$width!="")
		{
		
			$result = "<img src=\"".($USE_ABSOLUTE_URLS?"http://www.".$BLOG_DOMAIN."/":"")."thumbnail.php?id=".$strImage.($width!=""?"&w=".$width:"").($user!=""?"&user=".$user:"")."\" ".($width!=""?"width=\"".$width."\"":"")." ".($height!=""?"height=\"".$height."\"":"")." border=\"0\">";	
		}
		else
		{
			$result = "<img src=\"".($USE_ABSOLUTE_URLS?"http://www.".$BLOG_DOMAIN."/":"")."image.php?id=".$strImage.($width!=""?"&w=".$width:"").($user!=""?"&user=".$user:"")."\" ".($width!=""?"width=\"".$width."\"":"")." ".($height!=""?"height=\"".$height."\"":"")." border=\"0\">";	
		
		}
	
	}
	return $result;	
}

function ImageURL($strImage,$type = "", $path="",$user="")
{
global $image_types,$USE_ABSOLUTE_URLS,$BLOG_DOMAIN,$IMAGES_IN_DB,$AuthUserName;

if(!$IMAGES_IN_DB)
{
	if(isset($AuthUserName)&&$AuthUserName!=""&&$AuthUserName!="administrator")
	{
		return ($USE_ABSOLUTE_URLS?"http://www.".$BLOG_DOMAIN."/":$path)."uploaded_images/".$AuthUserName."/".$strImage.".".GetExtensionFromType($type);
	}
	else
	{
		if($type==""&&$user!="")
		{
			foreach($image_types as $image_type)
			{
				if(file_exists("uploaded_images/".$user."/".$strImage.".".$image_type[1]))
				{
					return "uploaded_images/".$user."/".$strImage.".".$image_type[1];
				}
			}
		}
		else
		{
			return ($USE_ABSOLUTE_URLS?"http://www.".$BLOG_DOMAIN."/":$path)."uploaded_images/".($user!=""?$user."/":"").$strImage.".".GetExtensionFromType($type);
		}
	}
}
else
{
	return ($USE_ABSOLUTE_URLS?"http://www.".$BLOG_DOMAIN."/":$path)."image.php?id=".$strImage;
}
	
}

function ThumbnailURL($strImage, $width = "", $height = "", $user = "")
{
global $USE_ABSOLUTE_URLS,$BLOG_DOMAIN,$USE_GD;
if($USE_ABSOLUTE_URLS)
{if($USE_GD)
{
return "http://www.".$BLOG_DOMAIN."/thumbnail.php?id=".$strImage;}
else{return "http://www.".$BLOG_DOMAIN."/image.php?id=".$strImage;}}
else{if($USE_GD){return "thumbnail.php?id=".$strImage;}
else{return "image.php?id=".$strImage;}}}

function CreateLink2($strLink){global $user,$BLOG_DOMAIN,$BLOG_URL_FORMAT;if($BLOG_URL_FORMAT == 1){return "http://".$user.".".$BLOG_DOMAIN."/".$strLink;}else{if($strLink == "contact"){return "http://www.".$BLOG_DOMAIN."/".$user."/contact";}else{$arrLinkItems = explode("/",$strLink);if(sizeof($arrLinkItems) == 2){return "http://www.".$BLOG_DOMAIN."/site.php?user=".$user."&".$arrLinkItems[0]."=".$arrLinkItems[1];}else if(sizeof($arrLinkItems) == 4){return "http://www.".$BLOG_DOMAIN."/site.php?user=".$user."&".$arrLinkItems[0]."=".$arrLinkItems[1]."&".$arrLinkItems[2]."=".$arrLinkItems[3];}}}}

 function GenerateLanguagesMenu_BLOGSADMIN($category,$action){global $lang;$strResult="";
 $tableLanguages=DataTable("languages","WHERE active=1");
 
 $bFirst=true;
 
 while($arrLanguages=mysql_fetch_array($tableLanguages))
 {if(aParameter(3)=="standart"){
 $strResult.="<a href=\"index.php?lng=".$arrLanguages["code"]."&category=".$category."&action=".$action."\"><img width=\"22\" height=\"14\" class=\"language-flag\" alt=\"\" src=\"../include/flags/".$arrLanguages["code"].".gif\"/></a>";}
 else
 {
	$strResult.="<a href=\"index.php?lng=".$arrLanguages["code"]."&category=".$category."&action=".$action."\" style='text-decoration:none'>";$arrCustomLink=explode("_",$arrLanguages["html"],2);
 
 if(aParameter(5)=="FALSE"&&strtolower(trim($arrLanguages["code"]))==$lang){}
 else{
 

 
 $strResult.="".$arrCustomLink[1]."";
 
 $bFirst=false;}$strResult.="</a>";}}
 
 return $strResult;
 
 }

  
 


function SQLInsertFile_BA($strInputFile){global $M_FILE_NOT_IMAGE,$DBHost,$DBUser,$DBPass,$DBName,$DBprefix,$AuthUserName;

$ir=rand(200,9999999999);

global $image_types;$iResult=0;global $IMAGES_IN_DB,$UPLOAD_DIR,$MAX_IMAGE_SIZE,$IMAGE_MAX_SIZE_EXCEEDED;if($IMAGES_IN_DB){$userfile = addslashes (fread (fopen ($_FILES[$strInputFile]["tmp_name"], "r"), filesize ($_FILES[$strInputFile]["tmp_name"])));$file_name = $_FILES[$strInputFile]["name"];$file_size = $_FILES[$strInputFile]["size"];$file_type = $_FILES[$strInputFile]["type"];if($file_size>0){if (GetImageType($file_type) != "") {$sql = "INSERT INTO ".$DBprefix."image (user,image_id,image_type, image, image_size, image_name, image_date) ";$sql.= "VALUES (";$sql.= "'".$AuthUserName."',$ir,'{$file_type}', '{$userfile}', '{$file_size}', '$file_name', NOW())";mysql_connect($DBHost,$DBUser,$DBPass);mysql_select_db($DBName);mysql_query($sql) or RegisterError("SQL_ERROR",$sql."<br>".mysql_error());
$iResult=mysql_insert_id();mysql_close();}else{
echo "<i>".$M_FILE_NOT_IMAGE."</i><br>";}}}else{$file_name = $_FILES[$strInputFile]["name"];$file_size = $_FILES[$strInputFile]["size"];$file_type = $_FILES[$strInputFile]["type"];$file_extension = GetImageType($file_type);

if($file_extension == ""){echo "<i>".$M_FILE_NOT_IMAGE."</i><br>";}else{

global $generate_random_file_id;

$uploadedFile = "../uploaded_images/" . $AuthUserName."/".$ir.".jpg";


if($file_size > $MAX_IMAGE_SIZE)
{echo "<b><font color=red>".$IMAGE_MAX_SIZE_EXCEEDED."</font></b>";}
else if (move_uploaded_file($_FILES[$strInputFile]['tmp_name'], $uploadedFile))
{$sql = "INSERT INTO ".$DBprefix."image (user,image_id,image_type, image, image_size, image_name, image_date) ";$sql.= "VALUES (";$sql.= "'".$AuthUserName."',$ir,'{$file_type}', '', '{$file_size}', '$file_name', NOW())";

mysql_connect($DBHost,$DBUser,$DBPass);mysql_select_db($DBName);mysql_query($sql) or RegisterError("SQL_ERROR",$sql."<br>".mysql_error());
$iResult=$ir;mysql_close();}else{echo " Error while uploading your file!";}}}

return $ir;}



function AddNewForm_BA($arrTexts,$arrNames,$arrTypes,$strSubmitText,$strTable,$strSuccessMessage){global $DBHost,$DBUser,$DBPass,$DBName,$DBprefix;global $category,$action,$MessageTDLength;global $SpecialProcessAddForm,$strSpecialHiddenFieldsToAdd,$jsValidation;global $arrExamples,$arrNames2,$arrValues2,$folder,$page;global $SelectWidth;if(sizeof($arrTexts)!=sizeof($arrNames)){echo "Length of Texts array != length of Names array";return -1;}if(sizeof($arrTexts)!=sizeof($arrTypes)){echo "Length of Texts array != length of Types array";return -1;}if(isset($SpecialProcessAddForm)){$arrValues=array();for($i=0;$i<sizeof($arrNames);$i++){$strName=$arrNames[$i];

if($arrTypes[$i]=="file"){global $isBlogFile;
if(isset($isBlogFile)){
if($_FILES[$strName]){
$iFileId=SQLInsertBlogFile($strName);array_push($arrValues,$iFileId);}}
else{
if($_FILES[$strName])
{$iFileId=SQLInsertFile_BA($strName);array_push($arrValues,$iFileId);}}}else{$tempValue =get_param($strName);$tempValue = str_replace("^","",$tempValue);array_push($arrValues,$tempValue);}}if(isset($arrNames2)){for($i=0;$i<sizeof($arrNames2);$i++){array_push($arrNames,$arrNames2[$i]);array_push($arrValues,$arrValues2[$i]);}}$iLId=0;if(sizeof($arrNames) == sizeof($arrValues)){$iLId=SQLInsert($strTable,$arrNames,$arrValues);}echo "<table width=100%>";echo "<tr><td class=basictext>";if($iLId==0){echo "<b>Error while inserting new data.</b>";}else{echo "<b>".$strSuccessMessage."</b>";}echo "</td></tr>";echo "</table><br>";}if(true){echo "<table width=100%>";echo "<form ".(isset($jsValidation)?"onsubmit='return $jsValidation(this)'":"")." action=index.php method=post ENCTYPE=\"multipart/form-data\">";echo "<input type=hidden name=category value=\"".$category."\">";if(isset($folder)&&isset($page)){echo "<input type=hidden name=folder value=\"".$folder."\">";
echo "<input type=hidden name=page value=\"".$page."\">";}

else{echo "<input type=hidden name=action value=\"".$action."\">";}echo "<input type=hidden name=SpecialProcessAddForm>";if(isset($strSpecialHiddenFieldsToAdd)){echo $strSpecialHiddenFieldsToAdd; }for($i=0;$i<sizeof($arrTexts);$i++){echo "<tr height=24>";echo "<td class=basictext valign=middle width=".(isset($MessageTDLength)?$MessageTDLength:"80").">".$arrTexts[$i]."</td>";echo "<td class=basictext valign=top>";if(strstr($arrTypes[$i],"combobox_table")){
$arrSplItems=explode("~",$arrTypes[$i]);if(sizeof($arrSplItems) == 4){list($strType,$strTableName,$strFieldValue,$strFieldName)=$arrSplItems;$oTable=DataTable($strTableName,"");}else{list($strType,$strTableName,$strFieldValue,$strFieldName, $strSplQuery)=$arrSplItems;$oTable=DataTable($strTableName, $strSplQuery);}echo "<select ".(isset($SelectWidth)?"style='width:".$SelectWidth."px'":"")." name=\"".$arrNames[$i]."\">";while($oRow=mysql_fetch_array($oTable)){if(trim($oRow[$strFieldName]) == ""){continue;}echo "<option value=\"".$oRow[$strFieldValue]."\">".$oRow[$strFieldName]."</option>";}echo "</select>";}else if(strstr($arrTypes[$i],"file")){$strSize=30;

echo "<input ".(isset($SelectWidth)?"style='width:".$SelectWidth."px'":"")." type=file name=\"".$arrNames[$i]."\" size=$strSize>";}else if(strstr($arrTypes[$i],"textbox")){list($strType,$strSize)=explode("_",$arrTypes[$i]);
echo "<input ".(isset($SelectWidth)?"style='width:".$SelectWidth."px'":"")." type=text name=\"".$arrNames[$i]."\" size=$strSize>";if(isset($arrExamples[$i])) echo $arrExamples[$i];}else if(strstr($arrTypes[$i],"password")){list($strType,$strSize)=explode("_",$arrTypes[$i]);
echo "<input ".(isset($SelectWidth)?"style='width:".$SelectWidth."px'":"")." type=password name=\"".$arrNames[$i]."\" size=$strSize>";}else if(strstr($arrTypes[$i],"textarea")){list($strType,$strCols,$strRows)=explode("_",$arrTypes[$i]);
echo "<textarea ".(isset($SelectWidth)?"style='width:".$SelectWidth."px'":"")." name=\"".$arrNames[$i]."\" id=\"".$arrNames[$i]."\" cols=$strCols rows=$strRows></textarea>";}else if(strstr($arrTypes[$i],"javascript~combobox")){echo "<select ".(isset($SelectWidth)?"style='width:".$SelectWidth."px'":"")." name=\"".$arrNames[$i]."\" onChange=javascript:SelectChanged(this)>";foreach(explode("_",$arrTypes[$i]) as $strOption){if($strOption=="javascript~combobox"){continue;}echo "<option>".str_replace("~"," ",$strOption)."</option>";}}else 
if(strstr($arrTypes[$i],"combobox_special")){if($arrNames[$i]=="type"){global $arr1;echo "<select name=\"type\">";for($i=1;$i<=4;$i++){ echo "<option value=\"".$i."\">".$arr1[$i.""]."</option>";}echo "</select>";}else
if($arrNames[$i]=="category_1"||$arrNames[$i]=="category_2"){echo "<select ".(isset($SelectWidth)?"style='width:".$SelectWidth."px'":"")." name=\"".$arrNames[$i]."\">";$oCatTable=DataTable("frontstore_category","");while($oCatRow=mysql_fetch_array($oCatTable)){echo "<option value=\"".$oCatRow["Marketing_Category_1"]."\">".$oCatRow["Marketing_Cat_EN"]."</option>";}echo "</select>";}}else if(strstr($arrTypes[$i],"combobox")){echo "<select ".(isset($SelectWidth)?"style='width:".$SelectWidth."px'":"")." name=\"".$arrNames[$i]."\">";foreach(explode("_",$arrTypes[$i]) as $strOption){if($strOption=="combobox"){continue;}$arrOptions = explode("^", $strOption);if(sizeof($arrOptions) > 1){echo "<option value=\"".$arrOptions[1]."\">".str_replace("~"," ",$arrOptions[0])."</option>";}else{echo "<option >".str_replace("~"," ",$strOption)."</option>";}}echo "</select>";}echo "</td>";echo "</tr>";}echo "</table>";echo "<br><table width=100%>";
echo "<tr><td><input class=adminButton type=submit value=\"".$strSubmitText."\"></td></tr>";echo "</form>";echo "</table>";}}

 function AddEditFormPlus($arrTexts,$arrEditFields,$arrMissedFields,$arrTypes,$strTableName,$strUniqueKey,$strCurrentUniqueKeyValue,$strSuccessMessage,$strSec){global $DBHost,$DBUser,$DBPass,$DBName,$DBprefix;global $category,$folder,$page,$action;global $SpecialProcessEditForm,$MessageTDLength,$SubmitButtonText;global $trimLines,$arrNames2,$arrValues2;global $SelectWidth,$strSpecialHiddenFieldsToAdd;if(sizeof($arrEditFields)!=sizeof($arrTypes)){echo "Length of Edit Fields array != length of Types array";return -1;}$oArray=DataArray($strTableName,"$strUniqueKey=$strCurrentUniqueKeyValue AND $strSec");if(!isset($oArray[$strUniqueKey])){DieError(1);}if(isset($SpecialProcessEditForm)){$arrValues=array();$arrEditNames=array();for($i=0;$i<sizeof($arrEditFields);$i++){$strName=$arrEditFields[$i];if(in_array($strName,$arrMissedFields)){continue;}if($arrTypes[$i]=="file"){$v_file = ("".$strName);global $$v_file;$tempValue = $$v_file;if(trim($tempValue)!=""){if(is_array($tempValue)&&trim($tempValue["name"])==""){}else{array_push($arrEditNames,$strName);if( $oArray[$strName]!=""){SQLDelete("image","image_id",array($oArray[$strName]));}$iFileId=SQLInsertFile($strName);array_push($arrValues,$iFileId);}}}else{array_push($arrEditNames,$strName);$tempValue=get_param($strName);$tempValue = str_replace("^","",$tempValue);array_push($arrValues,$tempValue);}}if(isset($arrNames2)){for($i=0;$i<sizeof($arrNames2);$i++){array_push($arrEditNames,$arrNames2[$i]);array_push($arrValues,$arrValues2[$i]);}}if(sizeof($arrValues) > 0 && sizeof($arrEditNames) > 0 && sizeof($arrValues) == sizeof($arrEditNames)){SQLUpdate($strTableName,$arrEditNames,$arrValues,"$strUniqueKey=$strCurrentUniqueKeyValue");}$oArray=DataArray($strTableName,"$strUniqueKey=$strCurrentUniqueKeyValue");}if(true){echo "<table width=100%>";echo "<form action=index.php method=post ENCTYPE=\"multipart/form-data\">";
 echo "<input type=hidden name=category value=\"".$category."\">";if(isset($strSpecialHiddenFieldsToAdd)){echo $strSpecialHiddenFieldsToAdd;}if(isset($folder)&&isset($page)){
 echo "<input type=hidden name=folder value=\"".$folder."\">";
 echo "<input type=hidden name=page value=\"".$page."\">";}else{
 echo "<input type=hidden name=action value=\"".$action."\">";}
 echo "<input type=hidden name=$strUniqueKey value=\"".$strCurrentUniqueKeyValue."\">";
 echo "<input type=hidden name=SpecialProcessEditForm>";if(isset($strSpecialHiddenFieldsToAdd)){echo $strSpecialHiddenFieldsToAdd;}for($i=0;$i<sizeof($arrTexts);$i++){echo "<tr height=24>";echo "<td class=basictext valign=middle width=".(isset($MessageTDLength)?$MessageTDLength:"80").">".(strpos(strtolower($arrTexts[$i]),"ouleur")||strpos(strtolower($arrEditFields[$i]),"olor")||strpos(strtolower($arrTexts[$i]),"olor")||strpos(strtolower($arrTexts[$i]),"&#1074;&#1103;&#1090;")?"<a href=\"javascript:ShowColorMenu('".$arrEditFields[$i]."')\">":"")."".$arrTexts[$i].":".(strpos(strtolower($arrTexts[$i]),"ouleur")||strpos(strtolower($arrTexts[$i]),"olor")?"</a>":"")."</td>";echo "<td class=basictext valign=middle>";if(in_array($arrEditFields[$i],$arrMissedFields)){echo "<b>".$oArray[$arrEditFields[$i]]."</b>";}else if(strstr($arrTypes[$i],"combobox_table")){$arrComboItems = explode("~",$arrTypes[$i]);if(sizeof($arrComboItems) == 4){list($strType,$strTableName,$strFieldValue,$strFieldName)=$arrComboItems;$oTable=DataTable($strTableName,"");}else{list($strType,$strTableName,$strFieldValue,$strFieldName,$strComboQuery)=$arrComboItems;$oTable=DataTable($strTableName,$strComboQuery);}echo "<select ".(isset($SelectWidth)?"style='width:".$SelectWidth."px'":"")." name=\"".$arrEditFields[$i]."\">";while($oRow=mysql_fetch_array($oTable)){echo "<option ".($oRow[$strFieldValue]==$oArray[$arrEditFields[$i]]?"selected":"")." value=\"".$oRow[$strFieldValue]."\">".$oRow[$strFieldName]."</option>";}echo "</select>";}else if(strstr($arrTypes[$i],"thumbnails")){$strVal="";if(isset($oArray[$arrEditFields[$i]])){$strVal=$oArray[$arrEditFields[$i]];}echo '<br><br><table summary="" border="0" > <tr> <td width=150 valign=top>
 <input type=radio name='.$arrEditFields[$i].' value=1 '.($strVal==1?"checked":"").'>Little (50px)<br><br><img src="images/format/50.jpg" width="50" height="38" alt="" border="0"></td> <td width=150 valign=top>
 <input type=radio name='.$arrEditFields[$i].' value=2 '.($strVal==2?"checked":"").'>Middle (75px)<br><br><img src="images/format/75.jpg" width="75" height="56" alt="" border="0"></td> <td width=150 valign=top>
 <input type=radio name='.$arrEditFields[$i].' value=3 '.($strVal==3?"checked":"").'>Big (115px)<br><br><img src="images/format/115.jpg" width="115" height="86" alt="" border="0"></td> </tr> </table>';}else if(strstr($arrTypes[$i],"country")){$strVal="";if(isset($oArray[$arrEditFields[$i]])){$strVal=$oArray[$arrEditFields[$i]];}$strCountryList ="N/A.Afghanistan.Algeria.Argentina.Australia.Austria.Azerbaijan.Belarus.Belgium.Bermuda.Bolivia.Brazil.Bulgaria.Burkina Faso.Cambodia.Canada.Chile.China.Colombia.Costa Rica.Croatia.Cuba.Czech Republic.Denmark.Egypt.El Salvador.Estonia.Fiji.Finland.France.France - Polynesia.Georgia.Germany.Guyana.Hong Kong.Ireland.Israel.Italy.Japan.Jordan.Kazakhstan.Kuwait.Liechtenstein.Lithuania.Luxemburg.Macao.Madagascar.Malaysia.Malta.Mauritius.Mexico.Mongolia.Morocco.Netherlands.New Zealand.Nicaragua.Nigeria.Norway.Panama.Paraguay.Peru.Philippines.Poland.Portugal.Puerto Rico.Republic of Korea.Romania.Russia.Senegal.Singapore.Slovenia.South Africa.Spain.Sudan.Sweden.Switzerland.Taiwan.Republic of China.Tunisia.United Arab Emirates.United Kingdom.United States of America.Uruguay.Venezuela.Vietnam.Zambia";echo "<select name=country ".(isset($SelectWidth)?"style='width:".$SelectWidth."px'":"").">";foreach(explode(".",$strCountryList) as $countryItem){$countryItem = trim($countryItem);if(trim($countryItem) == ""){continue;}echo "<option ".($countryItem==$strVal?"selected":"").">".$countryItem."</option>";}echo "</select>";}else if(strstr($arrTypes[$i],"file")){$strSize=30;
 echo "<input ".(isset($SelectWidth)?"style='width:".$SelectWidth."px'":"")." type=file name=\"".$arrEditFields[$i]."\" size=$strSize>";}else if(strstr($arrTypes[$i],"textbox")){list($strType,$strSize)=explode("_",$arrTypes[$i]);$strVal="";if(isset($oArray[$arrEditFields[$i]])){$strVal=$oArray[$arrEditFields[$i]];}
 echo "<input ".(isset($SelectWidth)?"style='width:".$SelectWidth."px'":"")." type=text value=\"".stripslashes($strVal)."\" name=\"".$arrEditFields[$i]."\" id=\"".$arrEditFields[$i]."\" size=$strSize>";}else if(strstr($arrTypes[$i],"textarea")){list($strType,$strCols,$strRows)=explode("_",$arrTypes[$i]);$strVal="";if(isset($oArray[$arrEditFields[$i]])){$strVal=$oArray[$arrEditFields[$i]];}if(isset($trimLines)){$arrTextLines = explode("\n", $strVal);$strVal = "";foreach($arrTextLines as $arrTextLine){if(trim($arrTextLine) == ""){continue;}$strVal .= trim($arrTextLine)."\n";}}
 echo "<textarea ".(isset($SelectWidth)?"style='width:".$SelectWidth."px'":"")." name=\"".$arrEditFields[$i]."\" id=\"".$arrEditFields[$i]."\" cols=$strCols rows=$strRows>".stripslashes($strVal)."</textarea>";}else 

if(strstr($arrTypes[$i],"javascript~combobox")){echo "<select ".(isset($SelectWidth)?"style='width:".$SelectWidth."px'":"")." name=\"".$arrNames[$i]."\" onChange=javascript:SelectChanged(this)>";foreach(explode("_",$arrTypes[$i]) as $strOption){if($strOption=="javascript~combobox"){continue;}echo "<option>".str_replace("~"," ",$strOption)."</option>";}}else if(strstr($arrTypes[$i],"combobox_special"))
{if($arrEditFields[$i]=="category_1"||$arrEditFields[$i]=="category_2"){$strVal="";if(isset($oArray[$arrEditFields[$i]])){$strVal=$oArray[$arrEditFields[$i]];}echo "<select ".(isset($SelectWidth)?"style='width:".$SelectWidth."px'":"")." name=\"".$arrEditFields[$i]."\">";$oCatTable=DataTable("frontstore_category","");while($oCatRow=mysql_fetch_array($oCatTable)){echo "<option ".($strVal==$oCatRow["Marketing_Category_1"]?"selected":"")." value=\"".$oCatRow["Marketing_Category_1"]."\">".$oCatRow["Marketing_Cat_EN"]."</option>";}echo "</select>";}else if($arrEditFields[$i]=="questionGroup"){echo "<select ".(isset($SelectWidth)?"style='width:".$SelectWidth."px'":"")." name=\"".$arrEditFields[$i]."\">";$oCatTable=DataTable_Query("SELECT DISTINCT questionGroup FROM ".$DBprefix."bo_itemquestions ");$strVal="";if(isset($oArray[$arrEditFields[$i]])){$strVal=$oArray[$arrEditFields[$i]];}while($oCatRow=mysql_fetch_array($oCatTable)){echo "<option ".($strVal==$oCatRow["questionGroup"]?"selected":"")." value=\"".$oCatRow["questionGroup"]."\">".$oCatRow["questionGroup"]."</option>";}echo "</select>";}else if($arrEditFields[$i]=="item_category"){echo "<select ".(isset($SelectWidth)?"style='width:".$SelectWidth."px'":"")." name=\"".$arrEditFields[$i]."\">";$oCatTable=DataTable_Query("SELECT DISTINCT ID,ops_item_category FROM ".$DBprefix."item_category ");$strVal="";if(isset($oArray[$arrEditFields[$i]])){$strVal=$oArray[$arrEditFields[$i]];}while($oCatRow=mysql_fetch_array($oCatTable)){echo "<option ".($strVal==$oCatRow["ID"]?"selected":"")." value=\"".$oCatRow["ID"]."\">".$oCatRow["ops_item_category"]."</option>";}echo "</select>";}}else if(strstr($arrTypes[$i],"combobox")){echo "<select ".(isset($SelectWidth)?"style='width:".$SelectWidth."px'":"")." name=\"".$arrEditFields[$i]."\">";foreach(explode("_",$arrTypes[$i]) as $strOption){if($strOption=="combobox"){continue;}$arrOptions = explode("^", $strOption);if(sizeof($arrOptions)>1){echo "<option value=\"".$arrOptions[1]."\"";if($arrOptions[1]==$oArray[$arrEditFields[$i]]){echo " selected";}echo">".$arrOptions[0]."</option>";}else{echo "<option ";if($strOption==$oArray[$arrEditFields[$i]]){echo " selected";}echo">".$strOption."</option>";}}echo "</select>";}echo "</td>";echo "</tr>";}echo "</table>";echo "<br><table width=100%>";echo "<tr><td >";if(isset($SubmitButtonText)&&$SubmitButtonText==""){}
else{echo "<input class=adminButton type=submit value=\"".(isset($SubmitButtonText)?$SubmitButtonText:"Save changes")."\"></td></tr>";}echo "</form>";echo "</table>";}}



function SQLInsertBlogFile($strInputFile)
{global $DBHost,$DBUser,$DBPass,$DBName,$DBprefix,$AuthUserName;
$ir=rand(200,9999999999);$iResult=0;
global $M_ERROR_WHILE_UPLOADING_FILE,$M_FILE_FORMAT_NOT_SUPPORTED,$IMAGES_IN_DB,$UPLOAD_DIR_FILES,$MAX_FILE_SIZE,$FILE_MAX_SIZE_EXCEEDED;
if($IMAGES_IN_DB){$userfile = addslashes (fread (fopen ($_FILES[$strInputFile]["tmp_name"], "r"), filesize ($_FILES[$strInputFile]["tmp_name"])));$file_name = $_FILES[$strInputFile]["name"];$file_size = $_FILES[$strInputFile]["size"];$file_type = $_FILES[$strInputFile]["type"];$file_extension = GetFileType($file_type);if($file_size > $MAX_FILE_SIZE){echo "<b><font color=red>".$FILE_MAX_SIZE_EXCEEDED."</font></b>";}else if($file_extension == ""){echo "<b><font color=red>This file format is not supported!</font></b>";}else if($file_size>0){

$sql = "INSERT INTO ".$DBprefix."blog_files (user,file_id,file_type, content, file_size, file_name, file_date) ";$sql.= "VALUES (";$sql.= "'".$AuthUserName."',$ir,'{$file_type}', '{$userfile}', '{$file_size}', '$file_name', NOW())";mysql_connect($DBHost,$DBUser,$DBPass);mysql_select_db($DBName);mysql_query($sql) or RegisterError("SQL_ERROR",$sql."<br>".mysql_error());$iResult=mysql_insert_id();mysql_close();}}

else{

global $UPLOAD_DIR_FILES;
$file_name = $_FILES[$strInputFile]["name"];
$file_size = $_FILES[$strInputFile]["size"];
$file_type = $_FILES[$strInputFile]["type"];
$file_extension = GetFileType($file_type);
if($file_extension == ""){
echo "<b>".$M_FILE_FORMAT_NOT_SUPPORTED."</b><br>";}else
{$uploadedFile = "../uploaded_files/" .$AuthUserName ."/" . $ir.".".$file_extension;


if($file_size > $MAX_FILE_SIZE){echo "<b>".$FILE_MAX_SIZE_EXCEEDED."</b><br>";}
else 
if(move_uploaded_file($_FILES[$strInputFile]['tmp_name'], $uploadedFile))
{

$sql = "INSERT INTO ".$DBprefix."blog_files (user,file_id,file_type, content, file_size, file_name, file_date) ";
$sql.= "VALUES (";$sql.= "'".$AuthUserName."',$ir,'{$file_type}', '', '{$file_size}', '$file_name', NOW())";
mysql_connect($DBHost,$DBUser,$DBPass);mysql_select_db($DBName);mysql_query($sql) or RegisterError("SQL_ERROR",$sql."<br>".mysql_error());$iResult=mysql_insert_id();
mysql_close();}
else{echo $M_ERROR_WHILE_UPLOADING_FILE;}}}return $ir;}


function GetImageType($file_type){global $image_types;foreach($image_types as $image_type){if($image_type[0] == $file_type){return $image_type[1];}}return "";}

function GetFileType($file_type){global $file_types;foreach($file_types as $c_file_type){if($c_file_type[0] == $file_type){return $c_file_type[1];}}return "";}

function SQLDeletePlus($strTable,$Key,$arrIDs){global $DBHost,$DBUser,$DBPass,$DBName,$DBprefix;global $AuthUserName;$strList="";$num = count ($arrIDs);for ($i = 0; $i < $num; $i++) {$strList.=$arrIDs[$i].","; }$strList=substr($strList,0,(strlen($strList)-1));mysql_connect($DBHost,$DBUser,$DBPass);mysql_select_db($DBName);$strQuery="delete from $DBprefix".$strTable." WHERE $Key in ($strList) AND user='".$AuthUserName."' ";if($strTable == "image"){$arrImageIds = explode(",",$strList);foreach($arrImageIds as $arrImageId){UnlinkPicture($arrImageId);}}mysql_query($strQuery) or RegisterError("SQL_ERROR",$strQuery."<br>".mysql_error());mysql_close();}

function OverQuota(){global $lArray;$arrUserPackage = DataArray("blog_packages","id=".$lArray["plan"]);$fSpace = SpaceOccupied();if($fSpace > $arrUserPackage["space"]){return true;}else{return false;}}

function SpaceOccupied()
{
	global $AuthUserName;
	$iNotesKB = 0;
	$iCommentsKB = 0;
	$iImagesKB = 0;
	$iFilesKB = 0;
	$tableNotes = DataTable("notes","WHERE user='".$AuthUserName."' ");
	
	while($tableNote = mysql_fetch_array($tableNotes))
	{$iNotesKB += strlen($tableNote["html"]);}
	
	$tableComments = DataTable("comments","WHERE user='".$AuthUserName."' ");
	
	while($tableComment = mysql_fetch_array($tableComments))
	{$iCommentsKB += strlen($tableComment["html"]);}
	
	$tableImages = DataTable("image","WHERE user='".$AuthUserName."' ");
	
	while($tableImage = mysql_fetch_array($tableImages)){$iImagesKB += $tableImage["image_size"];}
	
	$tableFiles = DataTable("blog_files","WHERE user='".$AuthUserName."' ");
	
	while($tableImage = mysql_fetch_array($tableFiles)){
	
	$iFilesKB += $tableImage["file_size"];}$fSpace = round(($iNotesKB+$iCommentsKB+$iImagesKB+$iFilesKB)/1024,2);
	
	return $fSpace;} 

function CreateLink($strLink){global $user,$BLOG_DOMAIN;if($strLink == "index.php"){return "http://www.".$BLOG_DOMAIN."/site.php?user=".$user;}$strLink = str_replace("index.php?","http://www.".$BLOG_DOMAIN."/site.php?user=".$user."&",$strLink);return $strLink;}


function AddEditForm_BA($arrTexts,$arrEditFields,$arrMissedFields,$arrTypes,$strTableName,$strUniqueKey,$strCurrentUniqueKeyValue,$strSuccessMessage){global $DBHost,$DBUser,$DBPass,$DBName,$DBprefix;global $category,$folder,$page,$action;global $SpecialProcessEditForm,$MessageTDLength,$SubmitButtonText;global $trimLines,$arrNames2,$arrValues2;global $SelectWidth,$strSpecialHiddenFieldsToAdd;if(sizeof($arrEditFields)!=sizeof($arrTypes)){echo "Length of Edit Fields array != length of Types array";return -1;}$oArray=DataArray($strTableName,"$strUniqueKey=$strCurrentUniqueKeyValue");if(isset($SpecialProcessEditForm)){$arrValues=array();$arrEditNames=array();for($i=0;$i<sizeof($arrEditFields);$i++){$strName=$arrEditFields[$i];if(in_array($strName,$arrMissedFields)){continue;}

if($arrTypes[$i]=="file")
{$v_file = ("".$strName);global $$v_file;$tempValue = $$v_file;
if(is_array($tempValue)&&trim($tempValue["name"])=="")
{}else{array_push($arrEditNames,$strName);if( $oArray[$strName]!=""){
global $IMAGES_IN_DB,$UPLOAD_DIR;if(!$IMAGES_IN_DB){global $image_types; foreach($image_types as $image_type){
if(file_exists("../uploaded_images/".$oArray[$strName].$image_type[1])){unlink("../uploaded_images/".$oArray[$strName].$image_type[1]);}}}SQLDelete("image","image_id",array($oArray[$strName]));}

$iFileId=SQLInsertFile_BA($strName);array_push($arrValues,$iFileId);
}}else{array_push($arrEditNames,$strName);$tempValue=get_param($strName);;$tempValue = str_replace("^","",$tempValue);array_push($arrValues,$tempValue);}}if(isset($arrNames2)){for($i=0;$i<sizeof($arrNames2);$i++){array_push($arrEditNames,$arrNames2[$i]);array_push($arrValues,$arrValues2[$i]);}}if(sizeof($arrValues) > 0 && sizeof($arrEditNames) > 0 && sizeof($arrValues) == sizeof($arrEditNames)){SQLUpdate($strTableName,$arrEditNames,$arrValues,"$strUniqueKey=$strCurrentUniqueKeyValue");}$oArray=DataArray($strTableName,"$strUniqueKey=$strCurrentUniqueKeyValue");}if(true){echo "<table width=100%>";echo "<form action=index.php method=post ENCTYPE=\"multipart/form-data\">";
echo "<input type=hidden name=category value=\"".$category."\">";if(isset($strSpecialHiddenFieldsToAdd)){echo $strSpecialHiddenFieldsToAdd;}if(isset($folder)&&isset($page)){
echo "<input type=hidden name=folder value=\"".$folder."\">";
echo "<input type=hidden name=page value=\"".$page."\">";}
else{echo "<input type=hidden name=action value=\"".$action."\">";}
echo "<input type=hidden name=".$strUniqueKey." value=\"".$strCurrentUniqueKeyValue."\">";
echo "<input type=hidden name=SpecialProcessEditForm>";

if(isset($strSpecialHiddenFieldsToAdd)){echo $strSpecialHiddenFieldsToAdd;}


for($i=0;$i<sizeof($arrTexts);$i++){

echo "<tr height=24>";echo "<td class=basictext valign=middle width=".(isset($MessageTDLength)?$MessageTDLength:"80").">".(strpos(strtolower($arrTexts[$i]),"ouleur")||strpos(strtolower($arrEditFields[$i]),"olor")||strpos(strtolower($arrTexts[$i]),"olor")||strpos(strtolower($arrTexts[$i]),"&#1074;&#1103;&#1090;")?"<a href=\"javascript:ShowColorMenu('".$arrEditFields[$i]."')\">":"")."".$arrTexts[$i].":".(strpos(strtolower($arrTexts[$i]),"ouleur")||strpos(strtolower($arrTexts[$i]),"olor")?"</a>":"")."</td>";echo "<td class=basictext valign=middle>";
if(in_array($arrEditFields[$i],$arrMissedFields))
{if(strstr($arrTypes[$i],"combobox_"))
{$strList = str_replace("combobox_","",$arrTypes[$i]);
$arrItems = explode("_",$strList);


foreach($arrItems as $strItem)
{$arrItems2 = explode("^",$strItem);
if(sizeof($arrItems2) == 2)
{if($oArray[$arrEditFields[$i]] == $arrItems2[1])
{echo "<b>".$arrItems2[0]."</b>";}}else
{if($oArray[$arrEditFields[$i]] == $arrItems2[0])
{echo "<b>".$arrItems2[0]."</b>";		
}}}}else{echo "<b>".$oArray[$arrEditFields[$i]]."</b>";}
}else

 if(strstr($arrTypes[$i],"combobox_table")){$arrComboItems = explode("~",$arrTypes[$i]);if(sizeof($arrComboItems) == 4){list($strType,$strTableName,$strFieldValue,$strFieldName)=$arrComboItems;$oTable=DataTable($strTableName,"");}else{list($strType,$strTableName,$strFieldValue,$strFieldName,$strComboQuery)=$arrComboItems;$oTable=DataTable($strTableName,$strComboQuery);}echo "<select ".(isset($SelectWidth)?"style='width:".$SelectWidth."px'":"")." name=\"".$arrEditFields[$i]."\">";while($oRow=mysql_fetch_array($oTable)){echo "<option ".($oRow[$strFieldValue]==$oArray[$arrEditFields[$i]]?"selected":"")." value=\"".$oRow[$strFieldValue]."\">".$oRow[$strFieldName]."</option>";}echo "</select>";}else if(strstr($arrTypes[$i],"thumbnails")){$strVal="";if(isset($oArray[$arrEditFields[$i]])){$strVal=$oArray[$arrEditFields[$i]];}echo '<br><br><table summary="" border="0" > <tr> <td width=150 valign=top>
<input type=radio name='.$arrEditFields[$i].' value=1 '.($strVal==1?"checked":"").'>Little (50px)<br><br><img src="images/format/50.jpg" width="50" height="38" alt="" border="0"></td> <td width=150 valign=top>
<input type=radio name='.$arrEditFields[$i].' value=2 '.($strVal==2?"checked":"").'>Middle (75px)<br><br><img src="images/format/75.jpg" width="75" height="56" alt="" border="0"></td> <td width=150 valign=top>
<input type=radio name='.$arrEditFields[$i].' value=3 '.($strVal==3?"checked":"").'>Big (115px)<br><br><img src="images/format/115.jpg" width="115" height="86" alt="" border="0"></td> </tr> </table>';}

else

 if(strstr($arrTypes[$i],"country")){$strVal="";if(isset($oArray[$arrEditFields[$i]])){$strVal=$oArray[$arrEditFields[$i]];}$strCountryList ="N/A.Afghanistan.Algeria.Argentina.Australia.Austria.Azerbaijan.Belarus.Belgium.Bermuda.Bolivia.Brazil.Bulgaria.Burkina Faso.Cambodia.Canada.Chile.China.Colombia.Costa Rica.Croatia.Cuba.Czech Republic.Denmark.Egypt.El Salvador.Estonia.Fiji.Finland.France.France - Polynesia.Georgia.Germany.Guyana.Hong Kong.Ireland.Israel.Italy.Japan.Jordan.Kazakhstan.Kuwait.Liechtenstein.Lithuania.Luxemburg.Macao.Madagascar.Malaysia.Malta.Mauritius.Mexico.Mongolia.Morocco.Netherlands.New Zealand.Nicaragua.Nigeria.Norway.Panama.Paraguay.Peru.Philippines.Poland.Portugal.Puerto Rico.Republic of Korea.Romania.Russia.Senegal.Singapore.Slovenia.South Africa.Spain.Sudan.Sweden.Switzerland.Taiwan.Republic of China.Tunisia.United Arab Emirates.United Kingdom.United States of America.Uruguay.Venezuela.Vietnam.Zambia";echo "<select name=country ".(isset($SelectWidth)?"style='width:".$SelectWidth."px'":"").">";foreach(explode(".",$strCountryList) as $countryItem){$countryItem = trim($countryItem);if(trim($countryItem) == ""){continue;}echo "<option ".($countryItem==$strVal?"selected":"").">".$countryItem."</option>";}echo "</select>";}else if(strstr($arrTypes[$i],"file")){$strSize=30;
echo "<input type=file name=\"".$arrEditFields[$i]."\" size=$strSize ".(isset($SelectWidth)?"style='width:".$SelectWidth."px'":"").">";}else if(strstr($arrTypes[$i],"textbox")){list($strType,$strSize)=explode("_",$arrTypes[$i]);$strVal="";if(isset($oArray[$arrEditFields[$i]])){$strVal=$oArray[$arrEditFields[$i]];}
echo "<input type=text ".(isset($SelectWidth)?"style='width:".$SelectWidth."px'":"")." value=\"".stripslashes($strVal)."\" name=\"".$arrEditFields[$i]."\" id=\"".$arrEditFields[$i]."\" size=$strSize>";}else if(strstr($arrTypes[$i],"textarea")){list($strType,$strCols,$strRows)=explode("_",$arrTypes[$i]);$strVal="";if(isset($oArray[$arrEditFields[$i]])){$strVal=$oArray[$arrEditFields[$i]];}if(isset($trimLines)){$arrTextLines = explode("\n", $strVal);$strVal = "";foreach($arrTextLines as $arrTextLine){if(trim($arrTextLine) == ""){continue;}$strVal .= trim($arrTextLine)."\n";}}
echo "<textarea ".(isset($SelectWidth)?"style='width:".$SelectWidth."px'":"")." name=\"".$arrEditFields[$i]."\" id=\"".$arrEditFields[$i]."\" cols=$strCols rows=$strRows>".stripslashes($strVal)."</textarea>";}else
if(strstr($arrTypes[$i],"combobox_external"))
{global $comboboxes;
$strVal=$oArray[$arrEditFields[$i]];
$strCode =$comboboxes[$arrEditFields[$i]];
$strCode = str_replace("value=".$strVal,"selected value=".$strVal,$strCode);
echo "<select name=\"".$arrEditFields[$i]."\" ".(isset($SelectWidth)?"style='width:".$SelectWidth."px'":"")." >";
echo $strCode;echo "</select>";}else
 if(strstr($arrTypes[$i],"javascript~combobox")){echo "<select ".(isset($SelectWidth)?"style='width:".$SelectWidth."px'":"")." name=\"".$arrNames[$i]."\" onChange=javascript:SelectChanged(this)>";foreach(explode("_",$arrTypes[$i]) as $strOption){if($strOption=="javascript~combobox"){continue;}echo "<option>".str_replace("~"," ",$strOption)."</option>";}}else if(strstr($arrTypes[$i],"combobox_special")){if($arrEditFields[$i]=="category_1"||$arrEditFields[$i]=="category_2"){$strVal="";if(isset($oArray[$arrEditFields[$i]])){$strVal=$oArray[$arrEditFields[$i]];}echo "<select ".(isset($SelectWidth)?"style='width:".$SelectWidth."px'":"")." name=\"".$arrEditFields[$i]."\">";$oCatTable=DataTable("frontstore_category","");while($oCatRow=mysql_fetch_array($oCatTable)){echo "<option ".($strVal==$oCatRow["Marketing_Category_1"]?"selected":"")." value=\"".$oCatRow["Marketing_Category_1"]."\">".$oCatRow["Marketing_Cat_EN"]."</option>";}echo "</select>";}else if($arrEditFields[$i]=="questionGroup"){echo "<select ".(isset($SelectWidth)?"style='width:".$SelectWidth."px'":"")." name=\"".$arrEditFields[$i]."\">";$oCatTable=DataTable_Query("SELECT DISTINCT questionGroup FROM ".$DBprefix."bo_itemquestions ");$strVal="";if(isset($oArray[$arrEditFields[$i]])){$strVal=$oArray[$arrEditFields[$i]];}while($oCatRow=mysql_fetch_array($oCatTable)){echo "<option ".($strVal==$oCatRow["questionGroup"]?"selected":"")." value=\"".$oCatRow["questionGroup"]."\">".$oCatRow["questionGroup"]."</option>";}echo "</select>";}else if($arrEditFields[$i]=="item_category"){echo "<select ".(isset($SelectWidth)?"style='width:".$SelectWidth."px'":"")." name=\"".$arrEditFields[$i]."\">";$oCatTable=DataTable_Query("SELECT DISTINCT ID,ops_item_category FROM ".$DBprefix."item_category ");$strVal="";if(isset($oArray[$arrEditFields[$i]])){$strVal=$oArray[$arrEditFields[$i]];}while($oCatRow=mysql_fetch_array($oCatTable)){echo "<option ".($strVal==$oCatRow["ID"]?"selected":"")." value=\"".$oCatRow["ID"]."\">".$oCatRow["ops_item_category"]."</option>";}echo "</select>";}}else if(strstr($arrTypes[$i],"combobox")){echo "<select ".(isset($SelectWidth)?"style='width:".$SelectWidth."px'":"")." name=\"".$arrEditFields[$i]."\">";foreach(explode("_",$arrTypes[$i]) as $strOption){if($strOption=="combobox"){continue;}$arrOptions = explode("^", $strOption);if(sizeof($arrOptions)>1){echo "<option value=\"".$arrOptions[1]."\"";if($arrOptions[1]==$oArray[$arrEditFields[$i]]){echo " selected";}echo">".$arrOptions[0]."</option>";}else{echo "<option ";if($strOption==$oArray[$arrEditFields[$i]]){echo " selected";}echo">".$strOption."</option>";}}echo "</select>";}echo "</td>";echo "</tr>";}echo "</table>";echo "<br><table width=100%>";echo "<tr><td>";if(isset($SubmitButtonText)&&$SubmitButtonText==""){}
 else{echo "<input class=adminButton type=submit value=\"".(isset($SubmitButtonText)?$SubmitButtonText:"Save changes")."\"></td></tr>";}echo "</form>";echo "</table>";}}
 
 function format_str($strTitle)
{
		$strSEPage = "";
		$strTitle=strtolower(trim($strTitle));
		$arrSigns = array("~", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "+", "-", ",",".","/", "?", ":","<",">","[","]","{","}","|");
		$strTitle = str_replace($arrSigns, "", $strTitle);
		
		$arrWords = explode(" ",$strTitle);
		
		$iWCounter = 1;
		
		foreach($arrWords as $strWord)
		{
			if($strWord == "")
			{
				continue;
			}
			
			if($iWCounter == 7)
			{
				break;
			}
			
			if($iWCounter != 1)
			{
				$strSEPage .= "-";
			}
			
			$strSEPage .= $strWord;
			
			$iWCounter++;	
		}
		
		return $strSEPage;
}
?>