<?php
if(!isset($AuthUserName)||trim($AuthUserName)=="")
{
	die("");
}
ms_i($id);
?>

<?php

$arrNames2=array("date");
$arrValues2=array(time());


$MessageTDLength = 200;
$SubmitButtonText = $SAUVEGARDER;
AddEditForm
	(
	array($NOMBRE_DE_COL,
	$TAILLE_V_A,
	$TAILLE_V_AL,
	$SHOW_TITLE,
	$SHOW_DATE,
	$SHOW_LEGEND,
	$SHOW_PLACE,
	$SHOW_DESCRIPTION
	),
	array("home_thumbnails_columns","home_thumbnails_size", "thumbnails_size","show_title","show_date","show_legende","show_place","show_description"),
	array(),
	array("combobox_2_3_4_5_6_7_8","thumbnails","thumbnails","combobox_".$M_YES."_".$M_NO."","combobox_".$M_YES."_".$M_NO."","combobox_".$M_YES."_".$M_NO."","combobox_".$M_YES."_".$M_NO."","combobox_".$M_YES."_".$M_NO.""),
	"photo",
	"id",
	$id,
	$LES_VALEURS_MODIFIEES_SUCCES
	);
?>
<br><br>
<?php
generateBackLink("list");
?>



