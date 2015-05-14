<?php
ms_i($zone);
?>

<table summary="" border="0" width="750">
	<tr>
		<td>
		
		<table summary="" border="0">
  	<tr>
  		<td>
		<img src="images/icons2/tools.gif" width="45" height="43" alt="" border="0">
		</td>
  		<td><b>Manage the advertisments for zone #<?php echo get_param("zone");?></b></td>
  	</tr>
  </table>
  <br><br>
  
  
  	<?php

		$firstTDLength = 180;
		
		$strHiddenFields = "<input type=hidden name=zone value=\"".get_param("zone")."\">";
		
		EditParams
		(
						""+(1500+get_param("zone")),
						array
						(
						"textarea_60_15"		
						),
						" $SAUVEGARDER ",
						"<b>$NOUVELLES_VALEURS_ENREGISTREES!</b>"
		);
	
	?>
  <br>
  
  <?php
  generateBackLink("advertisments");
  ?>
  
		</td>
	</tr>
</table>
