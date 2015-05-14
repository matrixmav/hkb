<?php
if(!isset($iKEY)||$iKEY!="AZ8007"){
	die("ACCESS DENIED");
}
?>


<script>
function DeleteLanguage(x,y)
{
	if(confirm("Are you sure that you want to delete this language version of the website?\n\nBe aware that once deleted the language version and all the information associated to it can not be restored!"))
	{
		document.location.href="index.php?category=<?php echo $category;?>&action=languages&Delete="+x+"&ProceedDelete="+y;
	}
}
</script>
<?php

if(isset($Delete)&&isset($ProceedDelete))
{
	ms_w($ProceedDelete);
	SQLQuery
	(
	"
		ALTER TABLE `".$DBprefix."pages` DROP `active_".strtolower($ProceedDelete)."`,
		DROP `name_".strtolower($ProceedDelete)."` ,
		DROP `link_".strtolower($ProceedDelete)."` ,
		DROP `description_".strtolower($ProceedDelete)."` ,
		DROP `keywords_".strtolower($ProceedDelete)."` ,
		DROP `html_".strtolower($ProceedDelete)."` ,
		DROP `custom_link_".strtolower($ProceedDelete)."` 
	"
	);
	ms_i($Delete);
	SQLDelete("languages","id",array($Delete));
}
else
if(isset($ProceedChangeDefault))
{
	ms_i($ID);
	SQLQuery("UPDATE ".$DBprefix."languages SET default_language=0");
	SQLQuery("UPDATE ".$DBprefix."languages SET default_language=1 WHERE id=".$ID);
	
	$HISTORY=$DEFAULT_LNG_CHANGED;
	
}

if(isset($SpecialProcessAddForm))
{
	ms_w($code);
	SQLQuery(
	"
		ALTER TABLE `".$DBprefix."pages` ADD `active_".strtolower($code)."` TINYINT NOT NULL ,
		ADD `name_".strtolower($code)."` VARCHAR( 255 ) NOT NULL ,
		ADD `link_".strtolower($code)."` VARCHAR( 255 ) NOT NULL ,
		ADD `description_".strtolower($code)."` TEXT NOT NULL ,
		ADD `keywords_".strtolower($code)."` TEXT NOT NULL ,
		ADD `html_".strtolower($code)."` TEXT NOT NULL ,
		ADD `custom_link_".strtolower($code)."` TEXT NOT NULL
	"
	);
	
	SQLQuery("UPDATE
		".$DBprefix."pages 
 		SET active_".strtolower($code)."=active_en,
		name_".strtolower($code)."=name_en,
		link_".strtolower($code)."=link_en,
		description_".strtolower($code)."=description_en,
		keywords_".strtolower($code)."=keywords_en,
		html_".strtolower($code)."=html_en,
		custom_link_".strtolower($code)."=custom_link_en");
	
	$HISTORY=strtoupper($code).$LNG_ADDED_BY_USER;
	
}



?>

<script>

function RadioClick(languageID){
	document.location.href="index.php?action=<?php echo $action;?>&category=<?php echo $category;?>&ProceedChangeDefault=&ID="+languageID;
}

</script>

<table summary="" border="0" width="100%">
	<tr>
		<td width=39>
		<img src="images/icons<?php echo $DN;?>/download.gif" border="0" width="39" height="39" alt="">
		</td>
		<td class=basictext>		
		
		

<b>
<?php echo $AJOUTER_NOUVEAU_LANGUAGE;?>
</b>

		</td>
	</tr>
</table>


<br>
<?php

$arrExamples = array(" ex. \"Deutsch\""," ex. \"DE\"");

AddNewForm(
		array("$LANGUAGE: ","$CODE: ","$ACTIVE: "),
		
		array("name","code","active"),

		array("textbox_20","textbox_2","combobox_$M_YES^1_$M_NO^0"),

		" $AJOUTER  ",
		"languages",
		"$AJOUTER_SUCCES<br><br>"
	);

?>

<br><br>

<table summary="" border="0" width="100%">
	<tr>
		<td class=basictext>		
		<b>
			<?php echo $LISTE_LANGUAGES;?>
		</b>
		</td>
	</tr>
</table>

<br>

<?php
RenderTable
(
	"languages",
	array("ShowSpecialLanguage","DeleteLanguage","ChangeLanguage","name","code","active","ShowFlag"),
	array($PRINCIPAL,$EFFACER,$MODIFIER,$LANGUAGE,$CODE,$ACTIVE,$DRAPEAU),
	"100%",
	"",
	"",
	"id",
	"index.php?action=$action"
);
?>

<script>
var HTType="2";
var HTMessage="<?php echo $HT_LANGUAGES;?>";
document.onmousedown = HTMouseDown;
</script>

