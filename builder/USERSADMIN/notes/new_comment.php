<?php
if(!isset($AuthUserName)||trim($AuthUserName)=="")
{
	die("");
}
?>
<?php
if(OverQuota())
{
?>

<table summary="" border="0" width="100%">
	<tr>
		<td>
		
		<br><br>
		<span class="redtext">
		
		<?php
		echo $M_USER_OVER_QUOTA;
		?>
		
		</span>
		</td>
	</tr>
</table>

<?php
}
else
{
?>


<table summary="" border="0" width=100%>
	<tr>
		<td width=52><img src="images/icons/comment_add.png" width="48" height="48" alt="" border="0"></td>
		<td class="blog_admin_header"><?php echo $ADD_NEW_COMMENT;?></td>
	</tr>
</table>


<?php
if(SQLCount("notes","WHERE user='$AuthUserName'") == 0)
{
?>

<br><br>
<table summary="" border="0" width=100%>
	<tr>
		<td>
		<b><font color=red><?php echo $C_ANY_NOTES;?></font></b>
		</td>
	</tr>
</table>

<?php
}
else
{
?>
<script type="text/javascript" src="wysiwyg/scripts/wysiwyg.js"></script>
<script type="text/javascript" src="wysiwyg/scripts/wysiwyg-settings.js"></script>	
<script type="text/javascript">
WYSIWYG.attach("html", full);
</script>
<br>
<?php


$arrNames2=array("date","user");
$arrValues2=array(time(),$AuthUserName);

$SelectWidth = 700;

AddNewForm_BA(
		array("$M_NOTE:",$M_TITLE.":",$M_CONTENT.":"),
		
		array("note_id","title","html"),

		array("combobox_table~notes~id~title~WHERE user='$AuthUserName'","textbox_67","textarea_50_20"),

		" $AJOUTER ",
		"comments",
		"$COMMENT_ADDED_SUCCESSFULLY<br>"
	);
?>

<?php
}
?>
<script>
var HTType="1";
var HTMessage="<?php echo $T_COMMENTS_ADD;?>";
document.onmousedown = HTMouseDown;
</script>
<?php
}
?>
