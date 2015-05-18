<?php
if(!isset($iKEY)||$iKEY!="AZ8007"){
	die("ACCESS DENIED");
}
?>
<?php
if(!isset($SpecialProcessAddForm)){
?>
<TABLE BORDER="0" CELLPADDING="0" CELLSPACING="0" width=750>
	<TR>
		<td width=49><img src="images/icons<?php echo $DN;?>/write.gif" border="0" width="49" height="45" alt=""></td>
		<td class=basicText>
		<b><?php echo $AJOUTER_NOUVEL_UTILISATEUR;?></b>		
		
		</td>
	</tr>
</table>
<br>
<?php
}
else{

	$HISTORY=$USER_HAS_ADDED." <i>".$username."</i>".$A_NEW_USER_TO_BO;

}
?>
<script>
function ContainsSpecialSymbols(strInput){
	
	
	var reg = new RegExp("#|%|'");

	if (reg.test(strInput)){
		
		return true;
	}
	else{
		
		return false;
	}
  		
}

function ValidateAddNewUser(x){

	if(ContainsSpecialSymbols(x.username.value)){
	
		alert("<?php echo $NOM_UTILISATEUR_CARACTERES;?>!");
		return false;
	}
	
	if(x.username.value==""){
		alert("<?php echo $NOM_UTILISATEUR_VIDE;?>!");
		return false;
	}
	if(x.password.value==""){
		alert("<?php echo $MOT_DE_PASSE_VIDE;?>!");
		return false;
	}
	if(x.email.value==""){
		alert("<?php echo $CHAMP_EMAIL_VIDE;?>!");
		return false;
	}
	
	
	
	return true;
}

</script>

<?php

$jsValidation="ValidateAddNewUser";


$MessageTDLength=120;
/*
if(isset($password)){
	$password=md5($password);
}
*/

AddNewForm(
		array("<font class=hl_text>$NOM_DUTILISATEUR:</font>","<font class=hl_text>$MOT_DE_PASSE:</a>","$PROFIL:","$TELEPHONE:","<font class=hl_text>$EMAIL:</a>"),
		
		array("username","password","type","telephone","email"),

		array("textbox_20","password_20","combobox_table~admin_users_type~type~type","textbox_20","textbox_20"),

		" $AJOUTER_UTILISATEUR ",
		"admin_users",
		"<br><font color=#ff6500>$NOUVEL_UTILISATEUR_SUCCES!</font><br><br><br>
		<a href=index.php?category=user_management&action=admin>View Users List</a>
		<br>"
	);
	
?>
<br><br>

<?php
if(isset($username)){

//$iDesignID=SQLInsert("design",array("name","user"),array("Default_".$username,$username));
	
	
}
else{
?>

<table summary="" border="0" width=750>
	<tr>
		<td class=basictext>
		<font class=hl_text>
		<i>
		(*)
		<?php echo $CHAMPS_OBLIGATOIRES;?>
		</i>
		</font>
		</td>
	</tr>
</table>

<?php
}
?>
<script>
var HTType="2";
var HTMessage="<?php echo $HT_ADD_USER;?>";
document.onmousedown = HTMouseDown;
</script>


