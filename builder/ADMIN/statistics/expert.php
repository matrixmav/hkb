<?php
	$arrPages = array();
	
	mysql_connect("$DBHost", "$DBUser", "$DBPass");
	mysql_select_db($DBName);

	$oRows=mysql_query("select * from $DBprefix"."pages"." order by parent_id,id");
	
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

//print_r($arrParents);

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

function WriteLevel($parent, $iLevel)
{

	global $arrPages,$lang;

	if(sizeof(GetSubArray($parent)) == 0)
	{
		$arrCurrentPageArray = GetPageArray($parent);
		
		if(isset($arrCurrentPageArray) && sizeof($arrCurrentPageArray))
		{
			echo "<table  cellpadding=0 cellspacing=0><tr><td >".GeneratePrefix($iLevel,$parent)."</td><td valign=bottom><table bgcolor=#efebef width=250  height=25 cellpadding=0 cellspacing=0 style='border-style:solid;border-color:#CECFCE;border-width:1px 1px 1px 1px;color:#666F74;'><tr><td background='images/pro_bg.jpg'  onmousedown=\"javascript:PageClicked(".$parent.",this,'".GenerateLink(aParameter(1111),aParameter(1112),$lang,$arrCurrentPageArray[2])."')\"> &nbsp;<b>".$arrCurrentPageArray[2]."</b>&nbsp;&nbsp;".$arrCurrentPageArray[3]."&nbsp;".$arrCurrentPageArray[4]."&nbsp;".$arrCurrentPageArray[5]." </td></tr></table></td></tr></table>";
		}
	}
	else
	{
		if($parent != 0)
		{
		
			$arrCurrentPageArray = GetPageArray($parent);
			
			echo "<table  cellpadding=0 cellspacing=0><tr><td>".GeneratePrefix($iLevel,$parent)."</td><td valign=bottom><table bgcolor=#efebef width=250 height=25 cellpadding=0 cellspacing=0 style='border-style:solid;border-color:#CECFCE;border-width:1px 1px 1px 1px;color:#666F74;'><tr><td background='images/pro_bg.jpg'  onmousedown=\"javascript:PageClicked(".$parent.",this,'".GenerateLink(aParameter(1111),aParameter(1112),$lang,$arrCurrentPageArray[2])."')\" > &nbsp;<b>".$arrCurrentPageArray[2]."</b>&nbsp;&nbsp;".$arrCurrentPageArray[3]."&nbsp;".$arrCurrentPageArray[4]."&nbsp;".$arrCurrentPageArray[5]." </td></tr></table></td></tr></table>";
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


