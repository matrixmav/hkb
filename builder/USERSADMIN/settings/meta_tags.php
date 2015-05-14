<?php
if(!isset($AuthUserName)||trim($AuthUserName)=="")
{
	die("");
}
?>


<table summary="" border="0" width=100%>
	<tr>
		<td>
		
		<table summary="" border="0">
  	<tr>
  		<td>
		<img src="images/icons/globe.png" width="48" height="48" alt="" border="0">
		</td>
  		<td class="blog_admin_header">
		
	
		<?php echo $MODIFY_META;?>
		
		
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

$MessageTDLength = 150;
AddEditForm_BA
(
	array($M_META_DESCRIPTION,$M_META_KEYWORDS),
	array("meta_description","meta_keywords"),
	array(),
	array("textarea_42_4","textarea_42_4"),
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
<script>
var HTType="2";
var HTMessage="<?php echo $T_META_TAGS;?>";
document.onmousedown = HTMouseDown;
</script>
