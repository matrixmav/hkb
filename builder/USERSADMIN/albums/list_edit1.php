<?php
if(!isset($AuthUserName)||trim($AuthUserName)=="")
{
	die("");
}
?>



	<?php
	$photo_id = $id;
	ms_i($id);
	$arrAlbum =  DataArray("photo","id='".$photo_id."' AND user='".$AuthUserName."'");
	if(!isset($arrAlbum["id"]))
	{
		DieError(1);
	}
	
	if(get_param("picture_delete") != "")
	{
		ms_i(get_param("picture_delete"));
		$arrPicture =  DataArray("photo_images","id='".get_param("picture_delete")."'");
		
		
		if(isset($arrPicture["id"]))
		{
				
			if($arrPicture["photo_id"] != $arrAlbum["id"])
			{
				die("");
			}
		
			SQLDelete("image","image_id",array($arrPicture["image_id"]));
			SQLDelete("photo_images","id",array($picture_delete));
			
			if(!$IMAGES_IN_DB)
			{
				foreach($image_types as $image_type)
				{
					if(file_exists("../uploaded_images/".$AuthUserName."/".$arrPicture["image_id"].".".$image_type[1]))
					{
						unlink("../uploaded_images/".$AuthUserName."/".$arrPicture["image_id"].".".$image_type[1]);
					}
					
					
				}
				
				if(file_exists("../uploaded_images/".$AuthUserName."/thumb_".$arrPicture["image_id"].".jpg"))
				{
						unlink("../uploaded_images/".$AuthUserName."/thumb_".$arrPicture["image_id"].".jpg");
				}
				
			}
		}
	}
	?>

	
<?php
	
if(isset($SpecialProcessEditForm))
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

$photo_id = $id;
ms_i($photo_id);
 


if(OverQuota())
{
?>

<table summary="" border="0" width="100%">
	<tr>
		<td>
		
		<br><br>
		<span class="redtext">
		
		<?php
		echo $M_USER_OVER_QUOTA;
		?>
		
		</span>
		</td>
	</tr>
</table>
<br>
<?php
}
else
{
?>
<table summary="" border="0" width=100%>
	<tr>
		<td>
		
		<table summary="" border="0">
  	<tr>
  		<td width="44">
		<img src="images/icons/folder_upload.png" width="48" height="48" alt="" border="0">
		
  		<td class="blog_admin_header">
		
		
		<?php echo $ADD_NEW_PHOTO;?>
	
		</td>
  	</tr>
  </table>
	<br>
	<?php

	$strSpecialHiddenFieldsToAdd="<input type=hidden name=id value=\"".$id."\"><input type=hidden name=photo_id value=\"".$id."\"> ";

	
$arrNames2 = array("photo_id");
$arrValues2 = array($photo_id);
	
$SelectWidth = 400;
	
if(isset($SpecialProcessAddForm))	
{
	if($_FILES["image_id"]&&$_FILES["image_id"]["tmp_name"]!="")
	{
	
	}
	else
	{
		unset($SpecialProcessAddForm);
	}
}

$tableAlbum = DataTable("photo_images","WHERE photo_id='".$photo_id."'");
while($rowAlbum = mysql_fetch_array($tableAlbum))
	$customArr[] = $rowAlbum;		{
}
$countArray =  count($customArr);
if($countArray < 4)
{
AddNewForm_BA
(
		array("$M_TITLE:","$M_PICTURE:","$M_PLACE:",$DESCRIPTION.":"),
		array("title","image_id","place","description"),
		array("textbox_50","file","textbox_50","textarea_50_10"),

		" $AJOUTER ",
		"photo_images",
		"$IMAGE_ADDED_SUCC<br>"
);
}
?>

		</td>
	</tr>
</table>
	<?php
}
?>	
		
		
		<table summary="" border="0" width=100%>
	<tr>
		<td>
		
		<?php
			
		if(isset($photo_id))
		{
			
			ms_i($photo_id);
			echo "<br><b>".$AVAILABLE_IMAGES." [".$arrAlbum["name"]."]</b><br><br>";
			$tableAlbum = DataTable("photo_images","WHERE photo_id='".$photo_id."'");
			$iFormat = 4;
			
			echo "<center><table width=100% style='border-color:#cecfce;border-width:1px 1px 1px 1px;border-style:solid'>";
			
			$imageCounter = 0;
			
			$boolColor=true;
			
			while($rowAlbum = mysql_fetch_array($tableAlbum))
			{
	
				echo "<tr bgcolor=".($boolColor?"#ffffff":"#efefef").">";
					
				echo "
				<td valign=top>
					<b>".$M_TITLE.":</b><br>
					".$rowAlbum["title"]."
					
					<br><br><b>".$DESCRIPTION.":</b><br>
					".$rowAlbum["description"]."
					<br><br>
					<a href=\"index.php?category=".$category."&folder=".$folder."&page=edit_photo&photo_id=".$rowAlbum["id"]."&id=".$id."\">[".strtoupper($MODIFY)."]</a>
					&nbsp;&nbsp;&nbsp;
					 <a href=\"index.php?category=".$category."&folder=".$folder."&page=".$page."&picture_delete=".$rowAlbum["id"]."&id=".$id."\">[".strtoupper($EFFACER)."]</a>
				</td>
				<td valign=top width=110>";
				
				$strImageUrl = "";
				
				if($IMAGES_IN_DB)
				{
					$strImageUrl = "../image.php?id=".$rowAlbum["image_id"];
				}
				else
				{
					$strImageUrl = "../uploaded_images/".$AuthUserName."/".$rowAlbum["image_id"].".jpg";
				}
				?>
				<a href="<?php echo $strImageUrl;?>" target="_blank">
				<img border=0 src="<?php echo $strImageUrl;?>" width="100" height="100">
				</a>
				
				</td>
				
				</tr>
				
				<?php
				
				$boolColor = !$boolColor; 
					
				$imageCounter++; 
			}
			
			echo "</table></center>";
			
			if($imageCounter == 0)
			{
				echo "[".$NO_IM_AV."]";				
			}
			
		}
		?>
		
		
		</td>
	</tr>
</table>

		
		
<br><br>
<?php
generateBackLink("list");
?>


