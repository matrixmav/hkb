<?php
ms_i($id);

//$arrComment = DataArray("comments","id=".$id." AND  user='".$AuthUserName."'");

$SubmitButtonText = "";

AddEditForm_BA
(
	array($M_TITLE,$M_CONTENT,$M_AUTHOR,$M_EMAIL,$IP_MESSAGE),
	array("title","html","author","email","ip"),
	array("title","html","author","email","ip"),
	array("textbox_67","textarea_50_20","textbox_67","textbox_67","textbox_67"),
	
	"comments",
	"id",
	$id,
	$VALEURS_MODFIEES_SUCCESS."<br>"
);
?>
<br>
<?php
generateBackLink("comments");
?>