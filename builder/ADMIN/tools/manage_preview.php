<?php
if(!isset($iKEY)||$iKEY!="AZ8007"){
	die("ACCESS DENIED");
}
ms_i($id);
?>


<table summary="" border="0" width=100%>
	<tr>
		<td width=32>
		<img src="images/icons<?php echo $DN;?>/settings.gif" width="41" height="41" alt="" border="0">
		</td>
		<td class=basictext><b>Manage the settings of the selected server side form</b></td>
	</tr>
</table>
<br>


<?php

$MessageTDLength = "200";

AddEditForm
(
	array($NOM.":",$DESCRIPTION.":",$SUBMIT_BTN.":",$MSG_DISPLAYED.":",$EMAIL_RECEIVE.":"),
	array("name","description","submit","message","email"),
	array(),
	array("textbox_53","textarea_40_4","textbox_53","textarea_40_4","textbox_53"),
	"forms",
	"id",
	$id,
	$LES_VALEURS_MODIFIEES_SUCCES
);
	
	$arrFrm=DataArray("forms","id=$id");
?>
<br><br>
<?php
/*
<!--
<table summary="" border="0" width=100%>
	<tr>
		<td class=basictext>
		<b><?php echo $SERVER_SIDE_FORM_PREVIEW;?> [id: <font color=red><?php echo $id;?></font>]</b>
		<br><br>
<form onsubmit="return false">

<?php echo stripslashes($arrFrm["code"]);?>

<br><br>
<input type=submit value="<?php echo $arrFrm["submit"];?>" >
</form>


</td>
	</tr>
</table>
-->
<script>
//HT("2","<?php echo $EDIT_HTML_WARNING;?>",800,420,0.5,20);
</script>

*/
?>
<?php
generateBackLink("manage");
?>

