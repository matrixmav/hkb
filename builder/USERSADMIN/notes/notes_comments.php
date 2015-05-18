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
						<?php echo $COMMENTS_SETTINGS;?>
						</i>
		
				</td>
  			</tr>
	  </table>
<br>
	
	<?php
	
	$MessageTDLength = 220;
	$SelectWidth = 200;
	
	$SubmitButtonText = $SAUVEGARDER;
	
	AddEditForm_BA
	(
					array(
					"$AUTH_COMMENTS_DEFAULT",
					"$SORTING_ORDER_COMMENTS",
					"$SEND_BY_EMAIL",
					"$IP_BLACK"
					),
					array("allow_comments","comments_order","send_comments_email","blacklist"),
					array(),
					array(
									"combobox_$M_NO^0_$M_YES^1",
									"combobox_$LAST_FIRST^0_$NEWER_FIRST^1",
									"combobox_$M_NO^0_$M_YES^1",
									"textarea_22_4"
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
var HTType="2";
var HTMessage="<?php echo $T_COMMENT_SETTINGS;?>";
document.onmousedown = HTMouseDown;
</script>
