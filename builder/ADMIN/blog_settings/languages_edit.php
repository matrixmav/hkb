<?php
if(!isset($iKEY)||$iKEY!="AZ8007"){
	die("ACCESS DENIED");
}

ms_i($id);
?>



<?php

$SubmitButtonText=" $SAUVEGARDER ";

AddEditForm(
		array("$LANGUAGE: ","$CODE: ","$ACTIVE: "),
		
		array("name","code","active"),
		array("name","code"),
		array("textbox_20","textbox_3","combobox_YES^1_NO^0"),
		"languages",
		"id",
		$id,
		"<font color=red>$VALEUR_MODFIEE_SUCCES!</font>"
	);

?>
<br><br>
<?php
generateBackLink("languages");
?>
