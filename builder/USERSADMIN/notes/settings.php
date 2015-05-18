<?php
if(!isset($AuthUserName)||trim($AuthUserName)=="")
{
	die("");
}
?>

<?php
if(SQLCount("note_settings","WHERE user='$AuthUserName'")==0)
{

	SQLInsert("note_settings",array("user"),array($AuthUserName));
	
}
?>

<table summary="" border="0" width=100%>
	<tr>
		<td>
		
		<table summary="" border="0">
  			<tr>
  				<td>
					<img src="images/icons/settings.gif" width="41" height="41" alt="" border="0">
				</td>
  				<td>
		
						<b>
						<?php echo $MODIFY_SETTINGS;?>
						</b>
		
				</td>
  			</tr>
	  </table>
	<br>
	
	<?php
	
	$MessageTDLength = 250;
	
	AddEditForm
	(
					array(
					"$NUMBER_OF_NOTES_VISIBLES",
					"$SORTING_ORDER_NOTES",
					"$DATE_FORMAT"
					),
					array("notes_visible","notes_order","date_format"),
					array(),
					array(
									"combobox_3_5_10_20",
									"combobox_$LAST_FIRST^0_$NEWER_FIRST^1",
									"combobox_06/18/2005^0_18/06/2005^1_$M_JUNE 18, 2005^2_2005.06.18^3"
					),
					"note_settings",
					"user",
					"'".$AuthUserName."'",
					$VALEURS_MODFIEES_SUCCESS
	);
	?>

		
		</td>
	</tr>
</table>


