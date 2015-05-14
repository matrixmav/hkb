<?php
if(!isset($iKEY)||$iKEY!="AZ8007"){
	die("ACCESS DENIED");
}
?>
<script>
function DeleteTemplate(x)
{
	if(confirm("Are you sure that you want to delete this template?\n\nBe aware that once deleted the template can not be restored!"))
	{
		document.location.href="index.php?category=templates&action=modify&Delete="+x;
	}
}
</script>
<?php
if(isset($Delete))
{
	ms_i($Delete);
	SQLDelete("templates","id",array($Delete));
}
?>
<table summary="" border="0" width=100%>
	<tr>
		<td width=32><img src="images/icons<?php echo $DN;?>/clipboard.gif" border="0" width="40" height="38" alt=""></td>
		<td class=basictext><b><?php echo $MODIFY_TEMPLATE;?></b></td>
	</tr>
</table>
<br>
	<?php
	
	$arrHighlightIds=array(Parameter(10));
	$strHighlightIdName="id";
	
	$arrTDSizes = array("80","80","300","*");
	
RenderTable
(
	"templates",
	array("ModifyTemplate","DeleteTemplate","name","description"),
	array($MODIFY,$EFFACER,$NOM,$DESCRIPTION),
	"100%",
	"ORDER BY ID desc",
	"",
	"id",
	"index.php?action=".$action."&category=".$category
);
?>
<script>
var HTType="2";
var HTMessage="<?php echo $HT_MODIFY_TEMPLATE;?>";
document.onmousedown = HTMouseDown;
</script>

<br><br>
