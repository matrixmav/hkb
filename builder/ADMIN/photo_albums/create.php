<?php
if(aParameter(13) == "YES")
{
?>
<script language="javascript" type="text/javascript" src="jscripts/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript">tinyMCE.init({mode : "textareas",theme : "simple"});</script>
<?php
}
?>

<?php

if(isset($EFFACER))
{
	
	if(isset($CheckList)&&sizeof($CheckList)>0)
	{
	
		SQLDelete("photo","id",$CheckList);
	
	}

}

?>



<table summary="" border="0" width=750>
	<tr>
		<td width=52>
		
		<img src="images/icons<?php echo $DN;?>/wizard.gif" width="31" height="38" alt="" border="0">
		</td>
		<td>&nbsp;<b><?php echo $CREATE_NEW_ALBUM;?></b></td>
	</tr>
</table>

<br>

<?php

$arrNames2=array("user","date");
$arrValues2=array($AuthUserName,time());



AddNewForm(
		array($NOM.":",$DESCRIPTION.":"),
		
		array("name","description"),

		array("textbox_54","textarea_40_6"),

		" $M_CREATE ",
		"photo",
		$PHOTO_ALBUM_CREATED."<br>"
	);
?>

<br><br>

<?php

RenderTable(
						"photo",
						array("name","description"),
						array($NOM,$DESCRIPTION),
						550,
						"WHERE user='".$AuthUserName."' AND name<>'manager' ORDER BY id DESC",
						$EFFACER,
						"id",
						"index.php?action=".$action."&category=".$category
);
?>

