<br>
<table summary="" border="0" width=100%>
	<tr>
		<td>
		<b><?php echo $M_EDIT_MENU_TEMPLATE;?>:</b>
		
		</td>
	</tr>
</table>

<br><br>

<?php

$trimLines = true;

$SubmitButtonText = $SAUVEGARDER;

AddEditForm_BA
(
	array($M_HTML_CODE),
	array("menu"),
	array(),
	array("textarea_70_22"),
	"user_templates",
	"user",
	"'".$AuthUserName."'",
	""
);
?>
	<br><br>
	
	<?php
	generateBackLink("format");
	?>

