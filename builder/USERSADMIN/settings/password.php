<?php
if(!isset($iKEY)||$iKEY!="AZ8007"){
	die("ACCESS DENIED");
}
?>


<table summary="" border="0" width=100%>
	<tr>
		<td class=basictext width="49" >
		<img src="images/icons/folder_private.png" border="0" width="48" height="48" alt="">
		</td>
		<td class="blog_admin_header">
		
	
		<?php echo $M_PASSWORD_PROTECT_BLOG; ?>
		
		</td>
	</tr>
</table>
<br><br>
<?php
$SubmitButtonText = $SAUVEGARDER;
 AddEditForm_BA
(
	array($M_PASSWORD),
	array("card_name"),
	array(""),
	array("textbox_30"),
	"admin_users",
	"username",
	"'".$AuthUserName."'",
	$LES_VALEURS_MODIFIEES_SUCCES
);


?>
<br><br><br>
<table summary="" border="0" width="100%">
	<tr>
		<td class="basictext"  >
		<i>
		<?php
			echo $M_PASSWORD_PROTECT_LEAVE_EMPTY;
		?>
		</i>
		</td>
	</tr>
</table>
