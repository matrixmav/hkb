<br>
<?php
ms_i($id);
$MessageTDLength = 130;
$SubmitButtonText = $SAUVEGARDER;
AddEditForm
	(
	array("Name:","Description:","Space (KB):","Bandwidth (KB):",
		"Price, ex. \"14.99\" :<br><i>leave empty or put 0 if free</i>",
		"Billed (Months):",
		"Accept Paypal:",
		"Accept Cheques:",
		"Accept Bank Transfers:",
		"Show Advertisements:"
	),
	array("name","description","space","traffic",
						"price",
						"billed",
						"paypal",
						"cheque",
						"bank_wire","adv"),
	array(),
		array("textbox_67","textarea_50_6","textbox_5","textbox_5",
				"textbox_5",
				"combobox_1_3_6_12_24",
				"combobox_YES^1_NO^0",
				"combobox_YES^1_NO^0",
				"combobox_YES^1_NO^0",
				"combobox_YES^1_NO^0"
		),
	"blog_packages",
	"id",
	$id,
	"The package has been modified successfully!<br><br>"
	);


?>
<br><br>
<?php
generateBackLink("packages");
?>
