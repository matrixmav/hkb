<table summary="" border="0">
	<tr>
		<td>
		
			<b>
			
			</b>
		
		</td>
	</tr>
</table>

<?php
$MessageTDLength=120;
$SubmitButtonText=$SAUVEGARDER;

AddEditForm
	(
	array("$NOM_DUTILISATEUR:",
	
		"HTML:"
	),
	array("user",
	
	"html"
	
	),
	array("user"),
	array("textbox_20",
	
	"textarea_90_40"
	),
	"user_templates",
	"user",
	"'".$user."'",
	"The values have been modified successfully!"
	);
	
?>


<?php
generateBackLink("user_settings");
?>
