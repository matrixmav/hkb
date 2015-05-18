<?php
if(!isset($AuthUserName)||trim($AuthUserName)=="")
{
	die("");
}
ms_i($zone);
?>
<?php
if(trim(aParameter(1500+get_param("zone"))) != "") die("");
?>
<table summary="" border="0" width="100%">
	<tr>
		<td>
		
		<table summary="" border="0">
  	<tr>
  		
  		<td><i><?php echo $M_PUT_ADVERTISEMENTS_SELECTED_AREA;?></i></td>
  	</tr>
  </table>
  <br>
  
  
  	<?php

	$firstTDLength = 180;
		
	$strSpecialHiddenFieldsToAdd = "<input type=hidden name=zone value=\"".get_param("zone")."\">";
		
		
	$SubmitButtonText = $SAUVEGARDER;
	
	AddEditForm_BA
	(
					array($M_HTML_CODE),
					array("zone".$zone),
					array(),
					array("textarea_50_10"),
					"weblog",
					"user",
					"'".$AuthUserName."'",
					$LES_VALEURS_MODIFIEES_SUCCES
	);
	
	?>
  <br><br>
  
  <?php
  generateBackLink("advertisements");
  ?>
  
		</td>
	</tr>
</table>
