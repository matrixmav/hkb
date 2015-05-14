<?php
ms_i($id);
$SubmitButtonText = $SAUVEGARDER;

AddEditForm
	(
	array("ID:","User:","Question:","Answer"),
	array("id","user","question","answer"),
	array("id","user","question"),
	array("textbox_5","textbox_5","textbox_5","textarea_50_15"),
	"support_questions",
	"id",
	$id,
	"The answer has been saved successfully!"
	);
	
?>
<br>
<?php
generateBackLink("support_questions");
?>
