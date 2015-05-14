<?php
if(!isset($AuthUserName)||trim($AuthUserName)=="")
{
	die("");
}
?>

<?php

if(isset($Delete))
{
	
	if(isset($CheckList)&&sizeof($CheckList)>0)
	{
		ms_ia($CheckList);
		
		foreach($CheckList as $CheckID)
		{
			ms_i($CheckID);
			$arrAlbum =  DataArray("photo","id=".$CheckID." AND user='".$AuthUserName."'");
	
			if(isset($arrAlbum["id"]))
			{
				$albumPictures =  DataTable_Query("SELECT image_id FROM ".$DBprefix."photo_images WHERE photo_id=".$arrAlbum["id"]);
			
				while($current_picture = mysql_fetch_array($albumPictures))
				{
					SQLDelete("image","image_id",array($current_picture["image_id"]));
					SQLDelete("photo_images","id",array($current_picture["image_id"]));
				
					if(!$IMAGES_IN_DB)
					{
						foreach($image_types as $image_type)
						{
							if(file_exists("../uploaded_images/".$AuthUserName."/".$arrPicture["image_id"].".".$image_type[1]))
							{
								unlink("../uploaded_images/".$AuthUserName."/".$arrPicture["image_id"].".".$image_type[1]);
							}
						}
						
					}
					
				}
			}
		}
	
		SQLDeletePlus("photo","id",$CheckList);
		
	}

}

?>


<table summary="" border="0" width=100%>
	<tr>
		<td width=32>
		
		<img src="images/icons/photo.png" width="48" height="48" alt="" border="0">
		</td>
		<td class="blog_admin_header"><?php echo $CREATE_NEW_PHOTO;?></td>
	</tr>
</table>

<br>
<?php

if(isset($SpecialProcessAddForm))
{
	SQLUpdate_SingleValue
	(
	"admin_users",
	"username",
	"'$AuthUserName'",
	"last_update",
	time()
	);
}


$arrNames2=array("user","date");
$arrValues2=array($AuthUserName,time());

$SelectWidth=400;

AddNewForm_BA(
		array($NOM.":",$DESCRIPTION.":"),
		
		array("name","description"),

		array("textbox_67","textarea_50_6"),

		" $M_CREATE ",
		"photo",
		"$ALBUM_CREATED<br>"
	);
?>

<br><br>

<?php
if(SQLCount("photo", "WHERE user='".$AuthUserName."'") == 0)
{
	
}
else
{
	RenderTable_BA
	(
		"photo",
		array("name","description"),
		array($NOM,$DESCRIPTION),
		"100%",
		"WHERE user='".$AuthUserName."' ORDER BY id DESC",
		$EFFACER,
		"id",
		"index.php?action=".$action."&category=".$category
	);
}
?>
<script>
var HTType="1";
var HTMessage="<?php echo $T_ALBUMS_CREATE;?>";
document.onmousedown = HTMouseDown;
</script>
