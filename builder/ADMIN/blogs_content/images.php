<?php
if(!isset($iKEY)||$iKEY!="AZ8007")
{
	die("ACCESS DENIED");
}
?>
<?php
if(isset($Delete))
{
	if(isset($CheckList)&&sizeof($CheckList)>0)
	{
		ms_ia($CheckList);
		SQLDelete("image","image_id",$CheckList);
		SQLDelete("photo_images","image_id",$CheckList);
	}
	
	foreach($CheckList as $id)
	{
		ms_i($id);
		foreach($image_types as $image_type)
		{
			if(file_exists("../uploaded_images/".$id.".".$image_type[1])) 
			{
					
					unlink("../uploaded_images/".$id.".".$image_type[1]);
					
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


<br>

<?php


RenderTable
(
	"image",
	array("user","image_name","image_date","image_size","image_id"),
	array("User",$NOM,$DATE_MESSAGE,$SIZE,$IMAGE),
	"100%",
	"WHERE user<>'' AND user<>'administrator' ORDER BY image_date DESC ",
	$EFFACER,
	"image_id",
	"index.php?action=".$action."&category=".$category
);
?>

