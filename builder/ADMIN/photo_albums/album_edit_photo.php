
<?php

$strSpecialHiddenFieldsToAdd = "<input type=hidden name=photo_id value=\"".$photo_id."\">";

AddEditForm
	(
	array($M_TITLE.":",$M_PLACE.":",$M_LEGEND.":",$DESCRIPTION.":",$DATE_MESSAGE.":"),
	array("title","place","legend","description","date"),
	array(),
	array("textbox_57","textbox_57","textbox_57","textarea_42_3","textbox_57"),
	"photo_images",
	"id",
	$photo_id,
	$LES_VALEURS_MODIFIEES_SUCCES
	);
?>


