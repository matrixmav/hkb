<?php
if(!isset($iKEY)||$iKEY!="AZ8007"){
	die("ACCESS DENIED");
}
?>
<?php
$MessageTDLength=120;
$SubmitButtonText="$SAUVEGARDER";

AddEditForm
	(
	array("<font color=red>$NOM_DUTILISATEUR:</font>","$PROFIL:","$TELEPHONE:","<font color=red>$EMAIL:</a>"),
	array("username","type","telephone","email"),
	array("username"),
	array("textbox_20","combobox_table~admin_users_type~type~type","textbox_20","textbox_20"),
	"admin_users",
	"id",
	$id,
	"$INFORMATION_UTILISATEUR_MODIFIEE!"
	);
	
?>


<?php
generateBackLink("admin");
?>
