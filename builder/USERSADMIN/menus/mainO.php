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
		$strOutput .= str_replace("[LINK_TEXT]",stripslashes($oLinkTexts[$i]),str_replace("[LINK_HREF]","index.php?category=".$oLinkActions[$i],$strLinkTemplate2));
	}
	
}

$strOutput.='<script>var menu_type="'.(aParameter(2)=="custom"?"custom":"standard").'";</script>

<script>var menu_type="'.(aParameter(2)=="custom"?"custom":"standard").'";</script>
<script type="text/javascript" src="../include/nmenu.js"></script>
<style>
.zh {position:absolute;}</style>