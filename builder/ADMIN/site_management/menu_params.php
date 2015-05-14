
<?php
if(!isset($iKEY)||$iKEY!="AZ8007"){
	die("ACCESS DENIED");
}
?>


<?php

	EditParams
	(
		"8,9,333,334",
		array("combobox_TRUE_FALSE","combobox_VERTICAL_HORIZONTAL","textarea_70_9","combobox_TRUE_FALSE"),
		" $SAUVEGARDER ",
		"<br><b>$LES_VALEURS_MODIFIEES_SUCCES</b>"
	);
	
?>
<br>
<?php
generateBackLink("menu");
?>
