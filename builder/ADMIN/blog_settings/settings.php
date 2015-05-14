<?php
if(!isset($iKEY)||$iKEY!="AZ8007"){
	die("ACCESS DENIED");
}
?>

<table summary="" border="0" width=750>
	<tr>
		<td width=32><img src="images/icons/calculator.gif" border="0" width="33" height="36" alt=""></td>
		<td class=basictext><b><?php echo $MODIFY_SETTINGS;?></b></td>
	</tr>
</table>
<br>

<table summary="" border="0" width=750>
	<tr>
		<td class=basictext>
		
		<?php
		EditParams(
		"71,72",
		array(
		"combobox_100_500_1000_5000_10000",
		"combobox_100_500_1000_5000_10000"
		
		),
		" $SAUVEGARDER ",
		"<b>$NOUVELLES_VALEURS_ENREGISTREES!</b>"
		);
	
	?>
		
		
		
		
		</td>
	</tr>
</table>