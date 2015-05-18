<?php
if(!isset($AuthUserName)||trim($AuthUserName)=="")
{
	die("");
}
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

<br>
<table summary="" border="0" width="100%">
	<tr>
		<td>
		
			<b>
			<?php echo strtoupper($CONSULT_COMMENTS);?>
			</b>
			<br>
			<hr width=100% color=#636563>
		
		</td>
	</tr>
</table>
<br>







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
<table summary="" border="0" width=100%>
	<tr>
		<td>
	<form action="index.php" method="post" style="margin-bottom:0px;margin-top:0px">	
	<input type=hidden name="proceedshow" value="1">
	<input type=hidden name="category" value="<?php echo $category;?>">
	<input type=hidden name="action" value="<?php echo $action;?>">
	
	<i>
	<?php echo $PLEASE_SELECT_THE_NOTE;?>
	</i>

<br><br>	
<?php
HtmlComboBox_Query
(
	"SELECT * FROM ".$DBprefix."notes WHERE user='$AuthUserName'",
	"id",
	"title"
);
?>
&nbsp;&nbsp;&nbsp;&nbsp;
<input type=submit value=" <?php echo $AFFICHER;?> " type=submit class=adminButton>
</form>


		</td>
	</tr>
</table>
<center>
<?php
if(get_param("proceedshow") != "")
{
echo "<br><br>";

$arrTDSizes=array("100","100","100","*","50");

RenderTable_BA
(
	"comments",
	array("date","email","title","comment_content","ip"),
	array($DATE_MESSAGE,$M_EMAIL,$M_TITLE,$M_CONTENT,$IP_MESSAGE),
	"100%",
	"WHERE  user='".$AuthUserName."'  AND note_id=$id ORDER BY date",
	$EFFACER,
	"id",
	"index.php?action=".$action."&category=".$category."&proceedshow=1&id=".$id
);
}
?>
</center>

<br><br>
<?php
}
?>






<?php
if(get_param("proceedshow") == "")
{
?>
<br><br>



<table summary="" border="0" width=100%>
	<tr>
		<td>
	
			<b>
			<?php echo strtoupper($LIST_ALL_COMMENTS);?>
			</b>
			<br>
			<hr width=100% color=#636563>
		
		</td>
	</tr>
</table>
<br>
<?php


$arrTDSizes=array("30","80","80","80","200","*","30");

RenderTable_BA
(
	"comments",
	array("PreviewNote","date","author","email","title","comment_content","ip"),
	array($M_NOTE,$DATE_MESSAGE,$M_AUTHOR,$M_EMAIL,$M_TITLE,$M_CONTENT,$IP_MESSAGE),
	"100%",
	"WHERE  user='".$AuthUserName."' ORDER BY id DESC",
	$EFFACER,
	"id",
	"index.php?action=".$action."&category=".$category
);

?>

<?php
}
?>

<script>
var HTType="1";
var HTMessage="<?php echo $T_ALL_COMMENTS;?>";
document.onmousedown = HTMouseDown;
</script>
