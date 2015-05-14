<?php
include("../blog_config.php");
if($USE_SECURITY_IMAGES)
{
   session_start();
}
include("../ADMIN/Utils.php");
ms_i(get_param("comment"));
MySQL_OC();
$arrComment = DataArray_OC("comments","id=".get_param("comment"));
$arrAdminUser =  DataArray_OC("admin_users","username='".$arrComment["user"]."'");
MySQL_CC();
if(!isset($arrComment["id"])) die("");
if(!isset($arrAdminUser["id"])) die("");
include("blog_messages_".$arrAdminUser["blog_lang"].".php");
?>
<html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <title><?php echo $M_SEND_EMAIL_TO;?> <?php echo $arrComment["author"];?></title>
<style>
td{font-family:Verdana;font-size:11}
</style>
</head>
<body>


<?php

$showForm = true;

if(get_param("proceed") != "")
{
?>
<table summary="" border="0">
	<tr>
		<td>
		<?php
	
	if($_POST["sv"]!=md5($CAPTCHA_SALT.date("j").date("G").$BLOG_DOMAIN)) die("");
	
	if($USE_SECURITY_IMAGES && ( (md5($CAPTCHA_SALT.$_POST['code'].$CAPTCHA_SALT) != $_SESSION['code'])|| trim($_POST['code']) == "" ) )
	{
		echo "<font color=red><b>".$M_WRONG_SECURITY_IMAGE_CODE."</b></font><br>";
		
	}
	
	 else
	 {
	
					if(mail($arrComment["email"],get_param("subject"),get_param("message"),"From: \"".get_param("name2")."\"<".get_param("email").">\n"))
					{
						echo "<b>".$MESSAGE_SEND_SUCCESS."</b>";
					}
					else
					{
						echo "<b>An error resulted while trying to send your email!</b>";
					}
					
					$showForm = false; 
	}
	?>
	
	</td>
	</tr>
</table>
<?php
}


if($showForm)
{
?>


<form action="send_email.php" method="post">
<input type="hidden" name="sv" value="<?php echo md5($CAPTCHA_SALT.date("j").date("G").$BLOG_DOMAIN);?>">
				  
<input type=hidden name=proceed value="1">
<input type=hidden name=comment value="<?php echo $comment;?>">
<table summary="" border="0">
	<tr>
		<td colspan=2><b><?php echo $SEND_AN_EMAIL;?></b>
		<br><br>
		</td>
	</tr>
	<tr>
		<td><?php echo $M_TO;?>: </td>
		<td><b><?php echo $arrComment["author"];?></b></td>
	</tr>
	<tr>
		<td><?php echo $M_EMAIL;?>:</td>
		<td><input type=text name=email size=53 value="<?php echo get_param("email");?>"></td>
	</tr>
	<tr>
		<td><?php echo $M_NAME;?>:</td>
		<td><input type=text name=name2 size=53 value="<?php echo get_param("name2");?>"></td>
	</tr>
	<tr>
		<td><?php echo $M_TITLE;?>:</td>
		<td><input type=text name=subject size=53 value="<?php echo get_param("subject");?>"></td>
	</tr>
	<tr>
		<td><?php echo $M_MESSAGE2;?></td>
		<td><textarea name=message cols=40 rows=6><?php echo get_param("message");?></textarea></td>
	</tr>
	<?php
	if($USE_SECURITY_IMAGES)
	{
	?>
	<tr>
		<td colspan=2>
		
			
			<img src="sec_image.php" >
			
			
		
			<?php echo $M_CODE;?>:
			
			<input type="text" name="code" value="" size="8">	
		</td>
	</tr>

	<?php
	}
	?>
</table>
<input type="submit" value=" <?php echo $M_SEND;?> ">

</form>


        

<?php
}

?>
</body>
</html>