<?php
if(!isset($AuthUserName)||trim($AuthUserName)=="")
{
	die("");
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
  		<td><img src="images/icons/clipboard.gif" width="40" height="38" alt="" border="0"></td>
  		<td>
		
		<b>
		<?php echo $DESCRIPTION_BLOG;?>
		</b>
		
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
	AddEditForm
	(
					array($DESCRIPTION),
					array("description"),
					array(),
					array("textarea_50_10"),
					"weblog",
					"user",
					"'".$AuthUserName."'",
					$LES_VALEURS_MODIFIEES_SUCCES
	);
?>
		
		</td>
	</tr>
</table>

<script>
var HTType="1";
var HTMessage="<?php echo $T_BLOG_DESCRIPTION;?>";
document.onmousedown = HTMouseDown;
</script>
