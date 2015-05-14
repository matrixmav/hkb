<?php
if(!isset($AuthUserName)||trim($AuthUserName)=="")
{
	die("");
}

	$imageCounter = 0;
?>

<script>
function DeleteImage(y,x)
{
	if(confirm("<?php echo $M_ARE_YOU_SURE;?>"))	
	{
		document.location.href="index.php?category=<?php echo $category;?>&action=<?php echo $action;?>&xtype="+y+"&delim="+x;
	}
}
</script>

<?php

if(isset($delim))
{
	ms_i($delim);
	
		if($xtype==2)
		{
			SQLQuery("DELETE FROM ".$DBprefix."image WHERE image_id=".$delim."");
		}
		else
		if($xtype==3)
		{
			SQLQuery("DELETE FROM ".$DBprefix."photo_images WHERE image_id=".$delim."");
		}
		
		if(!$IMAGES_IN_DB)
		{
			foreach($image_types as $image_type)
			{
				if(file_exists("../uploaded_images/".$AuthUserName."/".$delim.".".$image_type[1]))
				{
					unlink("../uploaded_images/".$AuthUserName."/".$delim.".".$image_type[1]);
				}
			}
		}
	
		
		
	
}
?>


<?php
$tableImages = DataTable("image","WHERE user='".$AuthUserName."'");

?>

<table summary="" border="0" width=100%>
	<tr>
		<td>
		
<?php

	while($arrImage = mysql_fetch_array($tableImages))
	{
		if(!$IMAGES_IN_DB&&!file_exists('../uploaded_images/'.$AuthUserName.'/'.$arrImage["image_id"].'.jpg'))
		{
			continue;
		}
				
		if($imageCounter % 4 ==0)
		{
			echo '<tr>';
		}
		
			echo '
		
				<td valign="top" width="230">
				';
				
			if($IMAGES_IN_DB)
			{
				echo '<img src="../image.php?id='.$arrImage["image_id"].'&w=230&h=180" width="230" height="180">';
			}
			else
			{
				echo '<img src="../uploaded_images/'.$AuthUserName.'/'.$arrImage["image_id"].'.jpg" width="230" height="180">';
			}
				
			echo '
			
			&nbsp;</td>
				<td valign="top">
					<a href="javascript:DeleteImage(2,'.$arrImage["image_id"].')"><img src="images/cancel.gif" width="21" height="20" alt="" border="0"></a>	
				</td>
		  
		  ';
		
		if(($imageCounter+1) % 4 ==0)
		{
			echo '</tr>';
		}
			
		$imageCounter++; 
	}
	
	echo '</table>';
	
	if($imageCounter == 0)
	{
		echo "<br>[".$NO_IM_AV."]";				
	}
	
	echo "<br>";

?>

		
		</td>
	</tr>
</table>
<?php









if(SQLCount("photo", "WHERE user='".$AuthUserName."'") == 0)
{

}
else
{
	echo '<br><table summary="" border="0" width="100%" cellspacing="0" cellpadding="0">
	<tr>
		<td><i>'.$PHOTO_ALBUMS.'</td>
	</tr>
</table><br>';

	$tableAlbums = DataTable("photo","WHERE user='".$AuthUserName."'");

	while($arrAlbum = mysql_fetch_array($tableAlbums))
	{
	?>

	<table summary="" border="0" width=100%>
		<tr>
			<td>
			
			<?php
		
				echo "<b>".strtoupper($M_ALBUM)." ".strtoupper($arrAlbum["name"])."</b><br>	<hr width=100% color=#636563>";
				
				$photo_id = $arrAlbum["id"];
					
				
				$tableAlbum = DataTable("photo_images","WHERE photo_id='".$photo_id."'");
				$iFormat = 4;
							
			
				
				$boolColor=true;
				
				
				echo '
						<table summary="" border="0" >';
						
				while($rowAlbum = mysql_fetch_array($tableAlbum))
				{
					if(!$IMAGES_IN_DB&&!file_exists('../uploaded_images/'.$AuthUserName.'/'.$rowAlbum["image_id"].'.jpg'))
					{
						continue;
					}
					
					
					if($imageCounter % 4 ==0)
					{
						echo '<tr>';
					}
					
						echo '
					
							<td valign="top" width="230">
							';
							
						if($IMAGES_IN_DB)
						{
							echo '<img src="../image.php?id='.$rowAlbum["image_id"].'&w=230&h=180" width="230" height="180">';
						}
						else
						{
							echo '<img src="../uploaded_images/'.$AuthUserName.'/'.$rowAlbum["image_id"].'.jpg" width="230" height="180">';
			
					
						}
							
						echo '
						
						&nbsp;</td>
							<td valign="top">
								<a href="javascript:DeleteImage(3,'.$rowAlbum["image_id"].')"><img src="images/cancel.gif" width="21" height="20" alt="" border="0"></a>	
							</td>
					  
					  ';
					
					if(($imageCounter+1) % 4 ==0)
					{
						echo '</tr>';
					}
						
					$imageCounter++; 
				}
				
				echo '</table>';
				
				if($imageCounter == 0)
				{
					echo "<br>[".$NO_IM_AV."]";				
				}
				
				echo "<br>";
			
			?>
			
			
			</td>
		</tr>
	</table>
	<?php
}
}
?>
