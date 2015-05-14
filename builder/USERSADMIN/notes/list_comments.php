<?php
if(!isset($AuthUserName)||trim($AuthUserName)=="")
{
	die("");
}
if(isset($id)) ms_i($id);
?>

<?php

if(isset($Delete))
{
	if(isset($CheckList)&&sizeof($CheckList)>0)
	{
		ms_ia($CheckList);
		SQLDeletePlus("comments","id",$CheckList);
	}
}

?>
<script>
function ShowComment(x)
{

		window.open('include/show_comment.php?id='+x,'popupIm','width=550,height=450,toolbar=no,location=no,directories=no,status=no,menubar=no,copyhistory=no,resizable=yes');
		
}

</script>

<table summary="" border="0" width="100%">
	<tr>
		<td width="40" ><img src="images/icons/comments.png" width="48" height="48" alt="" border="0"></td>
		<td class="blog_admin_header"><?php echo $CONSULT_THE_POSTED_COMMENTS;?></td>
	</tr>
</table>


<?php
$arrTDSizes=array("50","100","100","100","100","*","100");

RenderTable_BA
(
	"comments",
	array("PreviewNote","date","author","email","title","comment_content","ip"),
	array($M_NOTE,$DATE_MESSAGE,$M_AUTHOR,$M_EMAIL,$M_TITLE,$M_CONTENT,$IP_MESSAGE),
	"100%",
	"WHERE note_id=$id ORDER BY id DESC",
	$EFFACER,
	"id",
	"index.php?category=".$category."&page=".$page."&folder=".$folder."&id=".$id
);
?>
<script>
var HTType="1";
var HTMessage="<?php echo $T_CONSULT_COMMENTS;?>";
document.onmousedown = HTMouseDown;
</script>
<br>
<?php
generateBackLink("list");
?>
