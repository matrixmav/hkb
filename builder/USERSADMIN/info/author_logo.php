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
								if(file_exists($UPLOAD_DIR.$arrWeblog["author_image"].".".$image_type[1]))
								{
									unlink($UPLOAD_DIR.$arrWeblog["author_image"].".".$image_type[1]);
								}
						}
		}
		
		SQLDelete("image","image_id",array($arrWeblog["author_image"]));
	
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


<script language="javascript" type="text/javascript" src="jscripts/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript">
tinyMCE.init({
	mode : "textareas",
	theme : "advanced",
	theme_advanced_buttons1 : "bold,italic,underline,separator,strikethrough,justifyleft,justifycenter,justifyright, justifyfull,bullist,numlist,undo,redo,link,unlink",
	theme_advanced_buttons2 : "fontselect,fontsizeselect,forecolor",
	theme_advanced_buttons3 : "",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	
	extended_valid_elements : "a[name|href|target|title|onclick],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]"
});
</script>
<?php
if(SQLCount("weblog","WHERE user='$AuthUserName'")==0)
{

	SQLInsert("weblog",array("user"),array($AuthUserName));
	
}
?>

<table summary="" border="0" width=100%>
	<tr>
		<td>
		
		<table summary="" border="0">
  	<tr>
  		<td>
		<img src="images/icons/write.gif" width="49" height="45" alt="" border="0">
		</td>
  		<td>
		
		<b>
		<?php echo $DESCRIPTION_AUTHOR;?>
		</b>
		
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

	$SubmitButtonText = $SAUVEGARDER;
	AddEditForm
	(
					array($DESCRIPTION,$IMAGE,$M_PREFERRED_IMAGE_WIDTH,$M_PREFERRED_IMAGE_HEIGHT),
					array("author","author_image","author_image_width","author_image_height"),
					array(),
					array("textarea_50_10","file","textbox_5","textbox_5"),
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
  		<td width="31" ><img src="images/icons/wizard.gif" width="31" height="38" alt="" border="0">&nbsp;</td>
  		<td><b><?php echo $YOUR_PERSONAL_INFO;?></b></td>
		
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
  	echo "<a href=\"../image.php?id=".$arrWeblog["author_image"]."\" target=_blank><img border=0 src=\"../image.php?id=".$arrWeblog["author_image"]."\" width=".($arrWeblog["author_image_width"]!=""?$arrWeblog["author_image_width"]:"120")." height=".($arrWeblog["author_image_height"]!=""?$arrWeblog["author_image_height"]:"160")."></a>";
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
