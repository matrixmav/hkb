<?php
if(isset($ProceedCustomForm))
{
	$strEmail ="";
	$arrValues=array();

	foreach ( $_POST as $key=>$value )
	{
		if(substr($key,0,9)=="namefield")
		{

			$strValueField=str_replace ("name","",$key);

			if(get_param($strValueField) != "")
			{
				$arrValues[$value]=get_param($strValueField);
				
				$strEmail .= $value.": ".get_param($strValueField)."\n";
			}
			else{
				$arrValues[$value]="";
			}

		}

	}

		SQLInsert("forms_data",array("form_id","data","date","ip"),array($form_id,serialize($arrValues),date("F j, Y, g:i a"),$_SERVER['REMOTE_ADDR']));

		if($email != "")
		{
			mail($email,"Form Data",$strEmail);
		}
	}


if(isset($ProceedChangeLanguage))
{
	$lang=strtolower($ProceedChangeLanguage);

	$LANG=$ProceedChangeLanguage;
}
else
if(isset($page))
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
else
if(!isset($lang))
{
	$arrLng=DataArray("languages","default_language=1");
	$lang=strtolower($arrLng["code"]);
	$LANG=strtoupper($arrLng["code"]);
}

$MenuHTML="";

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

function GetPLevel($pageId)
{
	
	$parentId = -1;
	
	$levelCounter = 0;
	
	$currentPageId = $pageId;
	
	do
	{
	
		$arrCurrentPages = GetPageArray($currentPageId);
		
		if(sizeof($arrCurrentPages) < 2)
		{
			break;
		}
		
		$parentId = $arrCurrentPages[1];
			
		if($parentId != 0)
		{
			$arrCurrentPages = GetPageArray($parentId);
			
			if(sizeof($arrCurrentPages) < 2)
			{
				break;
			}
		
			$currentPageId = $arrCurrentPages[0];
			
			$levelCounter++;
		}
			
	}
	while($parentId != 0);
	

	return $levelCounter;
}

if(true)
{
	$arrPages = array();
	if(trim($lang)=="") {$lang="en";$LANG="EN";}
	$dataTable = DataTable_Query("SELECT * FROM $DBprefix"."pages"." WHERE active_".$lang."=1 ORDER BY parent_id,id");
					
	while ($row = mysql_fetch_array($dataTable))
	{
		array_push($arrPages, array($row['id'], $row['parent_id'], (trim($row["link_".$lang])!=""?$row["link_".$lang]:$row["link_en"]), $row["custom_link_".$lang]));
	}
		
	$strDIV = "";
	$strTable = "";
	
	foreach($arrPages as $arrPage)
	{
		$arrSubPages = GetSubArray($arrPage[0]);
			
		if(sizeof($arrSubPages) > 0)
		{
			if(aParameter(2)=="custom")
			{
				$strDIV .= '<div id="z'.$arrPage[0].'" class="zh" style="margin-top:6px;margin-left:-22px">';
			}
			else
			{
				$strDIV .= '<div id="z'.$arrPage[0].'" class="zh" style="margin-top:3px;margin-left:-20px">';
			}
							
			$bFirst = true;
			foreach($arrSubPages as $arrSubPage)
			{
				$strLink=GenerateLink(aParameter(1111),aParameter(1112),$lang,$arrSubPage[2]);
			
				$strDIV .= '<div class="hsoff" '.(aParameter(317)!='none' && $bFirst?'style="border-width:1px 1px 1px 1px"':'').' onmouseover="javascript:zon(this,'.GetPLevel($arrSubPage[0]).',\'hson\',\'hsoff\',\'z'.$arrSubPage[0].'\','.($arrSubPage[0] == 0? 'z_BOTTOM':'z_RIGHT').');"> <a class="zls" href="'.$strLink.'"><font style="size:24px" color="'.aParameter(34).'" face="'.aParameter(30).'">'.$arrSubPage[2].'</font></a></div>';
				$bFirst = false;
			}
			
			$strDIV .= '</div>';
		}
		
	}
	
	
		$strTable .= '<table align="center" cellpadding="0" cellspacing="0" >';
		

		if(aParameter(321) == "HORIZONTAL")
		{
			$strTable .= "\n<tr>";
		}
		
		$bFirst = true;
		foreach($arrPages as $arrPage)
		{
				
			if($arrPage[1] == 0)
			{
			
				if(aParameter(321) == "VERTICAL")
				{
					$strTable .= "\n<tr>";
				}
			
				$strLink=GenerateLink(aParameter(1111),aParameter(1112),$lang,$arrPage[2]);
				
				$strText = "";
					
				if(aParameter(320) == 'YES' && trim($arrPage[3]) != "")
				{
									
					list($strElement, $strContent) = explode("_", $arrPage[3]);
				
					if($strElement == "image")
					{
						$arrImgItems = explode("^", $strContent);
					
						$strText = "<img src='".$arrImgItems[0]."' border=0>";
					}
					else
					{
						$strText = $strContent;
					}
				
				
				}
				else
				{
					$strText = $arrPage[2];
				}
				
				$strTable .= '<td><div class="hoff" '.(aParameter(316)!='none' && $bFirst?'style="border-width:1px 1px 1px 1px"':'').' onmouseover="javascript:zon(this,0,\'hon\',\'hoff\',\'z'.$arrPage[0].'\',z_BOTTOM);"><a class="zl" href="'.$strLink.'"><font style="size:'.aParameter(31).'" color="'.aParameter(33).'" face="'.aParameter(29).'">'.$strText.'</font></a></div></td>';
				
				
				$bFirst = false;
				
				if(aParameter(321) == "VERTICAL")
				{
					$strTable .= '</tr>';
				}
			}
			
			

		}
	
	
		if(aParameter(321) == "HORIZONTAL")
		{
			$strTable .= '</tr>';
		}
		
		$strTable .= '</table>';
		
		if(aParameter(2)=="custom")
		{
			$strTable="";
		}
				
		if(aParameter(321) == "HORIZONTAL")
		{
		$MenuHTML.="
		<script>
		var z_BOTTOM = \"bottom\";
		</script>
		";
		}
		else
		{
		$MenuHTML.="
		<script>
		var z_BOTTOM = \"right\";
		</script>
		";
		}

		
		$MenuHTML.='
		<script>var menu_type="'.(aParameter(2)=="custom"?"custom":"standard").'";</script>
		<script type="text/javascript" src="include/nmenu.js"></script>
		<style>
		.zh {position:absolute;visibility:hidden;z-index:1;}
		.zl {font-size:'.aParameter(31).';display:block;padding:'.aParameter(57).' '.aParameter(57).' '.aParameter(57).' '.aParameter(57).';text-decoration:'.(aParameter(38)=="underline"?"underline":"none").';font-style:'.aParameter(38).';'.(aParameter(38)=='bold'?'font-weight:800;':'').'}
		.zl:hover {font-size:'.aParameter(31).';text-decoration:'.(aParameter(40)=="underline"?"underline":"none").';font-style:'.aParameter(40).';'.(aParameter(40)=='bold'?'font-weight:800;':'').'}
		.zls {color:'.aParameter(34).' !important;font-size:'.aParameter(32).';display:block;padding:'.aParameter(58).' '.aParameter(58).' '.aParameter(58).' '.aParameter(58).';text-decoration:'.(aParameter(39)=="underline"?"underline":"none").';font-style:'.aParameter(39).';'.(aParameter(39)=='bold'?'font-weight:800;':'').'}
		.zls:hover {font-size:'.aParameter(32).';text-decoration:'.(aParameter(41)=="underline"?"underline":"none").';font-style:'.aParameter(41).';'.(aParameter(41)=='bold'?'font-weight:800;':'').'}';

		if(aParameter(321) == "HORIZONTAL")
		{
		$MenuHTML.='
		.hon  {text-transform: uppercase;width:'.aParameter(53).';height:'.aParameter(55).';margin:'.aParameter(310).';background:'.aParameter(314).';border-width:1px 1px 1px 0px;border-color:'.aParameter(318).';border-style:'.aParameter(316).';}
		.hoff {text-transform: uppercase;width:'.aParameter(53).';height:'.aParameter(55).';margin:'.aParameter(310).';background:'.aParameter(312).';border-width:1px 1px 1px 0px;border-color:'.aParameter(318).';border-style:'.aParameter(316).';}
		.hson  {text-align:left;width:'.aParameter(54).';height:'.aParameter(56).';margin:'.aParameter(311).';background:'.aParameter(315).';border-width:0px 1px 1px 1px;border-color:'.aParameter(319).';border-style:'.aParameter(317).';}
		.hsoff {text-align:left;width:'.aParameter(54).';height:'.aParameter(56).';margin:'.aParameter(311).';background:'.aParameter(313).';border-width:0px 1px 1px 1px;border-color:'.aParameter(319).';border-style:'.aParameter(317).';}';

		}
		else
		{
		$MenuHTML.='
		.hon  {width:'.aParameter(53).';height:'.aParameter(55).';margin:'.aParameter(310).';background:'.aParameter(314).';border-width:0px 1px 1px 1px;border-color:'.aParameter(318).';border-style:'.aParameter(316).';}
		.hoff {width:'.aParameter(53).';height:'.aParameter(55).';margin:'.aParameter(310).';background:'.aParameter(312).';border-width:0px 1px 1px 1px;border-color:'.aParameter(318).';border-style:'.aParameter(316).';}
		.hson  {text-align:left;width:'.aParameter(54).';height:'.aParameter(56).';margin:'.aParameter(311).';background:'.aParameter(315).';border-width:0px 1px 1px 1px;border-color:'.aParameter(319).';border-style:'.aParameter(317).';}
		.hsoff {text-align:left;width:'.aParameter(54).';height:'.aParameter(56).';margin:'.aParameter(311).';background:'.aParameter(313).';border-width:0px 1px 1px 1px;border-color:'.aParameter(319).';border-style:'.aParameter(317).';}';
		}

		$MenuHTML.='</style>
		' .$strTable.$strDIV;

}

if(aParameter(2)=="custom")
{
	$MenuHTML.=GenerateCustomMenu();
}



if($currentPage->templateID != 0)
{
	ms_i($currentPage->templateID);
	$templateArray=DataArray("templates","id=".$currentPage->templateID);
}
else
{
	if(file_exists("template.htm"))
	{
		$templateArray=array();
		$templateArray["html"] = file_get_contents('template.htm');
	}
	else
	{
		ms_i(aParameter(10));
		$templateArray=DataArray("templates","id=".aParameter(10));
	}
}

if($KEEP_USER_STATISTICS)
{
	SQLInsert
	(
		"statistics",
		array("date","host","referer","page","aff"),
		array(date("F j, Y, g:i a"),$_SERVER["REMOTE_ADDR"],(isset($_SERVER["HTTP_REFERER"])?$_SERVER["HTTP_REFERER"]:""),(isset($page)?$page:"home"),get_param("aff"))
	);
}
?>
