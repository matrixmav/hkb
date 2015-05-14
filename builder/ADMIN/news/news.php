<script type="text/javascript" src="wysiwyg/scripts/wysiwyg.js"></script>
<script type="text/javascript" src="wysiwyg/scripts/wysiwyg-settings.js"></script>
<script type="text/javascript">
WYSIWYG.attach('html', small);
</script>

<script>
function WYSIWYG(x)
{
	window.open("main.php?N="+(document.all?"IE":"FF")+"&LANG=<?php echo $LANGUAGE2;?>&id="+x+"&editspecial=yes&type=news","title","toolbar=0,location=0,directories=0,menuBar=0,scrollbars=0,resizable=0,width=1015,height=640,left=0,top=0");
}

function EditNote(x,y)
{
	window.open("main.php?N="+(document.all?"IE":"FF")+"&LANG=<?php echo $LANGUAGE2;?>&x="+x+"&y="+y,"title","toolbar=0,location=0,directories=0,menuBar=0,scrollbars=0,resizable=0,width=1015,height=640,left=0,top=0");

}
</script>
<?php
if(!isset($SpecialProcessAddForm))
{
?>
<table summary="" border="0" width="100%">
	<tr>
		<td width=52><img src="images/icons<?php echo $DN;?>/write.gif" width="49" height="45" alt="" border="0"></td>
		<td>&nbsp;<b><?php echo $ADD_NEW_NOTE;?></b></td>
	</tr>
</table>
<?php
}
?>

<?php

$arrNames2=array("date");
$arrValues2=array(time());

AddNewForm(
		array($M_TITLE.":",$M_CONTENT.":","Active"),
		
		array("title","html","active"),

		array("textbox_67","textarea_50_8","combobox_YES_NO"),

		" $AJOUTER",
		"news",
		"The news has been added successfully!<br><br>"
	);
?>









<?php

if(isset($Delete))
{
	
	if(isset($CheckList)&&sizeof($CheckList)>0)
	{
		ms_ia($CheckList);
		SQLDelete("news","id",$CheckList);
	
	}

}

?>
<script>
function EditNote2(y)
{
<?php
$usrArray=DataArray("admin_users","username='$AuthUserName'");
?>
	window.open("main.php?N="+(document.all?"IE":"FF")+"&LANG=<?php echo $LANGUAGE2;?>&x=<?php echo $usrArray['id'];?>&y="+y,"title","toolbar=0,location=0,directories=0,menuBar=0,scrollbars=0,resizable=0,width=1015,height=640,left=0,top=0");
}
</script>
<br><br>
<table summary="" border="0" width=750>
	<tr>
		
		<td>&nbsp;
		<b>
		<?php echo $LIST_NOTES;?>
		</b>
		</td>
	</tr>
</table>
<br>
<?php

$arrTDSizes=array("100","50","150","*");

$tableNotes = DataTable("news","WHERE active='NO'");
$strHighlightIdName="id";
$arrHighlightIds=array();

while($arrNote = mysql_fetch_array($tableNotes))
{
	array_push($arrHighlightIds,$arrNote["id"]);
}


RenderTable
(
	"news",
	array("date","EditNote","title","html_limit"),
	array($DATE_MESSAGE,$MODIFY,$M_TITLE,$M_CONTENT),
	"100%",
	
	(isset($order_type)?"":"ORDER BY id DESC"),
	$EFFACER,
	"id",
	"index.php?action=".$action."&category=".$category
);
?>



