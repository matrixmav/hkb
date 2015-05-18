
<table summary="" border="0" width=100%>
	<tr>
		<td width=52><img src="images/icons2/write.gif" width="49" height="45" alt="" border="0"></td>
		<td>&nbsp;<b>
		
		Add a new package
		
		</b></td>
	</tr>
</table>


<div id="addnews" >
<?php

$MessageTDLength = 130;

AddNewForm(
		array
		(
						"Name:","Description:","Space (KB):","Bandwidth (KB):",
						"Price, ex. \"14.99\" :<br><i>put 0.00 if free</i>",
						"Billed (Months):",
						"Accept Paypal:",
						"Accept Cheques:",
						"Accept Bank Transfers:",
						"Show Advertisements:"
		),
		array
		(
						"name","description","space","traffic",
						"price",
						"billed",
						"paypal",
						"cheque",
						"bank_wire",
						"adv"
		),
		array
		(
						"textbox_67","textarea_50_6","textbox_5","textbox_5",
						"textbox_5",
						"combobox_1_3_6_12_24",
						"combobox_YES^1_NO^0",
						"combobox_YES^1_NO^0",
						"combobox_YES^1_NO^0",
						"combobox_YES^1_NO^0"
		),

		" $AJOUTER",
		"blog_packages",
		"The new package has been added successfully!<br><br>"
	);
?>
</div>

<?php
if(isset($EFFACER) && isset($CheckList))
{
	
	if(isset($CheckList)&&sizeof($CheckList)>0)
	{
	
		SQLDelete("blog_packages","id",$CheckList);
	
	}

}
?>

<br><br>
<table summary="" border="0" width="100%">
	<tr>
		
		<td>
		<b>
		Modify the existing packages
		</b>
		</td>
	</tr>
</table>
<br>
<?php

$arrTDSizes = array("50","20","100","*","100","100","50","50");

RenderTable(
	"blog_packages",
	array("ModifyPackage","id","name","description","space","traffic","price","billed"),
	array("Modify","ID","Name","Description","Space (KB)","Traffic (KB)","Price","Billed"),
	"100%",
	
	(isset($order_type)?"":"ORDER BY id DESC"),
	$EFFACER,
	"id",
	"index.php?action=".$action."&category=".$category
);
?>


