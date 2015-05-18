<?php
if(!isset($iKEY)||$iKEY!="AZ8007"){
	die("ACCESS DENIED");
}
?>
<?php

if(isset($ProceedNewPassword)){
	
	$oArr=DataArray("admin_users","username='$AuthUserName'");
	
	if($oArr["password"]!=md5($CAPTCHA_SALT.$oldpassword)){
	
		
		echo '<br><table width=100%><tr><td class=basictext>
		<font color=red><b>
			'.$PWD_WRONG.'
			</b></font>
		</td></tr></table><br>';
		
		
	}
	else
	if($newpassword1!=$newpassword2){
		
		
		
			echo '<br><table width=100%><tr><td class=basictext>
			<font color=red><b>
			'.$PWD_MISMATCH.'
			</b></font>
			</td></tr></table><br>';
			
		
	}
	else{
	
		SQLUpdate_SingleValue(
				"admin_users",
				"username",
				"'".$AuthUserName."'",
				"password",
				md5($CAPTCHA_SALT.$newpassword1)
			);
			
			echo '
					<script>
						
							setTimeout("document.location.href=\'../index.php\'",1000);
						</script>
					';
			
	}

}

?>
<table summary="" border="0" width=100%>
	<tr>
		<td class=basictext width="49" >
		<img src="images/icons/unlock.png" border="0" width="48" height="48" alt="">
		</td>
		<td class="blog_admin_header">
		
	
		
		<?php echo $CHANGE_PWD_FOR_USER; ?>
	
		
		</td>
	</tr>
</table>


<table summary="" border="0" width=100%>
	<tr>
		<td class=basictext >
		
	
		
		<br>
		<form action="index.php" method=post>
		<input type="hidden" name="ProceedNewPassword" value="1">
		<input type="hidden" name="category" value="<?php echo $category;?>">
		<input type="hidden" name="action" value="<?php echo $action;?>">
		
		<table summary="" border="0">
  	<tr>
  		<td class=basictext><?php echo $CURRENT_PWD; ?>:</td>
  		<td class=basictext><input type=password name=oldpassword size=20></td>
  	</tr>
	<tr height=30>
  		<td class=basictext>&nbsp;</td>
  		<td class=basictext>&nbsp;</td>
  	</tr>
  	<tr>
  		<td class=basictext><?php echo $NEW_PWD;?>:</td>
  		<td class=basictext><input type=password name=newpassword1 size=20></td>
  	</tr>
  	<tr>
  		<td class=basictext><?php echo $CONFIRM_PWD;?>: </td>
  		<td class=basictext><input type=password name=newpassword2 size=20></td>
  	</tr>
  </table>
  
		<br><br>
		
		<input type=submit value=" <?php echo $SAUVEGARDER;?> " class=adminButton>
		</form>
		
		</td>
	</tr>
</table>
<script>
var HTType="2";
var HTMessage="<?php echo $T_CHANGE_PWD;?>";
document.onmousedown = HTMouseDown;
</script>
