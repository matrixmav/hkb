<?php
if(aParameter(13) == "YES")
{
?>
<script language="javascript" type="text/javascript" src="jscripts/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript">tinyMCE.init({mode : "textareas",theme : "simple"});</script>
<?php
}
?>


<script>
function WYSIWYG(x)
{
	window.open("main.php?N="+(document.all?"IE":"FF")+"&LANG=<?php echo $LANGUAGE2;?>&id="+x+"&editspecial=yes&type=faq","title","toolbar=0,location=0,directories=0,menuBar=0,scrollbars=0,resizable=0,width=1015,height=640,left=0,top=0");
}
</script>

<?php
if(!isset($SpecialProcessAddForm))
{
?>
<table summary="" border="0" width=750>
	<tr>
		<td width=52>
		<img src="images/icons<?php echo $DN;?>/clipboard.gif" width="40" height="38" alt="" border="0">
		</td>
		<td>&nbsp;<b><?php echo $ADD_NEW_FAQ;?></b></td>
	</tr>
</table>
<?php
}
?>


<?php

$arrNames2=array("date");
$arrValues2=array(time());

AddNewForm(
		array($M_QUESTION.":",$M_ANSWER.":"),
		
		array("title","html"),

		array("textbox_67","textarea_50_6"),

		" $AJOUTER",
		"faq",
		"The frequently asked question has been added successfully!<br><br>"
	);
?>









<?php

if(isset($EFFACER))
{
	
	if(isset($CheckList)&&sizeof($CheckList)>0)
	{
	
		SQLDelete("faq","id",$CheckList);
	
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
		<?php echo $LIST_FAQ;?>
		</b>
		</td>
	</tr>
</table>
<br>
<?php

$arrTDSizes=array("100","50","150","*");


RenderTable(
						"faq",
						array("date","EditNote","title","html"),
						array("Date",$MODIFY,$M_QUESTION,$M_ANSWER),
						650,
						"ORDER BY id DESC",
						$EFFACER,
						"id",
						"index.php?action=".$action."&category=".$category
);
?>



