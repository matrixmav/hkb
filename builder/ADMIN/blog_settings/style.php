<?php
if(!isset($iKEY)||$iKEY!="AZ8007"){
	die("ACCESS DENIED");
}
?>



<div id="ColorsMenu" style="visibility:hidden;position:absolute;top:140;left:500">
		<?php
			include("colorPicker.php");
		?>
	</div>
	

<table summary="" border="0" width="100%">
	<tr>
		<td width=32><img src="images/icons<?php echo $DN;?>/calendar.gif" border="0" width="37" height="42" alt=""></td>
		<td class=basictext><b><?php echo $MODIFY_SETTINGS;?></b></td>
	</tr>
</table>

<table summary="" border="0" width=750>
	<tr>
		<td class=basictext>
		
		<?php
		EditParams(
		"60,61,62,63,64,65,66,67",
		array(
		"combobox_YES_NO",
		"combobox_Verdana_Arial_Tahoma_Courier_Fixedsys_Impact_Comic Sans MS",
		"combobox_7_8_9_10_11_12_13_14_15_16",
		"textbox_10","textbox_10","textbox_10","textbox_10","textbox_10"
		
		),
		" $SAUVEGARDER ",
		"<b>$NOUVELLES_VALEURS_ENREGISTREES!</b>"
		);
	
	?>
		
		
		
		
		</td>
	</tr>
</table>
<script>
var HTType="1";
var HTMessage="<?php echo $HT_SITE_STYLE;?>";
document.onmousedown = HTMouseDown;
</script>


