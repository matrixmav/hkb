
	<div id="ColorsMenu" style="visibility:hidden;position:absolute;top:140;left:500">
		<?php
			include("colorPicker.php");
		?>
	</div>


<br>
<table summary="" border="0" width=100%>
	<tr>
		<td>
		
		<table summary="" border="0">
  	<tr>
  		<td><img src="images/icons/wizard.gif" width="31" height="38" alt="" border="0"></td>
  		<td>
		
		<?php echo $BLOG_ONLY_ST;?>
		
		
		</td>
  	</tr>
  </table>
	<br><br>
	
<?php

	$SubmitButtonText = $SAUVEGARDER;
	$MessageTDLength = 205;
	
		AddEditForm
	(
					array($COULEUR_DE_FOND,
					$M_AREA_BC,
					$HEADER_LINE_COULEUR_DE_FOND,
					$HEADER_FC,
					$HEADER_FS,
					$SHADOWS_COLOR,
					$LIENS_COULEUR,$POLICE,
					$POLICE_TAILLE,
					$DEFAULT_FC
					),
					array("background_color","main_area_background_color","header_background_color",
					"header_font_color",
				    "header_font_size",
			    	"shadows_color",
					"links_color","font_family","font_size","font_color"),
					array(),
					array("textbox_10","textbox_10","textbox_10",
					"textbox_10",
					"combobox_8_9_10_11_12_13_14_15_16_17_18_19_20_21_22_23_24",
					"textbox_10",
					"textbox_10","combobox_Tahoma_Verdana_Arial_Courier_Times New Roman_Comic Sans MS_Georgia_Courier New_Helvetica_Impact_Palatino_Trebuchet MS","combobox_8_9_10_11_12_13_14_15_16","textbox_10"),
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
		
		
<font color=red><?php echo $DOZENS_BACKGROUNDS;?>, <a href="index.php?category=habillage&folder=settings&page=backgrounds">[<?php echo $CLICK_HERE;?>]</a></font>

		</td>
	</tr>
</table>
<script>
var HTType="2";
var HTMessage="<?php echo $T_CHANGE_COLORS;?>";
document.onmousedown = HTMouseDown;
</script>
