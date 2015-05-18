<?php
$key=get_param("key");
if(trim($key)!="")
{

?>
	<br>
	<?php
	if(isset($ProceedSend)&&trim($key)!="")
	{
		if(SQLCount("admin_users","WHERE email='".get_param("user_email")."' AND activation_code='".$key."'  AND activation_code<>''") == 1)
		{
			if($password!=$password2)
			{
		
				echo '<b>
				'.$PWD_MISMATCH.'
				</b><br>';
					
			}
			else
			{
				SQLQuery
				(
					"
						UPDATE ".$DBprefix."admin_users
						SET 
						password = '".md5($CAPTCHA_SALT.$password)."',
						activation_code = ''
						WHERE 
						activation_code = '".$key."'
						AND email='".$user_email."'
					"
				);
			
				
				echo '<b>
				'.$PWD_CHANGED.'
				</b><br>';
				
			}
		}
		else
		{
			echo "<b>".$M_WRONG_EMAIL_ADDRESS."</b>";
		}
	}
	else
	{
	?>

	<i>
	<?php
	echo $M_RESET_PWD_WELCOME_BACK;
	?>
	</i>
	<br><br>
	<form action="index.php" method="post">
	<input type="hidden" name="key" value="<?php echo $key;?>">
	<?php
	if(isset($mod))
	{
	?>
	<input type="hidden" name="mod" value="<?php echo $mod;?>">
	<?php
	}
	?>
	<?php
	if(isset($page))
	{
	?>
	<input type="hidden" name="page" value="<?php echo $page;?>">
	<?php
	}
	?>
	<input type="hidden" name="ProceedSend" value="1">
	<table>
		<tr>
			<td>
				<?php echo $EMAIL;?>:  
			</td>
			<td>
				<input type="text" size="20" name="user_email" value="<?php echo get_param("user_email");?>"> 
			</td>
		</tr>
		<tr>
			<td>
				<?php echo $CREATE_PASSWORD;?>:  
			</td>
			<td>
				<input type="password" size="20" name="password"> 
			</td>
		</tr>
		<tr>
			<td>
				<?php echo $CONFIRM_PASSWORD;?>:  
			</td>
			<td>
				<input type="password" size="20" name="password2"> 
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<br>
				<input type="submit" value=" <?php echo $M_SEND;?> " class="interface_button" >
				
			</td>
		</tr>
	</table>
		
	</form>

	<?php
	}
	?>

<?php
}
?>

