<?php
$strLinkTemplate = aParameter(333);

$HTML = "";

for($i=0;$i<count($oLinkTexts);$i++)
{
	if($i==(count($oLinkTexts)-1))
	{
		$arr_template_parts = explode("<!--sep-->", $strLinkTemplate);
		$strLinkTemplate = $arr_template_parts[0];
	}
	

	$HTML .= str_replace("[LINK_TEXT]",$oLinkTexts[$i],str_replace("[LINK_HREF]","index.php?category=".$oLinkActions[$i],$strLinkTemplate));
	

}
?>
