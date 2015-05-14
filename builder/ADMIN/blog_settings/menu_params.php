<?php
if(!isset($iKEY)||$iKEY!="AZ8007"){
	die("ACCESS DENIED");
}
?>


<table summary="" border="0" width="100%">
	<tr>
		<td width=42>
			<img src="images/icons<?php echo $DN;?>/settings.gif" border="0" width="41" height="41" alt="">
		</td>
		<td class=basictext>
			<b><?php echo $MODIFY_SETTINGS;?></b>	
		</td>
	</tr>
</table>

<?php

$SelectWidth = 300;

EditParams(
		"4,5,6,7",
		array("combobox_LEFT_CENTER_RIGHT","combobox_TRUE_FALSE","combobox_TRUE_FALSE","combobox_VERTICAL_HORIZONTAL"),
		" $SAUVEGARDER ",
		"<br><b>$LES_VALEURS_MODIFIEES_SUCCES.</b>"
	);
	
?>
<br>
<?php
generateBackLink("menu");
?>

