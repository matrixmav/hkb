<script>
function WYSIWYG(x)
{
	window.open("main.php?N="+(document.all?"IE":"FF")+"&LANG=<?php echo $LANGUAGE2;?>&id="+x+"&editspecial=yes&type=newsletter","title","toolbar=0,location=0,directories=0,menuBar=0,scrollbars=0,resizable=0,width=1015,height=640,left=0,top=0");
}


</script>

<?php
if(isset($Delete))
{
	
	if(isset($CheckList)&&sizeof($CheckList)>0)
	{
		ms_ia($CheckList);
		SQLDelete("newsletter","id",$CheckList);
	
	}

}
?>
<table summary="" border="0" width="950">
	<tr>
		<td width=35><img src="images/icons<?php echo $DN;?>/wizard.gif" width="31" height="38" alt="" border="0"></td>
		<td>&nbsp;
		
		<b><?php echo $ADD_NEWSLETTER;?></b>
		</td>
	</tr>
</table>
<br>

<?php

AddNewForm(

		array($SUBJECT.":",$M_MESSAGE.":"),
		array("subject","html"),
		
		array("textbox_67","textarea_50_8"),
		$AJOUTER,
		"newsletter",
		$NEWSLETTER_ADDED
	);
?>	

	<br>
<?php

$arrTDSizes = array("50","50","200","*");

RenderTable(
						"newsletter",
						array("id","subject","html"),
						array("ID",$SUBJECT,$M_MESSAGE),
						950,
						"",
						$EFFACER,
						"id",
						"index.php?category=$category&action=$action"
);
						

?>


