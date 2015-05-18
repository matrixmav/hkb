<?php
if(!isset($AuthUserName)||trim($AuthUserName)=="")
{
	die("");
}
?>
<table summary="" border="0" width=100%>
	<tr>
		<td>

<table summary="" border="0" width=100%>
	<tr>
		<td>
		
		<?php
		
		$photo_id = $id;
		
		if(isset($photo_id))
		{
			$arrAlbum =  DataArray("photo","id='".$photo_id."'");
			
			echo "Preview album [".$arrAlbum["name"]."]<br><br>";
			$tableAlbum = DataTable("photo_images","WHERE photo_id='".$photo_id."'");
			$iFormat = $arrAlbum["format"];
			
			echo "<table>";
			
			$imageCounter = 0;
			
			while($rowAlbum = mysql_fetch_array($tableAlbum))
			{
			
				if($imageCounter==0||$imageCounter%$iFormat==0)
				{
					echo "<tr>";
				}
				
				echo "
				
				<td valign=top>
				<a href=../image.php?id=".$rowAlbum["image_id"]." target=_blank>
				<img src=../image.php?id=".$rowAlbum["image_id"]." width=100 height=100>
				</a>
				<br>
				".$rowAlbum["description"]."
				</td>
				
				";

							
				if($imageCounter!=0&&($imageCounter+1)%$iFormat==0)
				{
					echo "</tr>";
				}
								
				$imageCounter++; 
			}
			
			echo "</table>";
			
		}
		?>
		
		
		</td>
	</tr>
</table>
<br><br>

<?php
generateBackLink("list");
?>
&nbsp;</td>
	</tr>
</table>
