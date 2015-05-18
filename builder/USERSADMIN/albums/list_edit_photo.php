<?php
if(!isset($AuthUserName)||trim($AuthUserName)=="")
{
	die("");
}
ms_i($photo_id);
?>
<br>
<table summary="" border="0" width="100%">
	<tr>
		<td width="38"><img src="images/icons/photo.png" width="48" height="48" alt="" border="0"></td>
		<td>
		<b>
		<?php
			echo $MODIFY_THE_SELECTED_PICTURE;
		?>
		</b>
		</td>
	</tr>
</table>

<script type="text/javascript" src="wysiwyg/scripts/wysiwyg.js"></script>
<script type="text/javascript" src="wysiwyg/scripts/wysiwyg-settings.js"></script>
<script type="text/javascript">
WYSIWYG.attach('description', small);
</script>

<?php
$SubmitButtonText = $SAUVEGARDER;
$strSpecialHiddenFieldsToAdd = "<input type=hidden name=photo_id value=\"".$photo_id."\">";

$SelectWidth = 400;

AddEditForm_BA
(
	array($M_TITLE."",$M_PLACE,$DESCRIPTION.""),
	array("title","place","description"),
	array(),
	array("textbox_57","textbox_57","textarea_42_10"),
	"photo_images",
	"id",
	$photo_id,
	$MODIFICATION_SAVED
);
?>


