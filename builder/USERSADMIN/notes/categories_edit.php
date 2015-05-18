<?php
if(!isset($AuthUserName)||trim($AuthUserName)=="")
{
	die("");
}
ms_i($id);

?>
<table summary="" border="0" width="100%">
	<tr>
		<td width="45"><img src="images/icons/pencil.png" width="48" height="48" alt="" border="0"></td>
		<td class="blog_admin_header"><?php echo $MODIFY_THE_SELECTED_CATEGORY;?></td>
	</tr>
</table>
<br><br>
<?php


$SubmitButtonText = $SAUVEGARDER;

AddEditFormPlus
(
	array($NOM),
	array("name"),
	array(),
	array("textbox_40"),
	"note_categories",
	"id",
	$id,
	$LES_VALEURS_MODIFIEES_SUCCES,
	"user='".$AuthUserName."'"
);
?>
<br><br>

<script>
var HTType="2";
var HTMessage="<?php echo $T_CATEGORIES_EDIT;?>";
document.onmousedown = HTMouseDown;
</script>


<?php
generateBackLink("categories");
?>
