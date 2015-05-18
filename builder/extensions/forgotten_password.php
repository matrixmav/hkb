<br><br><br>
<div class="container">
<?php
if(isset($ProceedSend))
{
	if(SQLCount("admin_users","WHERE email='".$user_email."'") == 1)
	{
		$arrUser = DataArray("admin_users","email='".$user_email."'");
		
		$arrChars = array("A","F","B","C","O","Q","W","E","R","T","Z","X","C","V","N");
										
		$activationCode = md5("PW".$arrChars[rand(0,(sizeof($arrChars)-1))]."".rand(1000,9999).$arrChars[rand(0,(sizeof($arrChars)-1))].rand(1000,9999));
		$activationCode = substr($activationCode,0,25);					
	
		$message_text=
"Hello,

Someone filled out the password recovery form for you on the ".$BLOG_DOMAIN."
website. If it wasn't you, don't panic yet - they can't change your password
if they haven't received this email. You can just ignore this email, and
your password will remain unchanged.

You can continue on to setting a new password by going to:

http://www.".$BLOG_DOMAIN."/index.php?mod=change_password&key=".$activationCode;
	
		$headers  = "From: \"".$SYSTEM_EMAIL_FROM."\"<".$SYSTEM_EMAIL_ADDRESS.">\n";
		
		SQLUpdate_SingleValue
		(
			"admin_users",
			"email",
			"'".$user_email."'",
			"activation_code",
			$activationCode
		);
								
		if(mail($user_email, $M_PASSWORD_REMINDER_FOR." ".$BLOG_DOMAIN,$message_text, $headers))
		{
				echo "<b>".$M_PWD_SENT_SUCCESS."</b>";
		}
		else
		{
				echo "<b>".$M_ERROR_WHILE_SENDING.$user_email."</b>";
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
echo $M_PLEASE_ENTER_PWD_;
?>
</i>
<br><br><br>
<form action="index.php" method="post">
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
<?php echo $EMAIL;?>:  
<input type="text" size="20" name="user_email"> 
&nbsp;&nbsp;&nbsp;
<input type="submit" value=" <?php echo $GET_MY_PWD;?> " class="interface_button" >
</form>

<?php
}
?>

</div>

