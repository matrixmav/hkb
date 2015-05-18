
	<div id="ColorsMenu" style="visibility:hidden;position:absolute;top:140;left:500">
		<?php
			include("colorPicker.php");
		?>
	</div>


<br>
<table summary="" border="0" width=100%>
	<tr>
		<td>
		
		
	<br>
	
<?php

	$SubmitButtonText = $SAUVEGARDER;
	$MessageTDLength = 205;
	
		AddEditForm_BA
	(
					array($COULEUR_DE_FOND,
					$M_AREA_BC,
					$HEADER_LINE_COULEUR_DE_FOND,
					$HEADER_FC,
					$HEADER_FS,
					
					$LIENS_COULEUR,$POLICE,
					$POLICE_TAILLE,
					$DEFAULT_FC
					),
					array("background_color","main_area_background_color","header_background_color",
					"header_font_color",
				    "header_font_size",
			    	
					"links_color","font_family","font_size","font_color"),
					array(),
					array("textbox_10","textbox_10","textbox_10",
					"textbox_10",
					"combobox_8_9_10_11_12_13_14_15_16_17_18_19_20_21_22_23_24",
					
					"textbox_10","combobox_Tahoma_Verdana_Arial_Courier_Times New Roman_Comic Sans MS_Georgia_Courier New_Helvetica_Impact_Palatino_Trebuchet MS","combobox_8_9_10_11_12_13_14_15_16_17_18_19_20_21_22_23_24","textbox_10"),
					"weblog",
					"user",
					"'".$AuthUserName."'",
					$LES_VALEURS_MODIFIEES_SUCCES
	);
?>
		
		</td>
	</tr>
</table>
<br>

<table summary="" border="0" width=100%>
	<tr>
		<td>
		
		
<?php echo $DOZENS_BACKGROUNDS;?>, <a href="index.php?category=site&folder=format&page=backgrounds">[<?php echo $CLICK_HERE;?>]</a>

		</td>
	</tr>
</table>

	<br><br>
	
	<?php
	generateBackLink("format");
	?>
	

