<br>
<table summary="" border="0" width=100%>
	<tr>
		<td>
		<b><?php echo $EDIT_EXPL;?>:</b>
		
		</td>
	</tr>
</table>

<br><br>

<?php

$trimLines = true;

$SubmitButtonText = $SAUVEGARDER;

AddEditForm
	(
	array($CODE),
	array("html"),
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
<script>
var HTType="1";
var HTMessage="<?php echo $T_EXPERT_MODE;?>";
document.onmousedown = HTMouseDown;
</script>
