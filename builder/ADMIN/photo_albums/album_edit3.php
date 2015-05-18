<?php


$arrHomeAlbumFormatDescription = array();
$arrHomeAlbumFormatDescription[1] = $MA1;
$arrHomeAlbumFormatDescription[2] = $MA2;
$arrHomeAlbumFormatDescription[3] = $MA3;
$arrHomeAlbumFormatDescription[4] = $MA4;

$arrAlbumFormatDescription = array();
$arrAlbumFormatDescription[1] = $MA5;
$arrAlbumFormatDescription[2] = $MA6;
$arrAlbumFormatDescription[3] = $MA7;
$arrAlbumFormatDescription[4] = $MA8;

?>

<?php
if(isset($ProceedUpdate))
{

	
	SQLUpdate_SingleValue(
				"photo",
				"id",
				"$id",
				"album_format",
				$format
			);
}

$format=getSingleValue(
				"photo",
				"id",
				"$id",
				"album_format"
			
			);

?>
<br>



<form action=index.php method=post>
<input type=hidden name=ProceedUpdate>
<input type=hidden name=page value="<?php echo $page;?>">
<input type=hidden name=folder value="<?php echo $folder;?>">
<input type=hidden name=category value="<?php echo $category;?>">
<input type=hidden name=id value="<?php echo $id;?>">

		
		
<table summary="" border="0" width=750>
	<tr>
		<td width=25% align=center>
		
					<table summary="" border="0">
				  	<tr>

				  		<td align=center>
						
						<?php
							echo $arrAlbumFormatDescription[1];
						?>
						<br><br>
						<img src="images/format/format_albums/1.gif" width="108" height="74" alt="" border="0">
						<br><br>
						<input type=radio name=format value=1 <?php if($format==1) echo "checked";?>>
						
						
						</td>
				  	</tr>
				  </table>
		
		
		</td>
		<td width=25% align=center>
		
			<table summary="" border="0">
				  	<tr>
	
				  		<td align=center>
						<?php
							echo $arrAlbumFormatDescription[2];
						?>
						<br>
						<img src="images/format/format_albums/2.gif" width="108" height="74" alt="" border="0">
						<br><br>
						<input type=radio name=format value=2 <?php if($format==2) echo "checked";?>>
						
						</td>
				  	</tr>
				  </table>
		</td>
		<td width=25% align=center>
			<table summary="" border="0">
				  	<tr>
	
				  		<td align=center>
						<?php
							echo $arrAlbumFormatDescription[3];
						?>
						<br><br>
						<img src="images/format/format_albums/3.gif" width="108" height="74" alt="" border="0">
						<br><br>
						<input type=radio name=format value=3 <?php if($format==3) echo "checked";?>>
						
						</td>
				  	</tr>
				  </table>
				  
				  
		</td>
		<td width=25% align=center>
		
			<table summary="" border="0">
				  	<tr>
	
				  		<td align=center>
						<?php
							echo $arrAlbumFormatDescription[4];
						?>
						<br><br>
						<img src="images/format/format_albums/4.gif" width="108" height="74" alt="" border="0">
						<br><br>
						<input type=radio name=format value=4 <?php if($format==4) echo "checked";?>>
						
						</td>
				  	</tr>
				  </table>
				  
			
				
		</td>
	</tr>
</table>


<br><br><br>

<table summary="" border="0" width=750>
	<tr>
		<td>
		
		<input type=submit value=" Save  " class=adminButton>
		</td>
	</tr>
</table>
</form>
<br><br>
<?php
generateBackLink("album");
?>


