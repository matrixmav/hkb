
<?php
if(!isset($iKEY)||$iKEY!="AZ8007"){
	die("ACCESS DENIED");
}
?>



<div  id="ColorsMenu" style="visibility:hidden;position:absolute;top:240;left:600">
<?php
include("colorPicker.php");
?>
</div>

<?php
include("include/languages_menu_processing.php");
?>
<?php
include("include/languages_menu.php");
?>


<center>
<div id="Params">
<table summary="" border="0">
	<tr>
		<td class=basictext>
		
		<?php
		
		$firstTDLength = 250;
		
		$EditColumns = 2;
		$FirstTDAlign = "left";
		$SelectWidth = "100px";
		$TextboxWidth = "100px";
		$TableWidth = 800;
		
		EditParams(
		"29,30,31,32,33,34,38,39,40,41,53,54,55,56,57,58,310,311,312,313,314,315,316,317,318,319,320,321",
		array(
		"combobox_Verdana_Arial_Tahoma_Comic Sans MS_Compact_Courier_Fixedsys_Georgia_Symbol_Times New Roman",
		"combobox_Verdana_Arial_Tahoma_Comic Sans MS_Compact_Courier_Fixedsys_Georgia_Symbol_Times New Roman",
		"combobox_6_7_8_9_10_11_12_13_14_15_16",
		"combobox_6_7_8_9_10_11_12_13_14_15_16",
		"textbox_10",
		"textbox_10",
		"combobox_none_bold_italic_underline",
		"combobox_none_bold_italic_underline",
		"combobox_none_bold_italic_underline",
		"combobox_none_bold_italic_underline",
		"textbox_10","textbox_10","textbox_10","textbox_10","textbox_10","textbox_10",
		"textbox_10","textbox_10","textbox_10","textbox_10","textbox_10","textbox_10",
		"combobox_none_solid","combobox_none_solid",
		"textbox_10","textbox_10","combobox_YES_NO",
		"combobox_HORIZONTAL_VERTICAL"
		),
		$SAVE_SETTINGS,
		"<b>".$NOUVELLES_VALEURS_ENREGISTREES."</b>"
		);
	
	?>
	
	
			
		</td>
	</tr>
</table>

</center>
<br>
<table summary="" border="0" width="100%">
	<tr>
		<td>
		
		(*) When this option is set to "YES", the images previously set 
			from the Customized Menu ->	Contruct page will be used. If there is no
			image set for a particular menu item, then the settings from this page will
			apply to it.
		
		</td>
	</tr>
</table>

</div>


<?php
generateBackLink("menu");
?>

