
<table summary="" border="0" width=750>
	<tr>
		<td width=35><img src="images/icons<?php echo $DN;?>/wizard.gif" width="31" height="38" alt="" border="0"></td>
		<td>
		<b><?php echo $CHANGE_SETTINGS_FOR_GALLERY;?> [id: <?php echo $id;?>]</b>
		</td>
	</tr>
</table>
<br>
<?php

$arrNames2=array("date");
$arrValues2=array(time());

$arrLngTable=DataTable("languages","");

$arrFrmLanguages=array();

while($arrLng=mysql_fetch_array($arrLngTable)){
	array_push($arrFrmLanguages,strtolower($arrLng["code"]));
}

$arrTable=DataTable("pages","");


$arrFrmPages=array();

while($arrFrm=mysql_fetch_array($arrTable))
{
	
	foreach($arrFrmLanguages as $lng){
	
		if(trim($arrFrm["link_".strtolower($lng)])!=""){
			array_push($arrFrmPages,urlencode(strtolower($lng)."_".$arrFrm["link_".strtolower($lng)]));
		}
	}

	
}



$MessageTDLength = 200;

AddEditForm
	(

		array(
	$MX1,	
	$MX2,
	$MX3,
	$MX4,
	$MX5,
	$MX6,
	$MX7,
	$MX8,
	$MX9
	),
	array("pg","home_thumbnails_columns","home_thumbnails_size", "thumbnails_size","show_title","show_date","show_legende","show_place","show_description"),
	array(),
	array("combobox_special", "combobox_2_3_4_5_6_7_8","thumbnails","thumbnails","combobox_YES_NO","combobox_YES_NO","combobox_YES_NO","combobox_YES_NO","combobox_YES_NO"),
	"photo",
	"id",
	$id,
	$LES_VALEURS_MODIFIEES_SUCCES
	);
?>
<br><br>
<?php
generateBackLink("album");
?>


