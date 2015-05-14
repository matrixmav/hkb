<?php
if(!isset($AuthUserName)||trim($AuthUserName)=="")
{
	die("");
}

?>
<?php
if(get_param("ProceedDelete") != "")
{
	$arrWeblog = DataArray("weblog","user='".$AuthUserName."'");
	
	if($arrWeblog["author_image"] != "")
	{
	
		if(!$IMAGES_IN_DB)
		{
			foreach($image_types as $image_type)
			{
				if(file_exists("../blog_images/".$AuthUserName."/".$arrWeblog["author_image"].$image_type[1]))
				{
					unlink("../blog_images/".$AuthUserName."/".$arrWeblog["author_image"].$image_type[1]);
					break;
				}
			}
		}
		
		SQLDelete("image","image_id",$arrWeblog["author_image"]);
	
		SQLUpdate_SingleValue
		(
			"weblog",
			"user",
			"'$AuthUserName'",
			"author_image",
			""
		);
	}
}

?>


<script type="text/javascript" src="wysiwyg/scripts/wysiwyg.js"></script>
<script type="text/javascript" src="wysiwyg/scripts/wysiwyg-settings.js"></script>	
<script type="text/javascript">
WYSIWYG.attach("author", small);
</script>
<?php
if(SQLCount("weblog","WHERE user='$AuthUserName'")==0)
{
	SQLInsert("weblog",array("user"),array($AuthUserName));
}
?>

<table summary="" border="0" width="100%">
	<tr>
		<td>
		
		<table summary="" border="0">
  	<tr>
  		<td>
		<img src="images/icons/folder_user.png" width="48" height="48" alt="" border="0">
		</td>
  		<td class="blog_admin_header">
		
		
		<?php echo $DESCRIPTION_AUTHOR;?>
	
		</td>
  	</tr>
  </table>
	<br>
	
<?php
$MessageTDLength = 120;
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

	$SelectWidth=300;
	$MessageTDLength=130;
	
	$SubmitButtonText = $SAUVEGARDER;
	AddEditForm_BA
	(
		array($DESCRIPTION,$IMAGE,$M_PREFERRED_IMAGE_WIDTH,$M_PREFERRED_IMAGE_HEIGHT),
		array("author","author_image","author_image_width","author_image_height"),
		array(),
		array("textarea_50_6","file","textbox_5","textbox_5"),
		"weblog",
		"user",
		"'".$AuthUserName."'",
		$LES_VALEURS_MODIFIEES_SUCCES
	);
?>
		
		</td>
	</tr>
</table>
<br><br>

<table summary="" border="0" width="100%">
	<tr>
		<td>
		
			<table summary="" border="0" width="100%">
			<tr>
				
				<td><i><?php echo $YOUR_PERSONAL_INFO;?></i></td>
				
				<td align=right><a href="index.php?category=<?php echo $category;?>&action=<?php echo $action;?>&ProceedDelete=logo"><?php echo strtoupper($IMAGE)." - ".strtoupper($EFFACER);?></a></td>
				
			</tr>
		  </table>
  <br>
  
  <?php
  
  $arrWeblog = DataArray("weblog","user='".$AuthUserName."'");
  
  if($arrWeblog["author_image"] == "0")
  {
  	echo "<img src=\"images/no_pic.gif\">";
  }
  else
  {
	echo ShowImage($arrWeblog["author_image"],$AuthUserName , "", ($arrWeblog["author_image_width"]!=""?$arrWeblog["author_image_width"]:"120"), ($arrWeblog["author_image_height"]!=""?$arrWeblog["author_image_height"]:"160"), "../");

  }
  
  echo "<br><br>";
  
  echo $arrWeblog["author"];
  ?>
		
		</td>
	</tr>
</table>


<script>
var HTType="2";
var HTMessage="<?php echo $T_PHOTO;?>";
document.onmousedown = HTMouseDown;
</script>
