
<?php
ms_i($id);
$SubmitButtonText = $SAUVEGARDER;

AddEditForm
	(
					array("ID:","Name:"),
					array("id","name"),
					array("id"),
					array("textbox_5","textbox_60"),
					"blog_categories",
					"id",
					$id,
					"The category has been modified successfully!"
	);
	
?>
<br>
<?php
generateBackLink("categories");
?>
