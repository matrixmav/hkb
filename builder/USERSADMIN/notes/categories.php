<?php
if(isset($Delete))
{
	if(isset($CheckList)&&sizeof($CheckList)>0)
	{
		ms_ia($CheckList);
		SQLDeletePlus("note_categories","id",$CheckList);
	}
}
?>

<table summary="" border="0" width=100%>
	<tr>
		<td width=40>
		<img src="images/icons/folder_add.png" width="48" height="48" alt="" border="0">
		
		</td>
		<td class="blog_admin_header"><?php echo $MANAGE_N_CATEGORIES;?></td>
	</tr>
</table>
<br><br>
<table summary="" border="0" width=100%>
	<tr>
		<td>
		<i>
		<?php echo $ADD_NEW_N_CATEGORY;?>
		</i>
		</td>
	</tr>
</table><br>


<div id="AddCat" >
<?php

$arrNames2=array("user","date");
$arrValues2=array($AuthUserName,time());


if(isset($SpecialProcessAddForm))
{
	SQLUpdate_SingleValue
	(
	"admin_users",
	"username",
	"'$AuthUserName'",
	"last_update",
	time()
	);
}

AddNewForm_BA
	(
		array($NOM.":"),
		array("name"),
		array("textbox_40"),
		" $AJOUTER ",
		"note_categories",
		"$NEW_CATEGORY_ADDED_SUCCESS<br>"
	);
?>

</div>

<?php
$arrTDSizes=array("100","*");
RenderTable_BA
(
"note_categories",
array("EditNoteCategory","name"),
array($MODIFY,$NOM),
"100%",
"WHERE user='".$AuthUserName."'",
$EFFACER,
"id",
"index.php?action=".$action."&category=".$category
);
?>
<script>
var HTType="2";
var HTMessage="<?php echo $T_NOTE_CATEGORIES;?>";
document.onmousedown = HTMouseDown;
</script>