
<table summary="" border="0" width=100%>
	<tr>
		
		<td>&nbsp;<i><?php echo $MODIFY_PERSONAL_INFORMATION;?></i></td>
	</tr>
</table>
<br>
<?php

$SubmitButtonText = $SAUVEGARDER;

 AddEditForm_BA
	(
		array
		(
			$FIRST_NAME,
			$LAST_NAME,
			$M_COMPANY,
			$TELEPHONE,
			$EMAIL,
			$COUNTRY,
			$ADDRESS1,
			$ADDRESS2,
			$CITY,
			$M_STATE,
			$M_ZIP
		),
	array("first_name","last_name",
	"company","telephone","email","country",
					
				"address_address1",
				"address_address2",
				"address_city",
				"address_state",
				"address_zip"
	),
	array("type"),
	array(
		"textbox_30",
		"textbox_30",
		"textbox_30","textbox_30 ","textbox_30","country",
	
	"textbox_30",
	"textbox_30",
	"textbox_30",
	"textbox_30",
	"textbox_30"
	
	
	),
	"admin_users",
	"username",
	"'".$AuthUserName."'",
	$LES_VALEURS_MODIFIEES_SUCCES
	);


?>
<br><br>

<?php
echo generateBackLink("profil");
?>
