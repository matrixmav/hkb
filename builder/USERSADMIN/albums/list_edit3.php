<?php
if(!isset($AuthUserName)||trim($AuthUserName)=="")
{
	die("");
}
ms_i($id);
?>
<?php


$arrHomeAlbumFormatDescription = array();
$arrHomeAlbumFormatDescription[1] = $THUMB_ONLY;
$arrHomeAlbumFormatDescription[2] = $THUMB_DESC;
$arrHomeAlbumFormatDescription[3] = $PH_INTRODUCTION;
$arrHomeAlbumFormatDescription[4] = $NO_START_PAGE;

$arrAlbumFormatDescription = array();
$arrAlbumFormatDescription[1] = $THUMB_IND_PAGES;
$arrAlbumFormatDescription[2] = $PAGES_1_COL;
$arrAlbumFormatDescription[3] = $PAGES_2_COL;
$arrAlbumFormatDescription[4] = $NO_PAGES;
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

		
		
<table summary="" border="0" width=100%>
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

<table summary="" border="0" width=100%>
	<tr>
		<td>
		
		<input type=submit value=" <?php echo $SAUVEGARDER;?>  " class=adminButton>
		</td>
	</tr>
</table>
</form>
<br><br>
<?php
generateBackLink("list");
?>

