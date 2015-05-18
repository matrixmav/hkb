<table summary="" border="0" width="100%">
	<tr>
		<td width="38"><img src="images/icons2/settings.gif"  alt="" border="0"></td>
		<td><b><?php echo $M_CONFIGURATION_OPTIONS;?></b></td>
	</tr>
</table>	
	
<br>	
	<?php

$values_list="";
for($k=401;$k<=428;$k++)
{
	if($k!=401) $values_list.=",";
	$values_list .= $k;
}

$firstTDLength="260";
EditParams
(
	$values_list,
	array
		(
			"combobox_SUBFOLDERS (www.domain.com/user)_SUBDOMAINS (user.domain.com)",
			"combobox_YES_NO",
			"textbox_20",	
			"textbox_20",	
			"textbox_60",	
			"textbox_60",
			"combobox_YES_NO",
			"combobox_YES_NO",
			"textbox_20",
			"combobox_YES_NO",
			"combobox_YES_NO",
			"textbox_5",
			"textbox_5",
			"combobox_YES_NO",
			"combobox_YES_NO",
			"textbox_60",
			"textbox_20",
			"combobox_YES_NO",
			"combobox_YES_NO",
			"textbox_5",
			"textbox_5",
			"textbox_20",
			"textarea_60_4",
			"textarea_60_4",
			"textbox_20",
			"textbox_20",
			"combobox_YES_NO",
			
			"textbox_60"
		),
	" ".$SAUVEGARDER." ",
	"<br><b>".$LES_VALEURS_MODIFIEES_SUCCES."</b>"
);
	
?>