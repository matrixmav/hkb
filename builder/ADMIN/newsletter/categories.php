<script language="javascript" type="text/javascript" src="jscripts/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript">
	tinyMCE.init({
		mode : "textareas",
		theme : "simple",
		theme_advanced_buttons1_add_before : "save,newdocument,separator",
		theme_advanced_buttons1_add : "fontselect,fontsizeselect",
		theme_advanced_buttons2_add : "separator,insertdate,inserttime,preview,zoom,separator,forecolor,backcolor",
		theme_advanced_buttons2_add_before: "cut,copy,paste,pastetext,pasteword,separator,search,replace,separator",
		theme_advanced_buttons3_add_before : "tablecontrols,separator",
		theme_advanced_buttons3_add : "emotions,iespell,flash,advhr,separator,print,separator,ltr,rtl",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_path_location : "bottom",
		content_css : "include/example_full.css",
	    plugin_insertdate_dateFormat : "%Y-%m-%d",
	    plugin_insertdate_timeFormat : "%H:%M:%S",
		extended_valid_elements : "a[name|href|target|title|onclick],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]",
		external_link_list_url : "include/example_link_list.php",
		external_image_list_url : "include/image_list.php",
		flash_external_list_url : "include/example_flash_list.js",
		file_browser_callback : "fileBrowserCallBack"
	});

	function fileBrowserCallBack(field_name, url, type) 
	{

	}
</script>
<?php
if(isset($Delete))
{
		SQLDelete("newsletter_categories","id",$CheckList);
}

?>

<table summary="" border="0" width=750>
	<tr>
		<td>
		<b><?php echo str_replace("DM","Newsletter",$ADD_DM_CATEGORY);?></b>
		
		</td>
	</tr>
</table>
<br>
<?php
AddNewForm
(
		array($NOM.":",$DESCRIPTION.":"),
		array("name_en","description_en"),
		array("textbox_50","textarea_37_5"),

		" $AJOUTER ",
		"newsletter_categories",
		"<font color=#313031>".$NEW_CATEGORY_ADDED_SUCCESSFULLY."</font><br>
		<br>
		
		"
);
?>
<br>

<table summary="" border="0" width=750>
	<tr>
		<td>
		<b><?php echo str_replace("DM","Newsletter",$LIST_AVAILABLE_DM_CAT);?></b>
		
		</td>
	</tr>
</table>
<br>
<?php

$arrTDSizes = array("50","200","*");

RenderTable(
		"newsletter_categories",
		array("EditCar","name_en","description_en"),
		array($MODIFY,$NOM,$DESCRIPTION),
		700,
		" ",
		$EFFACER,
		"id",
		"index.php?action=".$action."&category=".$category
);
?>




