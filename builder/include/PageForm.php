<?php	
if(isset($arrEncodings[strtoupper($LANG)]))
{
	$currentPage->templateHTML = str_replace("charset=iso-8859-1",$arrEncodings[strtoupper($LANG)],$currentPage->templateHTML);
}

$currentPage->arrElementsHTML["menu"] = $MenuHTML;
$currentPage->Transform();
	
if(isset($page))
{
	$frmArray=DataArray("forms","page='".urldecode($page)."'");

	if(isset($frmArray["code"]))
	{
		
		if(isset($ProceedCustomForm))
		{
			$strFormCode=$frmArray["message"];
		}
		else
		{
			$arrFormItems = explode("~~~~~", $frmArray["code"]);
			
			$hasValidation = false;
			
			if(sizeof($arrFormItems) == 2)
			{
				$hasValidation = true;
			}
			
			$strFormCode = "";
			
			if($hasValidation)
			{
				$strFormCode .= "
				
				<script>
				
				function ValidateForm(x)
				{
					".stripslashes($arrFormItems[0])."
					return true;
				}
				
				</script>
				
				";
			}
			
			$strFormCode.="<form action=\"index.php\" method=\"post\" ".($hasValidation?"onsubmit='return ValidateForm(this)'":"").">";
			$strFormCode.="<input name=\"form_id\" type=\"hidden\"  value=\"".$frmArray["id"]."\">";
			
			if(isset($originalPage))
			{
				$strFormCode.="<input type=\"hidden\" name=\"page\" value=\"".$originalPage."\">";
			}
			else
			{
				$strFormCode.="<input type=\"hidden\" name=\"page\" value=\"".$page."\">";
			}
			$strFormCode.="<input type=\"hidden\" name=\"email\" value=\"".$frmArray["email"]."\">";
			$strFormCode.="<input type=\"hidden\" name=\"ProceedCustomForm\">";
			
			if($hasValidation)
			{
				$strFormCode.=stripslashes($arrFormItems[1]);
			}
			else
			{
				$strFormCode.=stripslashes($frmArray["code"]);
			}
			$strFormCode.="<br><br><input type=\"submit\" value=\"".$frmArray["submit"]."\">";
			$strFormCode.="</form>";
		}
		
		$currentPage->pageHTML=str_replace("<wsa form/>",$strFormCode,$currentPage->pageHTML);
	}

}

/* BLOG STATISTICS
$strBlogStatistics = '<i>'.$CURRENTLY_ON.' '.strtoupper($BLOG_DOMAIN).': '.SQLCount("admin_users","WHERE username<>'administrator' AND blog_active=1").' '.$M_WEBLOGS.', 
'.SQLCount("notes","").' '.$M_NOTES.', '.SQLCount("comments","").' '.$M_COMMENTS.'</b>
</i>';
$currentPage->pageHTML=str_replace("<wsa blog_statistics/>", $strBlogStatistics, $currentPage->pageHTML);
*/


$arrTags = unserialize(aParameter(100));

if(is_array($arrTags))
{
	
	foreach($arrTags as $arrTag)
	{
		if(trim($arrTag[1]) != "none" && trim($arrTag[0]) != "" && trim($arrTag[1]) != "")
		{
			$HTML="";
			ob_start();
			include("extensions/".$arrTag[1]);
			if($HTML=="")
			{
				$HTML = ob_get_contents();
			}
			ob_end_clean();
			$currentPage->pageHTML=str_replace("<wsa ".$arrTag[0]."/>",$HTML,$currentPage->pageHTML);
		}
	}
	
}

if($USE_ABSOLUTE_URLS)
{
	$currentPage->pageHTML = str_replace("images/", "http://www.".$BLOG_DOMAIN."/images/", $currentPage->pageHTML);
	$currentPage->pageHTML = str_replace("include/flags/", "http://www.".$BLOG_DOMAIN."/include/flags/", $currentPage->pageHTML);
}
?>