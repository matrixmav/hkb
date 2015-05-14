<table summary="" border="0">
	<tr>
		<td>
		
			<b>
			
			</b>
		
		</td>
	</tr>
</table>

<?php
$MessageTDLength=200;
$SubmitButtonText=$SAUVEGARDER;

AddEditForm
	(
	array("$NOM_DUTILISATEUR:",
	
		"Notes Home:","Posts Order:","Date Format:","Allow Comments:",
		"Comments Order:","Send Comments Email:","Blacklist:","Background:"
	),
	array("user",
	
	"notes_visible","notes_order","date_format","allow_comments",
	"comments_order","send_comments_email","blacklist","background"
	
	),
	array("user"),
	array("textbox_20",
	
	"combobox_3_5_10_20","combobox_Last First^0_Newer First^1","combobox_06/18/2005^0_18/06/2005^1_June 18, 2005^2_2005.06.18^3","combobox_YES^1_NO^0",
	"combobox_YES^1_NO^0","combobox_YES^1_NO^0","textbox_40","textbox_40"
	),
	"note_settings",
	"user",
	"'".$user."'",
	"The values have been modified successfully!"
	);
	
?>


<?php
generateBackLink("user_settings");
?>
