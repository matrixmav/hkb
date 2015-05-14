<?php
if(!isset($iKEY)||$iKEY!="AZ8007"){
	die("ACCESS DENIED");
}
?>
<table summary="" border="0" width=100%>
	<tr>
		<td width=32><img src="images/icons<?php echo $DN;?>/erase.gif" border="0" width="38" height="41" alt=""></td>
		<td class=basictext><b><?php echo $MANAGEMENT_FORMS_2;?></b></td>
	</tr>
</table>
<br>
<?php

if(isset($ProceedDelete))
{
	ms_i($id);
	SQLDelete("forms","id",array($id));

	$HISTORY=$USER_DELETED_TEMPLATE.$id;
}


if(isset($SpecialProcessAddForm))
{
	ms_i($SpecialProcessAddForm);
	$arrSelectedForm = DataArray("forms","id=".$SpecialProcessAddForm);
	
	SQLInsert("forms",
	array("name","description","code","submit","message"),
	array("Copy of ".$arrSelectedForm["name"],$arrSelectedForm["description"],$arrSelectedForm["code"],$arrSelectedForm["submit"],$arrSelectedForm["message"])
	);
	
	
}

if(isset($ProceedApply)){

	$arrForms=DataTable("forms","");
	
	while($arrForm=mysql_fetch_array($arrForms)){
	
		SQLUpdate_SingleValue(
				"forms",
				"id",
				$arrForm["id"],
				"page",
				urldecode(get_param("pg_".$arrForm["id"]))
			);
	}
}

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
?>


<?php
$arrTDSizes=array("150","100","60","60","60","60");
$customFormEnd=true;
RenderTable
(
	"forms",
	array("name","ShowAssignForm","ShowFormDelete","ShowFormPreview","BackupForm"),
	array($NOM,"Page", $EFFACER,$PARAMETRES,$M_COPY),
	"100%",
	"ORDER BY id DESC",
	"",
	"id",
	"index.php?category=".$category."&action=".$action
);
				
?>
<table summary="" border="0" width="100%">
	<tr>
		<td align=right>
		<br>
		<input type=hidden name=ProceedApply>
		<input type=hidden name=category value="<?php echo $category;?>">
		<input type=hidden name=action value="<?php echo $action;?>">
		<input type=submit value=" <?php echo $APPLY_MESSAGE;?> " class="adminButton">
		</form>

		</td>
	</tr>
</table>
<script>
var HTType="2";
var HTMessage="<?php echo $HT_SERVER_SIDE_FORMS_MANAGE.'<br>'.$HT_PUBLISH_FORM;?>";
document.onmousedown = HTMouseDown;
</script>

