<?php				
if(isset($error))
{
?>

<?php
}
else
{
?>

<script>
	function ValidateLoginForm(x){
		if(x.Email.value==""){
			alert("<?php echo $USERNAME_EMPTY_FIELD_MESSAGE;?>");
			x.Email.focus();
			return false;
		}
		else
		if(x.Password.value==""){
			alert("<?php echo $PASSWORD_EMPTY_FIELD_MESSAGE;?>");
			x.Password.focus();
			return false;
		}
		return true;
	}
</script>
							


<form id="login_form" style="margin: 0" action="<?php echo($USE_ABSOLUTE_URLS?"http://www.".$BLOG_DOMAIN."/":"");?>USERSADMIN/loginaction.php" method="post" onsubmit="return ValidateLoginForm(this)">
<?php
echo "<input type=\"hidden\" name=\"sv\" value=\"".md5($CAPTCHA_SALT.date("j").date("z").$BLOG_DOMAIN)."\">";
?>
	
	<span class="login-label"><?php echo $M_USERNAME;?>:</span>
	
	<input tabindex="1" type="text" name="Email" id="Email" class="login_text_field">
	
	<span class="login-label"><?php echo $M_PASSWORD;?>:</span>
	
	<input  tabindex="2" name="Password" id="Password" type="password" class="login_text_field">
	<input tabindex="3" type="submit" value=" <?php echo $M_GO;?> " class="login-submit">
	
	<?php
	if(false && $ENABLE_FACEBOOK_LOGIN)
	{
		include("include/facebook.php");
		$facebook = new Facebook(array(
		  'appId'  => $FACEBOOK_APPID,
		  'secret' => $FACEBOOK_SECRET,
		  'cookie' => true,
		));
		$session = $facebook->getSession();

		$me = null;

		if ($session) 
		{
		  try 
		  {
			$uid = $facebook->getUser();
			$me = $facebook->api('/me');
		  } catch (FacebookApiException $e) {
			error_log($e);
		  }
		}

		  $loginUrl = 
			$facebook->getLoginUrl
			(
				array( 'next' => ($USE_ABSOLUTE_URLS?"http://www.".$BLOG_DOMAIN."/":"")."index.php?mod=facebook_signup")
			);
			
			$logoutUrl = 
			$facebook->getLogoutUrl
			(
				array( 'next' => ($USE_ABSOLUTE_URLS?"http://www.".$BLOG_DOMAIN."/":"")."index.php")
			);
			
		if ($me) 
		{
		
		
		  $arrBlogger = DataArray("admin_users","facebook_id=".$me["id"]);
		  if(!isset($error)&&isset($p_login)&&isset($arrBlogger["id"])&&$arrBlogger["username"]!="")
		  {
			
			define("SUCCESS_PAGE", "USERSADMIN/index.php");
			define("LOGIN_EXPIRE_AFTER", 48 * 3600);
			
			$strCookie=$arrBlogger["username"]."~".$arrBlogger["password"]."~".(time()+LOGIN_EXPIRE_AFTER);
			
			setcookie("Auth",$strCookie);	
			die("<script>document.location.href=\"".SUCCESS_PAGE."\";</script>");
			
			
		  }
		
		} 
		else 
		{
			
		
		}
	?>
		<div id="fb-root"></div>
		  <script>
		  window.fbAsyncInit = function() {
			FB.init({
			  appId   : '<?php echo $facebook->getAppId(); ?>',
			  session : <?php echo json_encode($session); ?>, 
			  status  : true, 
			  cookie  : true,
			  xfbml   : true
			});

			
			FB.Event.subscribe('auth.login', function() {
			  document.location.href="http://www.<?php echo $BLOG_DOMAIN;?>/index.php?p_login=1&mod=facebook_signup";
			
			});
		  };

		  (function() {
			var e = document.createElement('script');
			e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
			e.async = true;
			document.getElementById('fb-root').appendChild(e);
		  }());
		</script>
		
		<?php
		if($me)
		{
		?>
			
			<a href="<?php if($USE_ABSOLUTE_URLS) echo "http://www.".$BLOG_DOMAIN."/index.php?p_login=1&mod=facebook_signup";?>">
			  <img src="images/fbconnect_login.jpg" border="0" width="65" height="22">
			</a>
		<?php
		}
		else
		{
		?>
			<fb:login-button></fb:login-button>
		<?php
		}
		?>
		
	<?php
	}
	?>
	<!--
	<a <?php if($ENABLE_FACEBOOK_LOGIN) echo 'style="float:right;margin-right:20px"';?> href="<?php if($USE_ABSOLUTE_URLS) echo "http://www.".$BLOG_DOMAIN."/forgotten_password.html";else echo "index.php?mod=forgotten_password";?>" ><?php echo $M_FORGOTTEN_PASSWORD;?></a>
	-->
	</form>

<?php
}
?>
