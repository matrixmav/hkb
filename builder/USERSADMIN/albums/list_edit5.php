<?php
if(!isset($AuthUserName)||trim($AuthUserName)=="")
{
	die("");
}
ms_i($id);
?>


<table summary="" border="0" width="100%">
	<tr>
		
		<td><i><?php echo $M_EDIT_THE_ALBUM_DESCRIPTION;?></i></td>
	</tr>
</table>

<script type="text/javascript" src="wysiwyg/scripts/wysiwyg.js"></script>
<script type="text/javascript" src="wysiwyg/scripts/wysiwyg-settings.js"></script>
<script type="text/javascript">
WYSIWYG.attach('description', small);
</script>
<br>
<?php

$arrNames2=array("date");
$arrValues2=array(time());
$SubmitButtonText = $SAUVEGARDER;
AddEditFormPlus
	(
	array($DESCRIPTION),
	array("description"),
	array(),
	array("textarea_50_14"),
	"photo",
	"id",
	$id,
	$LES_VALEURS_MODIFIEES_SUCCES,
	"user='".$AuthUserName."'"
	);
?>
<br><br>
<?php
generateBackLink("list");
?>
