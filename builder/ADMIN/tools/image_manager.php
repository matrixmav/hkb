<?php
if(!isset($iKEY)||$iKEY!="AZ8007"){
	die("ACCESS DENIED");
}
?>
<?php
if(isset($EFFACER)&&isset($CheckList))
{
	if(isset($CheckList)&&sizeof($CheckList)>0)
	{
		ms_ia($CheckList);
		SQLDelete("image","image_id",$CheckList);
		SQLDelete("photo_images","image_id",$CheckList);
	}
	
	foreach($CheckList as $id)
	{
		foreach($image_types as $image_type)
		{
			if(file_exists("../blog_images/".$id.".".$image_type[1])) 
			{
					
					unlink("../blog_images/".$id.".".$image_type[1]);
					
			}
		}
	}
}
?>
<br>
<table summary="" border="0" width="100%">
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
<table summary="" border="0" width=100%>
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
RenderTable
(
	"image",
	array("image_name","image_date","image_size","image_id"),
	array($NOM,$DATE_MESSAGE,$SIZE,$IMAGE),
	"100%",
	"",
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
