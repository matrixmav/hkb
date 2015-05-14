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
	
	if($arrWeblog["logo"] != "")
	{
	
		if(!$IMAGES_IN_DB)
		{
			foreach($image_types as $image_type)
			{
		
				if(file_exists("../uploaded_images/".$AuthUserName."/".$arrWeblog["logo"].".".$image_type[1]))
				{
					unlink("../uploaded_images/".$AuthUserName."/".$arrWeblog["logo"].".".$image_type[1]);
				}
			}
		}
		
		
		SQLDelete("image","image_id",array($arrWeblog["logo"]));
	
		SQLUpdate_SingleValue
		(
			"weblog",
			"user",
			"'$AuthUserName'",
			"logo",
			""
		);
	}
}

?>

<script type="text/javascript" src="wysiwyg/scripts/wysiwyg.js"></script>
<script type="text/javascript" src="wysiwyg/scripts/wysiwyg-settings.js"></script>
<script type="text/javascript">
WYSIWYG.attach('logo_text', small);
</script>	

<table summary="" border="0" width=100%>
	<tr>
		<td>
		
		<table summary="" border="0">
  	<tr>
  		<td>
		<img src="images/icons/folder_upload.png" width="48" height="48" alt="" border="0">
		</td>
  		<td class="blog_admin_header">
		
	
		<?php echo $MODIFY_LOGO;?>
		
		
		</td>
  	</tr>
  </table>
	<br>
	
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

	$SubmitButtonText = $SAUVEGARDER;
	
	$generate_random_file_id = true;
	
	AddEditForm_BA
	(
		array($M_LOGO,$M_LOGO_TEXT),
		array("logo","logo_text"),
		array(),
		array("file","textarea_50_4"),
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

<table summary="" border="0" width=100%>
	<tr>
		<td>
		
		<table summary="" border="0" width=100%>
  	<tr>
  		
  		<td><i><?php echo $YOUR_CURRENT_LOGO;?></i></td>
		<td align=right><a href="index.php?category=<?php echo $category;?>&action=<?php echo $action;?>&ProceedDelete=logo"><?php echo strtoupper($EFFACER);?></a></td>
  	</tr>
  </table>
  <br>
  
  <?php

  $arrWeblog = DataArray("weblog","user='".$AuthUserName."'");
  
 
  if( (trim($arrWeblog["logo"]) == "" || $arrWeblog["logo"] == 0) && trim($arrWeblog["logo_text"]) == "")
  {
  		echo "<br><br><b>".$NO_LOGO_AVAILABLE."</b>";
  }
  else
  {
  
  		if( (trim($arrWeblog["logo"]) == "" || $arrWeblog["logo"] == 0))
		{
				  echo stripslashes($arrWeblog["logo_text"]);
				    
				  echo "<br>";
		}
		else
		{
			if($IMAGES_IN_DB)
			{
				  echo "<img src=\"../image.php?id=".$arrWeblog["logo"]."\">";
			}
			else
			{
				foreach($image_types as $image_type)
				{
			
					if(file_exists("../uploaded_images/".$AuthUserName."/".$arrWeblog["logo"].".".$image_type[1]))
					{
						 echo "<img src=\"../uploaded_images/".$AuthUserName."/".$arrWeblog["logo"].".jpg\">";
						 break;
					}
				}
				
			}
			echo "<br>";
		}
  }
  

  ?>
		
		</td>
	</tr>
</table>
<script>
var HTType="2";
var HTMessage="<?php echo $T_LOGO;?>";
document.onmousedown = HTMouseDown;
</script>
