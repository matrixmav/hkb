<?php
if(aParameter(13) == "YES")
{
?>
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
}
?>
<?php
if(isset($Delete))
{
		SQLDelete("linksmanager","id",$CheckList);
}

?>
<br>
<table summary="" border="0" width=750>
	<tr>
		<td>
		<b><?php echo $ADD_NEW_LINK;?></b>
		
		</td>
	</tr>
</table>

<br>
<?php
AddNewForm
(
		array($M_TITLE.":",$M_CATEGORY.":","URL:",$SHORT_DESCRIPTION.":",$LONG_DESCRIPTION.":",$M_RANK.":"),
		array("title","cat","url","short_description","long_description","rank"),
		array("textbox_50","combobox_table~lm_categories~id~name_en","textbox_50","textarea_37_3","textarea_37_6","textbox_3"),

		" $AJOUTER ",
		"linksmanager",
		"<font color=#313031>$NEW_LINK_ADDED</font><br>
		<br>
		
		"
);
?>
<br>

<table summary="" border="0" width=750>
	<tr>
		<td>
		<b><?php echo $LIST_AVAILABLE_LINKS;?></b>
		
		</td>
	</tr>
</table>

<?php

$arrTDSizes = array("50","150","150","150","*","50");

$arrDocCategories = array();
					
$tableCategories = DataTable("lm_categories","");

while($arrCategory = mysql_fetch_array($tableCategories))
{
$arrDocCategories[$arrCategory["id"]] = $arrCategory["name_en"];
}

RenderTable(
		"linksmanager",
		array("EditCar","title","url","dm_category","short_description","rank"),
		array($MODIFY,$M_TITLE,"URL",$M_CATEGORY,$SHORT_DESCRIPTION,$M_RANK),
		750,
		" ",
		$EFFACER,
		"id",
		"index.php?action=".$action."&category=".$category
);
?>

