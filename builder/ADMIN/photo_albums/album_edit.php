<?php

$arrNames2=array("date");
$arrValues2=array(time());

AddEditForm
	(
	array($NOM,$DESCRIPTION),
	array("name","description"),
	array(),
	array("textbox_40","textarea_50_6"),
	"photo",
	"id",
	$id,
	$LES_VALEURS_MODIFIEES_SUCCES
	);
?>
<br><br>
<?php
generateBackLink("album");
?>

