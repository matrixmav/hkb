
	<?php

	$photo_id = $id;
	$arrAlbum =  DataArray("photo","id='".$photo_id."'");
	
	if(isset($picture_delete))
	{
		$arrPicture =  DataArray("photo_images","id='".$picture_delete."'");
		
		if(isset($arrPicture["id"]))
		{
			SQLDelete("image","image_id",array($arrPicture["image_id"]));
			SQLDelete("photo_images","id",array($picture_delete));
		}
	}
	?>

<table summary="" border="0" width=750>
	<tr>
		<td>
		
		<table summary="" border="0">
  	<tr>
  		<td>
		<img src="images/icons<?php echo $DN;?>/email.gif" width="40" height="34" alt="" border="0">
		</td>
  		<td>
		
		<b>
		<?php echo $ADD_PHOTO_TO;?> [<?php echo $arrAlbum["name"];?>]
		</b>
		
		</td>
  	</tr>
  </table>
	<br>
	<?php

	$strSpecialHiddenFieldsToAdd="<input type=hidden name=id value=\"".$id."\"> ";


	$arrNames2=array("photo_id");
	$arrValues2=array($id);
AddNewForm
(
	
		array($M_TITLE.":",$IMAGE.":",$M_PLACE.":",$M_LEGEND.":",$DESCRIPTION.":",$DATE_MESSAGE.":"),
		array("title","image_id","place","legend","description","date"),
		array("textbox_50","file","textbox_50","textbox_50","textarea_37_4","textbox_50"),

		" $AJOUTER ",
		"photo_images",
		"<font color=#313031>$IMAGE_ADDED_SUCCESS</font><br>
		<br>
		<a href=\"index.php?category=modules&folder=album&page=edit5&id=".$id."\">
		$CLICK_ADD
		</a>
		"
);
?>

		</td>
	</tr>
</table>
		
		
		<table summary="" border="0" width=750>
	<tr>
		<td>
		
		<?php
		
		
		if(isset($photo_id))
		{
			
			
			echo "<br><b>$AVAILABLE_IMAGES_IN [".$arrAlbum["name"]."]</b><br><br>";
			$tableAlbum = DataTable("photo_images","WHERE photo_id='".$photo_id."'");
			$iFormat = 4;
			
			echo "<center><table width=750 style='border-color:#cecfce;border-width:1px 1px 1px 1px;border-style:solid'>";
			
			$imageCounter = 0;
			
			$boolColor=true;
			
			while($rowAlbum = mysql_fetch_array($tableAlbum))
			{
			
			
				//if($imageCounter==0||$imageCounter%$iFormat==0)
				//{
					echo "<tr bgcolor=".($boolColor?"#ffffff":"#efefef").">";
				//}
				
				echo "
				<td valign=top>
					<b>".$M_TITLE.":</b><br>
					".$tableAlbum["title"]."
					
					<br><br><b>".$DESCRIPTION.":</b><br>
					".$tableAlbum["description"]."
					<br><br>
					<a href=\"index.php?category=modules&folder=album&page=edit_photo&photo_id=".$rowAlbum["id"]."&id=".$id."\">[".strtoupper($MODIFY)."]</a>
					&nbsp;&nbsp;&nbsp;
					 <a href=\"index.php?category=modules&folder=album&page=edit5&picture_delete=".$rowAlbum["id"]."&id=".$id."\">[".strtoupper($EFFACER)."]</a>
				</td>
				<td valign=top width=110>
				<a href=../image.php?id=".$rowAlbum["image_id"]." target=_blank>
				<img border=0 src=../image.php?id=".$rowAlbum["image_id"]." width=100 height=100>
				</a>
				
				</td>
				
				";

							
				//if($imageCounter!=0&&($imageCounter+1)%$iFormat==0)
				//{
					echo "</tr>";
				//}
				
				$boolColor = !$boolColor; 
					
				$imageCounter++; 
			}
			
			echo "</table></center>";
			
			if($imageCounter == 0)
			{
				echo "[$NO_IMAGES]";				
			}
			
		}
		?>
		
		
		</td>
	</tr>
</table>

		
<br><br>
<?php
generateBackLink("album");
?>


