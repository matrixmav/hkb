<?php
if(!isset($iKEY)||$iKEY!="AZ8007"){
	die("ACCESS DENIED");
}
ms_i($id);
?>
<br>
<TABLE BORDER="0" CELLPADDING="0" CELLSPACING="0" width="100%">
	<TR>
		<td class=basicText>
		
		<i>Modify the information for the selected user</i>
		</td>
	</tr>
</table>
<br>
<br>
<?php
$MessageTDLength=120;
$SubmitButtonText=$SAUVEGARDER;

$tablePackages = DataTable("blog_packages","");
$strPackage = "";
$bFirst = true;
while($arrBlogPackage = mysql_fetch_array($tablePackages))
{
	if(!$bFirst)
	{
		$strPackage .= "_";
	}
	
	$strPackage .= $arrBlogPackage["id"];
	$bFirst = false;
}


$SelectWidth=200;
AddEditForm
	(
	array("$NOM_DUTILISATEUR:","Active: ","Package:","First Name","Last Name","$TELEPHONE:","$EMAIL:",$M_BLOG_CATEGORY.":"),
	array("username","blog_active","plan","first_name","last_name","telephone","email","blog_category"
	),
	array("username"),
	array("textbox_20","combobox_YES^1_NO^0","combobox_".$strPackage,"textbox_40","textbox_40","textbox_40","textbox_40","combobox_special"	),
	"admin_users",
	"id",
	$id,
	"$INFORMATION_UTILISATEUR_MODIFIEE!"
	);
	
?>


<?php

generateBackLink("manage");
?>
