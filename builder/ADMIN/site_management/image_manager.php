<?php
if(!isset($iKEY)||$iKEY!="AZ8007"){
	die("ACCESS DENIED");
}
?>
<?php
if(isset($EFFACER))
{
	if(isset($CheckList)&&sizeof($CheckList)>0)
	{
		SQLDelete("image","image_id",$CheckList);
	}
	
	$strDeletedList = "";
	
	foreach($CheckList as $strID)
	{
		$strDeletedList .= $strID . ",";
	}
	
	$HISTORY = $IMAGE_DELETED.$strDeletedList;
}
?>
<br>
<table summary="" border="0" width=750>
	<tr>
		<td width=50>
		<img src="images/icons<?php echo $DN;?>/open.gif" width="44" height="32" alt="" border="0">
		
		</td>
		<td>
		<b><?php echo $MANAGE_AVAILABLE_IMAGES;?></b>
		</td>
	</tr>
</table>
<br>
<?php
if(true)
{
?>
<br>
<table summary="" border="0" width=750>
	<tr>
		<td>
			
			<b><?php echo $ADD_NEW_IMAGE;?></b>
			
		</td>
	</tr>
</table>

<br>
<div id="AddNewImage" >
<?php

$DoNotInsert = true;

AddNewForm
(
		array($IMAGE.":"),
		array("image_id"),
		array("file"),

		" $AJOUTER ",
		"image",
		"<font color=#313031>".$IMAGE_ADDED_SUCCESSFULLY."</font><br>
		<br>
	
		</a>
		"
);
?>
</div>
<?php
}
?>

<br>

<?php


RenderTable(
						"image",
						array("image_name","image_date","image_size","image_id"),
						array($NOM,$DATE_MESSAGE,$SIZE,$IMAGE),
						750,
						"ORDER BY image_id DESC",
						$EFFACER,
						"image_id",
						"index.php?action=".$action."&category=".$category
);
?>


<script>
var HTType="2";
var HTMessage="<?php echo $IMAGE_MANAGER_EXPLANATION;?>";
document.onmousedown = HTMouseDown;
</script>