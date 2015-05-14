<?php
if(SQLCount("note_settings","WHERE user='$AuthUserName'")==0)
{

	SQLInsert("note_settings",array("user"),array($AuthUserName));
	
}
?>
<br>
<table summary="" border="0" width=100%>
	<tr>
		<td>
		
		<table summary="" border="0" width=100%>
  			<tr>
  				
  				<td>
		
						
						<b><?php echo strtoupper($NOTES_SETTINGS);?></b>
				</td>		
				<td align="right">				
						
						<a href="index.php?category=settings&folder=notes&page=notes" style="text-decoration:none"><b>[<?php echo strtoupper($MODIFY);?>]</b></a>
		
										
						
		
				</td>
  			</tr>
	  </table>
	<hr width=100% color=#636563>
	
	<?php
	
	$MessageTDLength = 350;
	
	$SelectWidth = 200;
	
	$SubmitButtonText = "";
	
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
					array("notes_visible","notes_order","ping_weblogs","ping_blogs","ping_pingomatic"),
					array
					(
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

<table summary="" border="0" width="100%">
  			<tr>
  				
  				<td>
		
						
						<b><?php echo strtoupper($COMMENTS_SETTINGS);?></b>
					
				</td>		
				<td align="right">				
						
						<a href="index.php?category=settings&folder=notes&page=comments" style="text-decoration:none"><b>[<?php echo strtoupper($MODIFY);?>]</b></a>
		
				</td>
  			</tr>
	  </table>
<hr width=100% color=#636563>

<?php
	
	
	$SelectWidth = 200;
	
	$SubmitButtonText = "";
	
	AddEditForm_BA
	(
					array(
					"$AUTH_COMMENTS_DEFAULT",
					"$SORTING_ORDER_COMMENTS",
					"$SEND_BY_EMAIL",
					"$IP_BLACK"
					),
					array("allow_comments","comments_order","send_comments_email","blacklist"),
					array("allow_comments","comments_order","send_comments_email","blacklist"),
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


<br>
	<table summary="" border="0" width=100%>
  			<tr>
  				<td>
		
						<b><?php echo strtoupper($M_TRACKBACK_SETTINGS);?></b>
				</td>		
				<td align="right">				
						
						<a href="index.php?category=settings&folder=notes&page=trackbacks" style="text-decoration:none"><b>[<?php echo strtoupper($MODIFY);?>]</b></a>
		
										
						
		
				</td>
  			</tr>
	  </table>
	<hr width=100% color=#636563>
<?php
	

	
	$SubmitButtonText = "";
	
	AddEditForm_BA
	(
					array
					(
						$AUTH_COMMENTS_DEFAULT,
						$IP_BLACK
					),
					array("allow_trackbacks","blacklist_trackbacks"),
					array("allow_trackbacks","blacklist_trackbacks"),
					array(
									"combobox_$M_NO^0_$M_YES^1",
									"textarea_22_4"
					),
					"note_settings",
					"user",
					"'".$AuthUserName."'",
					$VALEURS_MODFIEES_SUCCESS
	);
	?>
	
	<br>

<script>
var HTType="1";
var HTMessage="<?php echo $T_NOTE_SETTINGS;?>";
document.onmousedown = HTMouseDown;
</script>
