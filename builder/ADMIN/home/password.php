<?php
if(!isset($iKEY)||$iKEY!="AZ8007"){
	die("ACCESS DENIED");
}
?>
<?php

if(isset($ProceedNewPassword)){
	
	$oArr=DataArray("admin_users","username='$AuthUserName'");
	


	
	if($oArr["password"]!=md5($CAPTCHA_SALT.$oldpassword))
	{
	
		if(true)
		{
		echo '<table width=100%><tr><td class=basictext>
		<font color=red><b>
			'.$PWD_WRONG.'!
			</b></font>
		</td></tr></table><br><br>';
		
		}
		else
		{
		
		echo '
		<script>
			HT("2","'.$PWD_WRONG.'<br>",600,230,0.5,20);
		</script>
		';
		}
		
			$HISTORY=$PWD_CHANGE_ERROR;
	}
	else
	if($newpassword1!=$newpassword2||$newpassword1==""){
		
		
		if(true)
		{
			echo '<table width=100%><tr><td class=basictext>
			<font color=red><b>
			'.$PWD_MISMATCH.'
			</b></font>
			</td></tr></table><br><br>';
			
		}
		else
		{	
			echo '
			<script>
				HT("2","'.$PWD_MISMATCH.'<br>",600,230,0.5,20);
			</script>
		';
		}	
			$HISTORY=$PWD_CHANGE_ERROR;
	}
	else{
	
		SQLUpdate_SingleValue(
				"admin_users",
				"username",
				"'".$AuthUserName."'",
				"password",
				md5($CAPTCHA_SALT.$newpassword1)
			);
		
			echo '<table width=100%><tr><td class=basictext>
			<b>
			'.$PWD_CHANGED.'!
			</b>
			</td></tr></table><br><br>';
			?>
			
			<script>
				setTimeout("document.location.href='index.php?action=exit';", 1000);
			</script>
			
			<?php
			
			$HISTORY=$PWD_CHANGE_SUCCESS;
	}

}

?>

<table summary="" border="0" width=100%>
	<tr>
		<td class=basictext >
		<img src="images/icons<?php echo $DN;?>/key.gif" border="0" width="44" height="24" alt="">
		<b>
	
		<?php echo $CHANGE_PWD_FOR_USER; ?>
		<font color=red>
		
		</font>
		</b>
		<br><br><br>
		<form action="index.php" method=post>
		<input type=hidden name=ProceedNewPassword>
		<input type=hidden name=category value=home>
		<input type=hidden name=action value=password>
		
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
		<!-- Envoyer -->
		<input type=submit value=" <?php echo $SAUVEGARDER;?> " class=adminButton>
		</form>
		
		</td>
	</tr>
</table>

<script>
HT("2","<?php echo $HT_CHANGE_PASSWORD;?>",780,200,1.5,20);
</script>
