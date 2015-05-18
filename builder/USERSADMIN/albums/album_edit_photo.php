<?php
if(!isset($AuthUserName)||trim($AuthUserName)=="")
{
	die("");
}
?>

<script language="javascript" type="text/javascript" src="jscripts/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript">
tinyMCE.init({
	mode : "textareas",
	theme : "advanced",
	theme_advanced_buttons1 : "bold,italic,underline,separator,separator,strikethrough,justifyleft,justifycenter,justifyright, justifyfull,bullist,numlist,undo,redo,link,unlink",
	theme_advanced_buttons2 : "fontselect,fontsizeselect,forecolor",
	theme_advanced_buttons3 : "",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_path_location : "bottom",
	extended_valid_elements : "a[name|href|target|title|onclick],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]"
});
</script>
<br><br>

<?php

$strSpecialHiddenFieldsToAdd = "<input type=hidden name=photo_id value=\"".$photo_id."\">";

AddEditForm
	(
	array("$M_TITLE:",$DESCRIPTION.":","$LEGEND:","$M_PLACE:"),
	array("title","description","legend","place"),
	array(),
	array("textbox_57","textarea_42_8","textbox_57","textbox_57"),
	"photo_images",
	"id",
	$photo_id,
	$LES_VALEURS_MODIFIEES_SUCCES
	);
?>


