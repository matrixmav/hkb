<?php
ms_i($id);

?>
<script type="text/javascript" src="wysiwyg/scripts/wysiwyg.js"></script>
<script type="text/javascript" src="wysiwyg/scripts/wysiwyg-settings.js"></script>
<script type="text/javascript">
WYSIWYG.attach('html', small);
</script>
<br>
<?php

$SubmitButtonText = $SAUVEGARDER;

AddEditForm
	(
	array("Title",$M_CONTENT,"Active"),
	array("title","html","active"),
	array(),
	array("textbox_67","textarea_70_8","combobox_YES_NO"),
	"news",
	"id",
	$id,
	$LES_VALEURS_MODIFIEES_SUCCES
	);
?>
<br><br>

<?php
generateBackLink("news");
?>

