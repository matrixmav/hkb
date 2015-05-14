<?php

$arrNames2=array("date");
$arrValues2=array(time());

AddEditForm
	(
	array($DESCRIPTION.":"),
	array("description"),
	array(),
	array("textarea_50_6"),
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

