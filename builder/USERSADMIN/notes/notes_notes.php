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
		
						<i>
						<?php echo $NOTES_SETTINGS;?>
						</i>
		
				</td>
  			</tr>
	  </table>
<br>
	
	<?php
	
	$MessageTDLength = 305;
	
	$SelectWidth = 200;
	
	$SubmitButtonText = $SAUVEGARDER;
	
	AddEditForm_BA
	(
		array
		(
			"$NUMBER_OF_NOTES_VISIBLES",
			"$SORTING_ORDER_NOTES",
			
			$M_PING_AUTOMATICALLY." weblogs.com ".$M_ON_NEW_POST,
			$M_PING_AUTOMATICALLY." blo.gs ".$M_ON_NEW_POST,
			$M_PING_AUTOMATICALLY." ping-o-matic ".$M_ON_NEW_POST
		),
		array("notes_visible","notes_order","ping_weblogs","ping_blogs","ping_pingomatic"),
		array(),
		array(
						"combobox_3_5_10_20",
						"combobox_$LAST_FIRST^0_$NEWER_FIRST^1",
						
						"combobox_".$M_NO."^0_".$M_YES."^1",
						"combobox_".$M_NO."^0_".$M_YES."^1",
						"combobox_".$M_NO."^0_".$M_YES."^1"
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

<br>

<?php
generateBackLink("notes");
?>

<script>
var HTType="1";
var HTMessage="<?php echo $T_NOTE_SETTINGS;?>";
document.onmousedown = HTMouseDown;
</script>
